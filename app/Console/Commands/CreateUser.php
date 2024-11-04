<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateUser extends Command
{
     /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crea un nuevo usuario en el sistema';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Pedir los datos del usuario
        $name = $this->ask('Ingrese el nombre del usuario');
        $email = $this->ask('Ingrese el correo electrónico del usuario');
        $password = $this->secret('Ingrese la contraseña');

        // Validar los datos de entrada
        $validator = Validator::make([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ], [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            $this->error('Error en la validación de datos:');
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
            return 1;
        }

        // Crear el usuario
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $this->info("Usuario '{$user->name}' creado exitosamente con ID {$user->id}");
        return 0;
    }
}

/*forma de usa php artisan make:user*/