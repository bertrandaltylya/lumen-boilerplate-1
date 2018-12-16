<?php

use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    use SeederHelper;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleModel = app(config('permission.models.role'));

        $viewBackend = app(config('permission.models.permission'))::create([
            'name' => 'view backend',
        ]);
        foreach (['system', 'admin',] as $roleName) {
            $roleModel::create([
                'name' => $roleName,
            ])->givePermissionTo($viewBackend);
        }

        $this->seederPermission($roleModel::PERMISSIONS);
    }
}
