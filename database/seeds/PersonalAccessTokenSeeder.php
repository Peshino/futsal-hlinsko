<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Laravel\Sanctum\PersonalAccessToken;

class PersonalAccessTokenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PersonalAccessToken::firstOrCreate([
            'tokenable_type' => 'App\User',
            'tokenable_id' => '1',
            'name' => 'futsal_hlinsko_api_token',
            'token' => 'ceeb2b74120a33e1de3b23608aef008e504109d676f03b994bff467b5e72337f',
            'abilities' => '["*"]',
        ]);
    }
}
