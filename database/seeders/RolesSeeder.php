<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'myAccount_edit',
            'metersData_add',
            'metersData_list',
            'metersData_edit',
            'bills_add',
            'bills_list',
            'bills_edit',
            'applications_add',
            'applications_list',
            'applications_edit',
            'appeals_add',
            'appeals_list',
            'appeals_edit',
            'requests_add',
            'requests_list',
            'requests_edit',
            'users_add',
            'users_list',
            'users_edit',
            'disclosure_add',
            'disclosure_list',
            'disclosure_edit',
            'settings',
        ];

        $roles = [
            'super' => [
                'myAccount_edit',
                'applications_list',
                'applications_edit',
                'requests_list',
                'requests_edit',
                'users_add',
                'users_list',
                'users_edit',
                'disclosure_add',
                'disclosure_list',
                'disclosure_edit',
                'settings',
                'appeals_list',
                'appeals_edit',
            ],
            'admin' => [
                'myAccount_edit',
                'applications_list',
                'applications_edit',
                'requests_list',
                'requests_edit',
                'users_add',
                'users_list',
                'users_edit',
                'disclosure_add',
                'disclosure_list',
                'disclosure_edit',
                'settings',
                'appeals_list',
                'appeals_edit',
            ],
            'customer' => [
                'myAccount_edit',
                'metersData_add',
                'metersData_list',
                'bills_add',
                'bills_list',
                'applications_add',
                'applications_list',
                'requests_add',
                'requests_list',
                'appeals_add',
                'appeals_list',
                'appeals_edit',
            ],
            'vendor' => [
                'myAccount_edit',
                'applications_list',
                'applications_edit',
                'requests_list',
                'requests_edit',
                'appeals_list',
                'appeals_edit',
            ]
        ];

        foreach ($permissions as $name) {
            Permission::create(['name' => $name]);
        }

        foreach ($roles as $name => $permissions) {
            $role = Role::create(['name' => $name]);
            $role->syncPermissions($permissions);
        }
    }
}
