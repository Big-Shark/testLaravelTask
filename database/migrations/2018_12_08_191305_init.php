<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Init extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('download_tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('url');
            $table->string('file_path')->nullable();
            $table->string('status');
            $table->timestamp('download_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('download_tasks');
    }
}
