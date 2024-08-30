<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    protected $model = User::class;

    // public function definition()
    // {
    //     return [
    //         'first_name' => $this->faker->name,
    //         'last_name' => $this->faker->name,
    //         'phone' => $this->faker->number,
    //         'email' => $this->faker->unique()->safeEmail,
    //         'email_verified_at' => now(),
    //         'password' => bcrypt('password'),
    //         'remember_token' => Str::random(10),
    //     ];
    // }
    public function run()
    {
        User::factory()->count(25)->create();
    }
}
