<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Role, Permission, User, TypeOfPet, Report, Company, Reason};
use Illuminate\Support\Str;

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
        'Central' => 'Carlos Casares y Don Bosco', 'Capital' => 'Anchorena y Santa Fe',
    ];

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Roles para colaboradores
        if(!Role::count())
        {
            $this->createRoles();
        }

        $role = Role::where('key', 'administrador')->first();

        // Permisos para el administrador
        if(!Permission::where('role_id', $role->id)->count())
        {
            $this->createPermissions($role->id);
        }

        // Sedes
        if(!Company::count())
        {
            $this->createCompanies();
        }

        // Colaboradores
        if(!User::count())
        {
            User::factory(1)->create();

            $this->createUsersWithRoles();
        }

        // Motivos para el control
        if(!Reason::count())
        {
            $this->createReasons();
        }

        // Especies
        if(!TypeOfPet::count())
        {
            $this->createTypeOfPets();
        }

        // Clasificaciones para los clientes
        if(!Report::count())
        {
            $this->createReports();
        }
    }

    /**
     * Usuario con cada rol
     * */
    protected function createUsersWithRoles()
    {
        /* ID del ultimo digito de CEDULA */
        $i = 1;
        
        foreach ($this->roles as $key => $name)
        {
            User::create([
                'name' => $name,
                'email' => $key.'@clinicanimal.com',
                'cedula' => "4040040".$i,
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'role_id' => (Role::where('key', $key)->first())->id,
                'remember_token' => Str::random(10),
                'company_id' => (Company::first())->id,
            ]);

            $i++;
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

    protected $reasons = [
        'Ingreso a Tienda',
        'Salida de Tienda',
        'Salida a Break',
        'Retorno de Break',
        'Permiso',
    ];

    /**
     *  Se le añade todos los estados de clientes posibles 
     * */
    protected function createReasons()
    {
        foreach ($this->reasons as $reason)
        {
            Reason::create([
                'name' => $reason,
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
