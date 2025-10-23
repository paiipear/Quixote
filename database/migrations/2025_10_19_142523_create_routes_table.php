<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoutesTable extends Migration
{
    public function up()
    {
        Schema::create('routes', function (Blueprint $table) {
            $table->id();
            $table->string('origin');
            $table->string('destination');
            $table->integer('distance_km')->nullable();
            $table->timestamps();
            $table->unique(['origin','destination']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('routes');
    }
}
