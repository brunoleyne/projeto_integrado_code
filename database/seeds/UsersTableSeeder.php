<?php

use Illuminate\Database\Seeder;
use App\User;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create(
            [
                'name' => 'PUC Minas',
                'email' => 'puc@projetointegrado.com',
                'password' => bcrypt('12345678'),
            ]
        );
        $user->assignRole('admin');
    }
}
