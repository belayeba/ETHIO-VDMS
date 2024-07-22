<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class permissionseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $adminRole = Role::create(['name' => 'Admin']);
        $editorRole = Role::create(['name' => 'Editor']);
        
        // Create permissions
        $permissions = [
            'create posts',
            'edit posts',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
 
         ];
      
         foreach ($permissions as $permission) {
              Permission::create(['name' => $permission]);
         }

        // Assign permissions to roles
     
        $permissions = Permission::pluck('id','id')->all();
   
        $adminRole->syncPermissions($permissions);

        $adminuser = User::where('username', 'superUser')->first();
        if ($adminuser) {
            $adminuser->assignRole($adminRole);
        }
     

        
    }
}
