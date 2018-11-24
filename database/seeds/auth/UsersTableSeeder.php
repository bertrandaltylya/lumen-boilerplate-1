<?php

use App\Models\Auth\User\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    use SeederHelper;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $system = factory(User::class)->create([
            'email' => 'system@system.com',
            'password' => Hash::make('secret'),
        ]);

        $admin = factory(User::class)->create([
            'email' => 'admin@admin.com',
            'password' => Hash::make('secret'),
        ]);

        $system->assignRole('system');
        $admin->assignRole('admin');

        factory(User::class, 50)->create();

        $this->seederPermission(User::PERMISSIONS);
    }
}
