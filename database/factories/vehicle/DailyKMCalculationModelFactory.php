<?php

namespace Database\Factories\vehicle;

use App\Models\Vehicle\DailyKMCalculationModel;
use Illuminate\Http\Request;
use App\Models\Organization\DepartmentsModel;
use App\Models\Driver\DriversModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class DailyKMCalculationModelFactory extends Factory
{
    protected $model = DailyKMCalculationModel::class;

    public function definition()
    {
        return [
            'calculation_id' => (string) Str::uuid(),
            'vehicle_id' => 1,
            'driver_id' => 1,
            'date' => $this->faker->date(),
            'morning_km' => $this->faker->randomFloat(8, 0, 99), // Generates value within valid range
            'afternoon_km' => $this->faker->randomFloat(8, 0, 99), // Generates value within valid range
            'register_by' => User::factory(),
        ];
    }
}
