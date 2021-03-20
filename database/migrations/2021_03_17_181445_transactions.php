<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Transactions extends Migration
{
    private $table = 'transactions';
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('payer_id');
            $table->unsignedInteger('payee_id');
            $table->unsignedInteger('status_id')->default(1);
            $table->float('value', 10, 2);
            $table->enum('type', ['transfer']);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->foreign('payer_id')->references('id')->on('users');
            $table->foreign('payee_id')->references('id')->on('users');
            $table->foreign('status_id')->references('id')->on('status');
        });
    }

    public function down()
    {
        Schema::dropIfExists($this->table);
    }
}
