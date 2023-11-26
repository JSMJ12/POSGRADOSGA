<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'admin',
            'password' => '$2y$10$pEEmboyCEH51h7w79RbH1eG5NhPF4fwPyTjExJ3wEkgosr0o6NIgC',
            'sexo' => 'M',
            'email' => 'podonga69@gmail.com',
            'apellido' => 'Apellido',
            'status' => 'ACTIVO',
            'image' => 'ruta/foto.jpg'
        ]);
        $user->assignRole('Administrador');
    }
}
