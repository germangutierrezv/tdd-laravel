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
    Schema::create('tasks', function (Blueprint $table) {
      $table->id();
      $table->string('title');
      $table->text('body')->nullable();
      $table->tinyInteger('priority')->default(0);
      $table->dateTime('completed_at')->nullable();
      $table->dateTime('due_at')->nullable();
      $table->integer('order')->default(0);

      $table->unsignedInteger('project_id');
      $table->foreign('project_id')
        ->references('id')->on('projects')
        ->onDelete('cascade');

      $table->unsignedInteger('user_id');
      $table->foreign('user_id')
        ->references('id')
        ->on('users')
        ->onDelete('cascade');
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
    Schema::dropIfExists('tasks');
  }
};
