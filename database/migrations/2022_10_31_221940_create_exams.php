<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->string("type");
            $table->text("description");
            $table->integer("q_number");
            $table->integer("q_time");
            $table->integer("neg_score")->default(0);
            $table->integer("is_active")->default(0);
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
        Schema::dropIfExists('exams');
    }
};
