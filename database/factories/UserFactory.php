<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'id' => (string) Str::uuid(),
            'username' => $this->faker->unique()->userName(),
            'password' => bcrypt('password'), // You can use Hash::make('password') if you prefer
            'first_name' => $this->faker->firstName(),
            'middle_name' => $this->faker->optional()->firstName(),
            'last_name' => $this->faker->lastName(),
            'photo' => $this->faker->optional()->imageUrl(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => $this->faker->optional()->dateTime(),
            'phone_number' => $this->faker->optional()->phoneNumber(),
            'department_id' => $this->faker->optional()->uuid(),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
