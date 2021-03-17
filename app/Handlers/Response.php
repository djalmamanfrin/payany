<?php


namespace PayAny\Handlers;


use Countable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;
use InvalidArgumentException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Response  extends \Symfony\Component\HttpFoundation\Response
{
    private Request $request;
    protected array $responseHeaders = ['Content-Type' => 'application/json'];

    public function __construct(Request $request)
    {
        parent::__construct('', self::HTTP_OK, $this->responseHeaders);
        $this->request = $request;
    }

    public function success(int $code, $content = []): JsonResponse
    {
        $data['message'] = showText('messages.status', $code);
        $data['dict'] = $this->getDict();
        if ($content instanceof Paginator
            || $content instanceof LengthAwarePaginator) {
            $data['meta'] = $content->toArray();
            unset($data['meta']['first_page_url']);
            unset($data['meta']['last_page_url']);
            unset($data['meta']['next_page_url']);
            unset($data['meta']['prev_page_url']);
            unset($data['meta']['path']);
            $data['data'] = $data['meta']['data'];
            unset($data['meta']['data']);
            return response()->json($data, $code);
        }
        if ($content instanceof Model || $content instanceof Collection) {
            $data['data'] = $content->toArray();
            return response()->json($data, $code);
        }
        if (is_array($content)) {
            $data['data'] = $content;
            return response()->json($data, $code);
        }
        $message = 'The content parameter must be an Model, Collection or array instance';
        throw new InvalidArgumentException($message);
    }

    public function error($e): JsonResponse
    {
        $code = $this->getExceptionCode($e);
        $data['message'] = 'Could not complete the request.';
        $this->setStatusCode($code);
        $data['errors'] = [
            'status_code' => $this->getStatusCode(),
            'status_text' => $this->statusText,
        ];
        if (! empty($e->getMessage())) {
            $data['errors']['error_text'] = $e->getMessage();
            if (isDevelop() || isTesting()) {
                $data['errors'] = array_merge($data['errors'], [
                    'file' => $e->getFile(),
                    'line' => $e->getLine()
                ]);
            }
        }
        empty($e->getMessage()) ?: $data['errors']['error_text'] = $e->getMessage();
        if ($e instanceof ValidationException) {
            $data['errors']['error_text'] = $e->errors();
        }
        $data['message'] = showText('messages.status', $code);
        report($e);
        return response()->json($data, $code);
    }

    final private function getExceptionCode($e): int
    {
        if ($e instanceof ModelNotFoundException || $e instanceof NotFoundHttpException) {
            return self::HTTP_NOT_FOUND;
        }
        $code = is_numeric($e->getCode()) ? $e->getCode() : 0;
        if (!(bool) $code) {
            try {
                $code = $e->status;
            } catch (Throwable $e) {
                $code = null;
            }
        }
        if (is_null($code)) {
            try {
                $code = $e->getStatusCode();
            } catch (Throwable $e) {
                $code = self::HTTP_BAD_REQUEST;
            }
        }
        return $code;
    }

    final private function getContentCount($content): int
    {
        if ($content instanceof Countable) {
            return $content->count();
        }
        return 1;
    }

    public function getDict(): array
    {
        $config = $this->request->route()[1]['as'] ?? null;
        return config('dictionaries/' . $config, []);
    }
}
