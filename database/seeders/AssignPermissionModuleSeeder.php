<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AssignPermissionModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $module = 'Permission';
        $cruds = ['Create', 'Read', 'Update', 'Delete'];
        foreach ($cruds as $crud) {
            Permission::create([
                'ability' => $crud,
                'module' => $module
            ]);
        }

        $role = Role::where('name', 'Super Admin')->first();

        $allPermissions = Permission::all()->pluck('id')->toArray();
        $role->permissions()->sync($allPermissions);
    }
}
