<?php

return [
    'transfer' => [
        'fields' => [
            'payer_id' => ['required', 'numeric', 'exists:users,id'],
            'payee_id' => ['required', 'numeric'],
            'value' => ['required', 'numeric', 'min:1']
        ],
        'messages' => [
            'payer_id.required' => 'The field payer_id must be informed',
            'payer_id.numeric' => 'The field payer_id must be numeric',
            'payer_id.exists' => 'The field payer_id informed not exist',
            'payee_id.required' => 'The field payee_id must be informed',
            'payee_id.numeric' => 'The field payee_id must be numeric',
            'payee_id.exists' => 'The field payee_id informed not exist',
            'value.required' => 'The field value must be informed',
            'value.numeric' => 'The field value must be numeric',
            'value.min' => 'The field value must be greater than or equal then 1'
        ]
    ]
];
