<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $adminRole = Role::where('name', 'admin')->first();
        $editorRole = Role::where('name', 'editor')->first();

        $manageArticles = Permission::where('name', 'manage articles')->first();
        $manageUsers = Permission::where('name', 'manage users')->first();
        $viewAnalytics = Permission::where('name', 'view analytics')->first();

        $adminRole->permissions()->attach([$manageArticles->id, $manageUsers->id, $viewAnalytics->id]);
        $editorRole->permissions()->attach([$manageArticles->id]);
    }
}
