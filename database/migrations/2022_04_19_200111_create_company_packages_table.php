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
        Schema::create('company_packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')->constrained()->onDelete('cascade');
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->foreignId('company_payment_id')->constrained(); //ödeme yöntemi bilgisini tutar
            $table->unsignedTinyInteger('period_type'); //ödeme periyodu aylık mı yıllık mı bilgisini tutar.
            $table->boolean('auto_pay'); //otomatik ödeme yapılsın mı ?
            $table->boolean('repeat'); //paket bitiminde tekrarlansın mı ?
            $table->date('expired_at')->nullable(true); //Paket bitiş tarihi bilgisinin tutmaktadır.
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
        if(Schema::hasTable('company_packages'))
        {
            Schema::table('company_packages', function (Blueprint $table) {
                $table->dropForeign(['package_id']);
                $table->dropForeign(['company_id']);
            });
        }
        Schema::dropIfExists('company_packages');
    }
};
