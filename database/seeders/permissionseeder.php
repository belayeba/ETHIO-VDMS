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
        DB::table( 'model_has_roles' )->truncate();
        DB::table( 'role_has_permissions' )->truncate();

        // Truncate tables with foreign key constraints
        Role::query()->delete();
        Permission::query()->delete();
        PermissionGroup::query()->delete();

        $adminRole = Role::create( [ 'name' => 'Admin' ] );
        $editorRole = Role::create( [ 'name' => 'Editor' ] );

        $permission_data = [
            [
                'permission_group' => 'User Management',
                'permissions' => [
                    'Create User',
                    'Create Driver',
                    'Change Driver',
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
                ]
            ],
        ];

        foreach ( $permission_data as $group ) {
            $permissions = $group[ 'permissions' ];
            $groupId = PermissionGroup::create( [ 'name' => $group[ 'permission_group' ] ] )->id;

            foreach ( $permissions as $permission ) {
                Permission::create( [ 'name' => $permission, 'group_id' => $groupId ] );

                // Assign all permissions to the Admin role
                $permissionId = Permission::where( 'name', $permission )->first()->id;
                $adminRole->permissions()->attach( $permissionId );
            }
        }
    }
    // public function run(): void
    // {
    //     //
    //     $adminRole = Role::create( [ 'name' => 'Admin' ] );
    //     $editorRole = Role::create( [ 'name' => 'Editor' ] );

    //     // Create permissions
    //     $permissions = [
    //         'create posts',
    //         'edit posts',
    //         'user-list',
    //         'user-create',
    //         'user-edit',
    //         'user-delete',
    //         'role-list',
    //         'role-create',
    //         'role-edit',
    //         'role-delete',

    // ];

    //      foreach ( $permissions as $permission ) {
    //           Permission::create( [ 'name' => $permission ] );
    //      }

    //     // Assign permissions to roles

    //     $permissions = Permission::pluck( 'id', 'id' )->all();

    //     $adminRole->syncPermissions( $permissions );

    //     $adminuser = User::where( 'username', 'superUser' )->first();
    //     if ( $adminuser ) {
    //         $adminuser->assignRole( $adminRole );
    //     }

    // }
}
