<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Notifications extends Migration
{
    private $table = 'notifications';
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('transaction_id');
            $table->json('payload');
            $table->integer('status_code');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->foreign('transaction_id')->references('id')->on('transactions');
        });
    }

    public function down()
    {
        Schema::dropIfExists($this->table);
    }
}
