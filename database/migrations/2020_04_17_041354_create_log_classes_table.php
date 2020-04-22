<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_classes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('transaction_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('class_id')->unsigned();
            $table->text('transaction_code');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log_classes');
    }
}
