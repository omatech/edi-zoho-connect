<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateZohoFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zoho_forms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('inst_id')->nullable();
            $table->string('language');
            $table->string('status');
            $table->string('email_admin')->nullable();
            $table->string('form');
            $table->json('data')->nullable();
            $table->string('url')->nullable();
            $table->json('data_api')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('zoho_forms');
    }
}
