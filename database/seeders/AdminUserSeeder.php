<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create permissions
        $permissions = [
            ['name' => 'view-any-user', 'model' => 'user', 'created_by' => 1],
            ['name' => 'view-user', 'model' => 'user', 'created_by' => 1],
            ['name' => 'create-user', 'model' => 'user', 'created_by' => 1],
            ['name' => 'update-user', 'model' => 'user', 'created_by' => 1],
            ['name' => 'delete-user', 'model' => 'user', 'created_by' => 1],
            ['name' => 'restore-user', 'model' => 'user', 'created_by' => 1],
            ['name' => 'force-delete-user', 'model' => 'user', 'created_by' => 1]
        ];
        
        $adminRole = Role::firstOrCreate([
            'name' => 'Super Admin', 
            'description' => 'Default admin SuperUser',
            'created_by' => 1 ,
        ]);
        
        foreach ($permissions as $permission) {
            $createdPermission = Permission::firstOrCreate([
                'name' => $permission['name'],
                'model' => $permission['model'],
                'created_by' => 1 
            ]);
        }
        // Create admin role and assign all permissions to it
        
        $adminRole->permissions()->sync(Permission::all());

        // Create the admin user 'machina'
        $adminUser = User::firstOrCreate(
            ['email' => 'machinamaiki@gmail.com'],
            [
                'name' => 'Emanueli Maiki',
                'password' => bcrypt('Password'), // You should probably use a stronger, hashed password here
                'role_id' => $adminRole->id // Assuming you're using a direct relation `role_id` on the users table
            ]
        );
    }
}
