<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomePagesTable extends Migration
{
    public function up()
    {
        Schema::create('home_pages', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('slug')->unique();
            // Outros campos conforme necessário
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('home_pages');
    }
}
