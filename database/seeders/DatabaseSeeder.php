<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Role, Permission, User, TypeOfPet, Report, Company};

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

    protected $type_of_reports = [
        'default',
        'ocasional',
        'VIP',
        'regular',
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

    protected $sedes = [
        'Central' => 'Av. Siempre Viva 1234', 'Formosa' => 'Anchorena y Carlos Casares',
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

        if(!Company::count())
        {
            $this->createCompanies();
        }

        if(!User::count())
        {
            User::factory(1)->create();
        }

        if(!TypeOfPet::count())
        {
            $this->createTypeOfPets();
        }

        if(!Report::count())
        {
            $this->createReports();
        }
    }

    /**
     *  Se agregan sedes
     * */
    protected function createCompanies()
    {
        foreach ($this->sedes as $name => $email)
        {
            Company::create([
                'name' => $name,
                'address' => $email,
            ]);
        }
    }

    /**
     *  Se le añade todos los estados de clientes posibles 
     * */
    protected function createReports()
    {
        foreach ($this->type_of_reports as $report)
        {
            Report::create([
                'key' => $report,
            ]);
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
