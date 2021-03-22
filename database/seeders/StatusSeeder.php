<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use PayAny\Models\Status;

class StatusSeeder extends Seeder
{
    public function run()
    {
        $records = [
            ['id' => 1, 'tittle' => 'Novo', 'description' => "Nova transação recebida"],
            ['id' => 2, 'tittle' => 'Autorizado', 'description' => "Status utilizado quando a transação é autorizada"],
            ['id' => 3, 'tittle' => 'Não Autorizado', 'description' => "Status utilizado quando a transação NÂO é autorizada"],
            ['id' => 4, 'tittle' => 'Beneficiário Creditado', 'description' => "Status utilizado quando o valor da transação é creditado da conta"],
            ['id' => 5, 'tittle' => 'Beneficiário Não Creditado', 'description' => "Status utilizado quando algum erro ocorre e o valor da transação NÂO é creditado da conta"],
            ['id' => 6, 'tittle' => 'Pagador Debotado', 'description' => "Status utilizado quando o valor da transação é debotado da conta"],
            ['id' => 7, 'tittle' => 'Pagador Não Debotado', 'description' => "Status utilizado quando algum erro ocorre e o valor da transação NÂO é debotado da conta"],
            ['id' => 8, 'tittle' => 'Notificacao Enviada', 'description' => "Status utilizado após serviço de notificação receber com sucesso a mensagem"],
            ['id' => 9, 'tittle' => 'Notificacao Não Enviada', 'description' => "Status utilizado quando o serviço de notificação está indisponível"],
        ];
        Status::query()->insert($records);
    }
}
