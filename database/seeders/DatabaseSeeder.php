<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Role, Permission, User, TypeOfPet, Report, Company, Reason, Service, Client, ProductPresentation, ProductCategory, ProductBrand, Supplier, Casher, Manpower, PaymentMethod, MarketingTemplate, MarketingCampaign, MarketingTracking};
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /* Roles para los trabajadores */
    protected $roles = [
        'administrador' => 'Administrador',
        'gerente' => 'Gerente', 
        'gerente_general' => 'Gerente General', 
        'veterinario' => 'Veterinario', 
        'peluquero' => 'Peluquero canino' , 
        'recepcion' => 'Recepción', 
        'ventas' => 'Ventas', 
        'almacen' => 'Almacén', 
        'auditor' => 'Auditor', 
        'publicista' => 'Publicista',
        'default' => 'Default',
    ];

    /* Tipo de calificacion para los clientes */
    protected $type_of_reports = [
        'default',
        'ocasional',
        'VIP',
        'regular',
    ];

    /* Permisos para cada rol */
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

    /* Tipos de mascotas */
    protected $type_of_pets = [
        'Perro', 'Gato', 'Conejo', 'Hamster', 'Pájaro', 'Tortuga', 'Pez', 'Serpiente', 'Lagarto', 'Rata', 'Iguana', 'Canario', 'Tarántula', 'Cotorra', 'Araña'
    ];

    /* Sedes (Locales) */
    protected $sedes = [
        'Central' => 'Carlos Casares y Don Bosco', 'Capital' => 'Anchorena y Santa Fe',
    ];

    /* Razones para el control de colaboradores */
    protected $reasons = [
        'Ingreso a Tienda',
        'Salida de Tienda',
        'Salida a Break',
        'Retorno de Break',
        'Permiso',
    ];

    protected $services = [
        'Atención Veterinaria' => '',
        'Peluquería Canina' => '',
    ];

    public $product_categories = [
        'Categoría 1',
        'Categoría 2',
        'Categoría 3',
    ];

    public $product_brands = [
        'DogChow',
        'Sabrositos',
        'Marca 3',
    ];

    public $product_presentations = [
        'Saco',
        'Kilo',
        'Blíster',
        'Paquete',
        'Sin especificar',
    ];

    public $suppliers = [
        'Prueba',
        'Test Inc',
        'Lorem Ipsum',
        'Sit Amet',
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
        if(!Permission::count())
        {
            $this->createPermissions();
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

        if(!Service::count())
        {
            $this->createServices();
        }

        if(!Client::count())
        {
            $this->createClients();
        }

        if(!ProductBrand::count())
        {
            $this->createBrands();
        }

        if(!ProductCategory::count())
        {
            $this->createCategories();
        }

        if(!ProductPresentation::count())
        {
            $this->createPresentations();
        }

        if(!Supplier::count())
        {
            $this->createSuppliers();
        }

        if(!Casher::count())
        {
            $this->assignCashers();
        }

        if(!PaymentMethod::count())
        {
            $this->createPaymentMethod();
        }

        if(!Manpower::count())
        {
            $this->createManpower();
        }

        if(!MarketingTemplate::count())
        {
            $this->createTemplate();
        }
    }

    protected function createTemplate()
    {
        for ($i=0; $i < 3; $i++)
        { 
            MarketingTemplate::create([
                'name' => 'Plantilla de Prueba n°'.$i,
                'content' => 'lorem ipsum sit amet lorem ipsum sit amet lorem ipsum sit amet',
                'button_url' => url('/'),
                'button_text' => 'Visitar',
            ]);
        }
    }

    protected function createPaymentMethod()
    {
        foreach (['Banco Santander', 'Banco de Crédito del Perú'] as $name)
        {
            PaymentMethod::create([
                'name' => $name
            ]);
        }
    }

    protected function createManpower()
    {
        $users = User::get();

        foreach($users as $user)
        { 
            Manpower::create([
                'user_id' => $user->id,
                'contact_name_emergency' => 'Pariente de '.$user->name,
                'contact_phone_emergency' => random_int(10000000, 99999999),
                'contact_type_emergency' => 'Hermano',
                'cuenta_bancaria' => random_int(10000000000, 99999999999),
                'payment_method_id' => (PaymentMethod::first())->id,
                'fecha_de_contratacion' => now()->subYear(1),
            ]);
        }
    }

    protected function assignCashers()
    {
        foreach (User::get() as $user)
        {
            Casher::create([
                'name' => random_int(1, 99),
                'user_id' => $user->id,
                'company_id' => (Company::first())->id,
            ]);
        }
    }

    protected function createSuppliers()
    {
        foreach ($this->suppliers as $supplier)
        {
            Supplier::create([
                'name' => $supplier,
                'ruc' => random_int(10000000000, 99999999999),
                'phone' => '11'.random_int(10000000, 99999999),
                'cuenta_bancaria' => random_int(10000000000, 99999999999),
                'banco' => 'Banco de Crédito del Perú',
                'beneficiario' => $supplier,
            ]);
        }
    }

    protected function createPresentations()
    {
        foreach ($this->product_presentations as $key)
        {
            ProductPresentation::create([
                'name' => $key,
                'description' => $key,
            ]);
        }
    }

    /* Categorías para producto */
    protected function createCategories()
    {
        foreach ($this->product_categories as $key)
        {
            ProductCategory::create([
                'name' => $key,
                'description' => $key,
            ]);
        }
    }

    /**
     * Marcas
     * */
    protected function createBrands()
    {
        foreach ($this->product_brands as $key)
        {
            ProductBrand::create([
                'name' => $key,
                'description' => $key,
            ]);
        }
    }


    protected function createClients()
    {
        for ($i=0; $i < 3; $i++)
        {
            Client::create([
                'name' => 'Cliente Apellido '.Str::random(),
                'email' => "cliente{$i}@gmail.com",
                'phone' => "112233445{$i}",
                'address' => "Av. Siempre Viva 123{$i}",
                'dni' => "5050050{$i}",
                'report_id' => (Report::first())->id,
                'user_id' => (User::first())->id,
            ]);
        }
    }

    protected function createServices()
    {
        foreach ($this->services as $key => $description)
        {
            Service::create([
                'name' => $key,
                'description' => $description
            ]);
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
                'sueldo' => random_int(1000, 9999),
            ]);
        }
    }

    /**
     *  Se le añade todos los permisos al admin 
     * @param foreign $role_id
     * 
     * */
    protected function createPermissions()
    {
        foreach ($this->permissions as $name)
        {
            Permission::create([
                'name' => $name,
            ]);
        }
    }
}
