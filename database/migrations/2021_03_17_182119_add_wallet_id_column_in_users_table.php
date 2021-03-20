<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddWalletIdColumnInUsersTable extends Migration
{
    private $table = 'users';
    public function up()
    {
        Schema::table($this->table, function (Blueprint $table) {
            $table->unsignedInteger('wallet_id');
            $table->foreign('wallet_id')->references('id')->on('wallets');
        });
    }

    public function down()
    {
        Schema::table($this->table, function (Blueprint $table) {
            $table->dropForeign('users_wallet_id_foreign');
            $table->dropColumn('wallet_id');
        });
    }
}
