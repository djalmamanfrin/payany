# PayAny Documentation
###Objetivo Simplificado
Temos 2 tipos de usuários, os comuns e lojistas, ambos têm carteira com dinheiro e realizam transferências entre eles. Atenção: fluxo de transferência somenteentre dois usuários.

Requisitos:
- Antes de finalizar a transferência, deve-se consultar um serviço autorizador externo, use este mock para simular (https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6).
- A operação de transferência deve ser uma transação (ou seja, revertida em qualquer caso de inconsistência) e o dinheiro deve voltar para a carteira do usuário que envia.
- No recebimento de pagamento, o usuário ou lojista precisa receber notificação (envio de email, sms) enviada por um serviço responśavel pela notificação podendo estar indisponível/instável. Use este mock para simular o envio (http://o4d9z.mocklab.io/notify). 
- Este serviço deve ser RESTFul.
