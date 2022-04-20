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
        Schema::create('company_payment_periods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_package_id')->constrained()->onDelete('cascade');
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->date('payment_at'); //ödeme tarihi
            $table->unsignedDecimal('price'); //o zamanki paketin perioda göre ayrılmış ödeme fiyatı.
            $table->boolean('status')->default(0);//ödeme gerçekleşmiş mi kontrolü
            $table->boolean('approval')->default(0);//muhasebe ödemeyi onaylamış mı kontrolü
            $table->softDeletes(); //deleted_at
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
        if(Schema::hasTable('company_payment_periods'))
        {
            Schema::table('company_payment_periods', function (Blueprint $table) {
                $table->dropForeign(['company_package_id']);
                $table->dropForeign(['company_id']);
            });
        }
        Schema::dropIfExists('company_payment_periods');
    }
};
