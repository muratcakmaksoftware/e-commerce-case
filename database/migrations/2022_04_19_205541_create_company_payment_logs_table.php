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
        Schema::create('company_payment_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_payment_period_id')->constrained()->onDelete('cascade');
            $table->unsignedTinyInteger('type');//hata türlerini tutar: unsuccessful, timeout, unknown error gibi
            $table->text('description'); //hata detay bilgisini tutar
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
        if(Schema::hasTable('company_payment_logs'))
        {
            Schema::table('company_payment_logs', function (Blueprint $table) {
                $table->dropForeign(['company_payment_period_id']);
            });
        }
        Schema::dropIfExists('company_payment_logs');
    }
};
