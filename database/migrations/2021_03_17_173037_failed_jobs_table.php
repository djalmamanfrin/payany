<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FailedJobsTable extends Migration
{
    private string $table = 'failed_jobs';
    public function up()
    {
        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->increments('id');
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
        });
    }

    public function down()
    {
        Schema::dropIfExists($this->table);
    }
}
