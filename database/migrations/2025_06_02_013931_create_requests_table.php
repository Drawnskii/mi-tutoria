<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestsTable extends Migration
{
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')
                  ->constrained('students', 'user_id')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->foreignId('schedule_id')
                  ->default(2)
                  ->constrained('schedules')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->foreignId('state_id')
                  ->constrained('states')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');
            $table->string('subject');
            $table->text('reason');
            $table->dateTime('request_date');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('requests');
    }
}
