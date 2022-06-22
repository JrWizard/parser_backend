<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCronJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('cron_jobs', static function (Blueprint $table) {
            $table->id();
            $table->integer('cron_job_id');
            $table->string('name', 90);
            $table->string('expression');
            $table->string('url');
            $table->string('email_me', 30);
            $table->integer('log');
            $table->string('post')->nullable();
            $table->string('status', 10);
            $table->float('execution_time', 20, 3);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('cron_jobs');
    }
}
