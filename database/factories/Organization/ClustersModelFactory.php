<?php

namespace Database\Factories\Organization;

use App\Models\Organization\ClustersModel;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ClustersModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ClustersModel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'cluster_id' => (string) Str::uuid(),
            'name' => $this->faker->name,
            'created_by' => User::first()->id, // Ensure a valid user ID is used
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
