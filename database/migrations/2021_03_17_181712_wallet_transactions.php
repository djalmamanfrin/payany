<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class WalletTransactions extends Migration
{
    private $table = 'wallet_transactions';
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('wallet_id');
            $table->unsignedInteger('transaction_id');
            $table->enum('type', ['transfer', 'credit', 'debit']);
            $table->float('value', 10, 2);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->foreign('wallet_id')->references('id')->on('wallets');
            $table->foreign('transaction_id')->references('id')->on('transactions');
        });
    }

    public function down()
    {
        Schema::dropIfExists($this->table);
    }
}
