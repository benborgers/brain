<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotecardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notecards', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('markdown')->nullable();
            $table->foreignId('folder_id')->constrained('folders')->onDelete('cascade');
            $table->boolean('public')->default(false);
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
        Schema::dropIfExists('notecards');
    }
}
