<?php

namespace Database\Factories\Organization;

use App\Models\Organization\ClustersModel;
use App\Models\Organization\DepartmentsModel;
use App\Models\User; // Import the DepartmentsModel
use Illuminate\Database\Eloquent\Factories\Factory; // Import the ClustersModel
use Illuminate\Support\Str; // Import the User model

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Organization\Department>
 */
class DepartmentsModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'department_id' => (string) Str::uuid(),
            'name' => $this->faker->name,
            'cluster_id' => ClustersModel::first()->cluster_id,
            // 'description' => $this->faker->sentence(),
            'created_by' => User::first()->id, // Ensure a valid user ID is used
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
