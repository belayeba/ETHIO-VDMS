<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $adminUser = User::create([
            'id' => Str::uuid(),
            'first_name' => 'Admin User',
            'email' => 'other@gmail.com',
            'password' => Hash::make('Fleet@Aii#1234'),
            'last_name' => 'testlast'
        ]);

        $adminRole = Role::where('name', 'Admin')->first(); 
        if ($adminRole) {
            $adminUser->assignRole($adminRole); 
        } else {
            echo "Admin role does not exist. Please ensure roles are seeded first.\n";
        }
    }
}
