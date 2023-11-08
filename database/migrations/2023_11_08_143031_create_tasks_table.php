<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('module_id');
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('task_number');
            $table->string('title');
            $table->text('description');
            $table->string('status');
            $table->unsignedBigInteger('assignee_id');
            $table->unsignedBigInteger('reporter_id');
            $table->timestamps();

            $table->foreign('module_id')->references('id')->on('modules');
            $table->foreign('project_id')->references('id')->on('projects');
            $table->foreign('assignee_id')->references('id')->on('users');
            $table->foreign('reporter_id')->references('id')->on('users');
            $table->unique(['module_id', 'task_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
