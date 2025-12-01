<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AssignRolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $roles = Role::all();

        foreach ($roles as $role) {
            $allPermissions = Permission::where('ability', 'Read')->get()->pluck('id')->toArray();
            $role->permissions()->sync($allPermissions);

            if (in_array($role->name, ['Sekretaris', 'Bendahara'])) {
                $permissions = Permission::whereIn('ability', ['Create', 'Update'])->get();
                foreach($permissions as $p) {
                    $role->permissions()->attach($p);
                }
            }

            if (in_array($role->name, ['Super Admin'])) {
                $permissions = Permission::whereIn('ability', ['Create', 'Update'])->get();
                $role->permissions()->sync($permissions);
            }
        }
    }
}
