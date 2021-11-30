<?php

use App\User;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get('database/data/users.json');
        $objects = json_decode($json);
        foreach ($objects as $object) {
            User::create([
                'firstname' => $object->firstname,
                'lastname' => $object->lastname,
                'email' => $object->email,
                'email_verified_at' => Carbon::now(),
                'password' => bcrypt($object->password),
                'remember_token' => Str::random(10)
            ]);
        }
    }
}
