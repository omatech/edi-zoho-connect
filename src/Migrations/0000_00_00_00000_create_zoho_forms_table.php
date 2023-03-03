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
            $table->string('inst_id');
            $table->string('language');
            $table->string('status');
            $table->string('email_admin');
            $table->string('form');
            $table->json('data');
            $table->string('url');
            $table->json('data_api');
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
