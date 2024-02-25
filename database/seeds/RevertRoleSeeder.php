<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RevertRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            // Elimina roles y permisos creados por el RoleSeeder original
            Role::whereIn('name', ['Administrador', 'Docente', 'Secretario', 'Alumno'])->delete();
            Permission::whereIn('name', [
                'dashboard_admin',
                'admin.usuarios.disable',
                'admin.usuarios.enable',
                'admin.usuarios.crear',
                'admin.usuarios.editar',
                'admin.usuarios.listar',
                'dashboard_secretario',
                'secretarios.crear',
                'secretarios.editar',
                'secretarios.listar',
                'docentes.crear',
                'docentes.editar',
                'docentes.listar',
                'paralelo.crear',
                'paralelo.eliminar',
                'paralelo.editar',
                'paralelo.listar',
                'dashboard_docente',
                'dashboard_alumno'
            ])->delete();
    }
}
