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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();

            $table->integer('type')->nullable();
            $table->foreignId('createdby_id')->nullable();
            $table->foreignId('ticket_id')->nullable();
            $table->string('report_number')->nullable();
            $table->string('machine_model')->nullable();
            $table->string('machine_serialno')->nullable();
            $table->string('cust_name')->nullable();

            $table->string('invoice_number')->nullable();
            $table->date('invoice_date')->nullable();

            $table->string('purchase_order')->nullable();
            $table->date('purchase_order_date')->nullable();
            $table->string('service_mode')->nullable();

            $table->string('asset_number')->nullable();
            $table->date('installation_date')->nullable();
            $table->string('location')->nullable();
            $table->string('under_warranty')->nullable();
            $table->string('warranty_period')->nullable();
            $table->string('amc_required')->nullable();

            $table->longText('installation_notes')->nullable();
            $table->longText('spare_parts')->nullable();
            $table->longText('customer_notes')->nullable();

            $table->string('eng1_name')->nullable();
            $table->string('eng1_phone')->nullable();
            $table->longText('eng1_sign')->nullable();
            $table->string('eng2_name')->nullable();
            $table->string('eng2_phone')->nullable();
            $table->longText('eng2_sign')->nullable();
            $table->string('eng3_name')->nullable();
            $table->string('eng3_phone')->nullable();
            $table->longText('eng3_sign')->nullable();
            $table->string('eng4_name')->nullable();
            $table->string('eng4_phone')->nullable();
            $table->longText('eng4_sign')->nullable();

            $table->string('cust1_name')->nullable();
            $table->string('cust1_phone')->nullable();
            $table->longText('cust1_sign')->nullable();
            $table->string('cust2_name')->nullable();
            $table->string('cust2_phone')->nullable();
            $table->longText('cust2_sign')->nullable();
            $table->string('cust3_name')->nullable();
            $table->string('cust3_phone')->nullable();
            $table->longText('cust3_sign')->nullable();
            $table->string('cust4_name')->nullable();
            $table->string('cust4_phone')->nullable();
            $table->longText('cust4_sign')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
