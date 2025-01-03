<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as FakerFactory;
class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    public function definition()
    {
        $faker = FakerFactory::create('it_IT');

        return [
            'nome' => $faker->firstName(),
            'cognome' => $faker->lastName(),
            'username' => $faker->unique()->userName(),
            'data_nascita' => $faker->date(),
            'email' => $faker->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'stato' => 'normale',
            'avatar' => false
        ];
    }
}