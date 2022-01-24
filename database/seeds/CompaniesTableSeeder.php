<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        for($i = 1; $i <= 10; $i++)
        {

            // insert data ke table pegawai menggunakan Faker
            DB::table('companies')->insert([
                'name' => $faker->company,
                'email' => $faker->email,
                'logo' => '1642930482_ashr.png',
                'website' => $faker->email,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
