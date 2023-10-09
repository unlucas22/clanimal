## Por hacer

- formulario para registrar cliente (añadir status solo para el administrador) con validations
- editar clientes

- modulo mascotas de cliente
- model Caja

- seguimiento de usuarios

## Create ClinicAnimal

- composer create-project laravel/laravel clinicanimal
- cd clinicanimal
- composer require laravel/jetstream
- php artisan jetstream:install livewire
- npm install && npm run dev
- npm install flowbite
- npm install sweetalert2
- composer require jenssegers/agent
- composer require vinkla/hashids
- composer require wire-elements/modal
- composer require barryvdh/laravel-debugbar
- composer require doctrine/dbal
- npm install @alpinejs/focus
- npm install @alpinejs/collapse

## Roles

Módulos (M)

- Administrador: *

- Gerente: 
	M: Estadistica, Recursos humanos, Gestion de sedes.

- Veterinario: 
	M: Recepción, Historias clinicas.

- Peluquero:
	M: Recepción y turnos, Historias Clinicas.

- Recepcionista:
	M: Recepción y turnos, Historias clinicas, Clientes.

- Cajera:
	M: Ventas

- Almacenero:
	M: Almacen.

- Auditor:
	M: Ventas, Estadistica, Almacen.

- Publicista
	M: Marketing.