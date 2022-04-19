<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\CompanyPayment;
use App\Models\Domain;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Kullanıcı oluştur
         * Kullanıcıya ait şirket oluştur
         * Şirkete ait domain oluştur.
         * Şirkete ait ödeme yöntemi oluştur
         */
        User::factory(1)
            ->has(Company::factory(1)
                ->has(Domain::factory(1)
            )->has(CompanyPayment::factory(1)
        ))->create();


    }
}
