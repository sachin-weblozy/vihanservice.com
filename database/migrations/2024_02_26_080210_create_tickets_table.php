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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable();
            $table->string('machine_model')->nullable();
            $table->string('machine_serial')->nullable();
            $table->string('issue_type_id')->nullable();
            $table->string('issue_specs_id')->nullable();
            $table->string('issue_subspecs_id')->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('type')->nullable();
            $table->date('inst_start')->nullable();
            $table->date('inst_end')->nullable();
            $table->date('purchase_order_date')->nullable();
            $table->string('file_path')->nullable();
            $table->string('status')->nullable();
            $table->timestamp('solved_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
