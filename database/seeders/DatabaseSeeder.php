<?php

namespace Database\Seeders;

use Database\Factories\UserFactory;
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
        $userFactory = new UserFactory();
        $userFactory->createOne();

        $this->call([
            PaymentServiceSeeder::class,
        ]);
    }
}
