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
        factory(User::class, 1)->create([
            'email' => 'admin@admin.com',
            'password' => Hash::make('secret'),
        ]);

        factory(User::class, 50)->create();

        $this->seederPermission(User::PERMISSIONS);
    }
}
