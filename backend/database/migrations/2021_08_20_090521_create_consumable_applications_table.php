<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsumableApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consumable_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consumable_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('applicant_id')->constrained('users');
            $table->foreignId('approver_id')->nullable()->constrained('users');
            $table->unsignedBigInteger('number');
            $table->tinyInteger('status');
            $table->text('description')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('consumable_applications');
    }
}
