<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            "permission" => [ "View", "Grant", "Revoke", "Manage Role"],
            "role" => [ "View", "Read", "Create", "Update", "Delete", "Assign", "Revoke", "Manage"],
            "user" => [ "View", "Read", "Create", "Update", "Delete", "Assign Role To", "Revoke Role From", "Manage"],
        ];

        foreach ($permissions as $key => $abilities) {
            
            $name = "$key";

            $permission = [];

            foreach ($abilities as $ability) {

                if($ability === "View" || strpos($ability, "Manage")){
                    $name = "$ability $key"."s";
                }else {
                    $name = "$ability $key";
                }

                $permission["name"] = $name;

                $permission["key"] = str_replace(" ", "_", strtolower($name));

                $permission["slug"] = str_replace(" ", "-", strtolower($name));

                $permission["description"] = "Permission to " . strtolower($name);

                Permission::create($permission);
            }

            // Create some sample permissions
           /*  Permission::create([
                'name' => 'View Users',
                'slug' => 'view-users',
                'key' => 'view_users',
                'description' => 'Permission to view users',
            ]); */
        }

        /**
         * edit-own-profile: Grants permission to edit one's own user profile.
         * view-any-user-profile: Allows viewing any user's profile.
         * view-own-profile: Determines if a user can view their own profile.
         * manage-user-permissions: Combines permissions related to managing user permissions.
         * manage-user-settings: Controls access to user settings and preferences.
         */

        // Create some sample permissions
        /* Permission::create([
            'name' => 'View Users',
            'slug' => 'view-users',
            'key' => 'view_users',
            'description' => 'Permission to view users',
        ]);

        Permission::create([
            'name' => 'Create Users',
            'slug' => 'create-users',
            'key' => 'create_users',
            'description' => 'Permission to create new users',
        ]);

        Permission::create([
            'name' => 'Edit Users',
            'slug' => 'edit-users',
            'key' => 'edit_users',
            'description' => 'Permission to edit existing users',
        ]);

        Permission::create([
            'name' => 'Delete Users',
            'slug' => 'delete-users',
            'key' => 'delete_users',
            'description' => 'Permission to delete users',
        ]);

        Permission::create([
            'name' => 'Manage Users',
            'slug' => 'manage-users',
            'key' => 'manage_users',
            'description' => 'Permission to manage users',
        ]);

        Permission::create([
            'name' => 'View Roles',
            'slug' => 'view-roles',
            'key' => 'view_roles',
            'description' => 'Permission to view roles',
        ]);

        Permission::create([
            'name' => 'Create Role',
            'slug' => 'create-role',
            'key' => 'create_role',
            'description' => 'Permission to create new role',
        ]);
        
        Permission::create([
            'name' => 'Edit Roles',
            'slug' => 'edit-roles',
            'key' => 'edit_roles',
            'description' => 'Permission to edit roles',
        ]);
        
        Permission::create([
            'name' => 'Delete Roles',
            'slug' => 'delete-roles',
            'key' => 'delete_roles',
            'description' => 'Permission to delete roles',
        ]);

        Permission::create([
            'name' => 'Manage Roles',
            'slug' => 'manage-roles',
            'key' => 'manage_roles',
            'description' => 'Permission to manage roles',
        ]);
        
        Permission::create([
            'name' => 'View Permissions',
            'slug' => 'view-permissions',
            'key' => 'view_permissions',
            'description' => 'Permission to view permissions',
        ]);
        
        Permission::create([
            'name' => 'Edit Permissions',
            'slug' => 'edit-permissions',
            'key' => 'edit_permissions',
            'description' => 'Permission to edit permissions',
        ]);
        
        Permission::create([
            'name' => 'Delete Permissions',
            'slug' => 'delete-permissions',
            'key' => 'delete_permissions',
            'description' => 'Permission to delete permissions',
        ]);
 */
    }
}
