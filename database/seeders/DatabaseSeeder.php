<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Role, Permission, User, TypeOfPet};

class DatabaseSeeder extends Seeder
{
    protected $roles = [
        'administrador' => 'Administrador',
        'gerente' => 'Gerente', 
        'veterinario' => 'Veterinario', 
        'peluquero' => 'Peluquero canino' , 
        'recepcion' => 'Recepción', 
        'ventas' => 'Ventas', 
        'almacen' => 'Almacén', 
        'auditor' => 'Auditor', 
        'publicista' => 'Publicista',
    ];

    protected $permissions = [
        'estadistica',
        'recursos humanos',
        'gestion de sedes',
        'recepcion',
        'turnos',
        'historias clinicas',
        'ventas',
        'almacen',
        'marketing',
    ];

    protected $type_of_pets = [
        'Perro', 'Gato', 'Conejo', 'Hamster', 'Pájaro', 'Tortuga', 'Pez', 'Serpiente', 'Lagarto', 'Rata', 'Iguana', 'Canario', 'Tarántula', 'Cotorra', 'Araña'
    ];

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if(!Role::count())
        {
            $this->createRoles();
        }

        $role = Role::where('key', 'administrador')->first();

        if(!Permission::where('role_id', $role->id)->count())
        {
            $this->createPermissions($role->id);
        }

        if(!User::count())
        {
            User::factory(1)->create();
        }

        if(!TypeOfPet::count())
        {
            $this->createTypeOfPets();
        }
    }

    /**
     *  Se le añade todos los tipos de especie para las mascotas 
     * */
    protected function createTypeOfPets()
    {
        foreach ($this->type_of_pets as $name)
        {
            TypeOfPet::updateOrCreate([
                'name' => $name
            ]);
        }
    }

    /**
     *  Se crean los roles
     * */
    protected function createRoles()
    {
        foreach ($this->roles as $key => $name)
        {
            Role::updateOrCreate([
                'key' => $key  
            ], [
                'name' => $name,
            ]);
        }
    }

    /**
     *  Se le añade todos los permisos al admin 
     * @param foreign $role_id
     * 
     * */
    protected function createPermissions($role_id)
    {
        foreach ($this->permissions as $name)
        {
            Permission::create([
                'name' => $name,
                'role_id' => $role_id,
            ]);
        }
    }
}
