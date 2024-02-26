<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class PostLanterolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role5 = Role::create(['name' => 'Postulante']);
        //Postulante
        $permission1 = Permission::create(['name' => 'dashboard_postulante'])->syncRoles([$role5 ]);
    }
}
