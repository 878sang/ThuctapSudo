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
        Schema::table('orders', function (Blueprint $table) {
            $table->boolean('is_vat')->default(false)->after('payment_method');
            $table->string('company_name')->nullable()->after('is_vat');
            $table->string('company_email')->nullable()->after('company_name');
            $table->string('tax_code')->nullable()->after('company_email');
            $table->string('company_address')->nullable()->after('tax_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
};
