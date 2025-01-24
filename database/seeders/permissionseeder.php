<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\PermissionGroup;
use Illuminate\Support\Facades\DB;

class permissionseeder extends Seeder {
    /**
    * Run the database seeds.
    */

    public function run(): void {

        // Remove relationships before truncating
        // DB::table( 'model_has_roles' )->truncate();
        // DB::table( 'role_has_permissions' )->truncate();

        // Truncate tables with foreign key constraints
        // Role::query()->delete();
        // Permission::query()->delete();
        // PermissionGroup::query()->delete();

        $adminRole = Role::create( [ 'name' => 'Admin' ] );
        

        $permission_data = [
            [
                'permission_group' => 'User Management',
                'permissions' => [
                    'Create User',
                    'Create Driver',
                    'Change Driver',
                    'Accept Driver Change',
                ]
            ],
            [
                'permission_group' => 'Organization',
                'permissions' => [
                    'Create Department',
                    'Create Cluster',
                ]
            ],
            [
                'permission_group' => 'Roles',
                'permissions' => [
                    'Create Role',
                ]
            ],
            [
                'permission_group' => 'Vehicle Temporary Request',
                'permissions' => [
                    'Temporary Request Page',
                    'Director Approval Page',
                    'Clustor Director Apporal Page',
                    'HR Cluster Director Approval Page',
                    'Transport Director',
                    'Dispatcher Page',
                ]
            ],
            [
                'permission_group' => 'Vehicle Parmanent Request',
                'permissions' => [
                    'Permanent Request Page',
                    'Vehicle Director Page',
                    'Dispatcher',
                ]
            ],
            [
                'permission_group' => 'Vehicle Management',
                'permissions' => [
                    'Vehicle Registration',
                    'Vehicle Part Registration',
                    'Vehicle Inspection',
                    'Daily KM Registration',
                    'Approve Replacement'
                ]
            ],
            [
                'permission_group' => 'Return Permanent Vehicle',
                'permissions' => [
                    'Request Return',
                    'Approve Return',
                    'Take Back to Transport',
                ]
            ],
            [
                'permission_group' => 'Fuel Management',
                'permissions' => [
                    'Request Fuel',
                    'Finance Accept',
                    'Set Fuel Cost',
                ]
            ],
            [
                'permission_group' => 'Maintenance Management',
                'permissions' => [
                    'Request Maintenance',
                    'Approve Maintenance',
                    'Inspect Maintenance',
                    'Maintenance for Dispatcher',
                    'Final Maintenance',
                ]
            ],
            [
                'permission_group' => 'Route Management',
                'permissions' => [
                    'Route Registration',
                    'Assign Employee to Route',
                    'Change Route For Employee',
                    'Employee Change Route'
                ]
            ],
            [
                'permission_group' => 'Attendance',
                'permissions' => [
                    'Fill Attendance',
                    'View Attendance Report',
                ]
            ],
            [
                'permission_group' => 'Letter Management',
                'permissions' => [
                    'Letter Related',
                    'Attach Letter',
                    'Letter Review',
                    'Letter Approve',
                    'Purchase Letter',
                    'Finance Letter'
                ]
            ],
            [
                'permission_group' => 'Report Management',
                'permissions' => [
                    'Daily KM Report',
                    'Permananet Vehicle Request',
                    'Temporary Vehicle Request',
                    'Fuel Request',
                    'Maintance Request'
                ]
            ],
        ];
        foreach ($permission_data as $group) {
            $groupId = PermissionGroup::create(['name' => $group['permission_group']])->id;
    
            foreach ($group['permissions'] as $permission) {
                $createdPermission = Permission::create([
                    'name' => $permission,
                    'group_id' => $groupId,
                ]);
    
               
                $adminRole->givePermissionTo($createdPermission);
            }
        }
    }
}
