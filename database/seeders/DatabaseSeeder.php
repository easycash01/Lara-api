<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Customer;

class DatabaseSeeder extends Seeder
{
    private $defaultFileName = 'default.jpg';
    private $defaultPath = 'images/avatars/default.jpg';

    public function run(): void
    {
        // Pulisci il database prima di inserire nuovi dati
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Customer::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Calcola la dimensione del file una sola volta
        $fileSize = file_exists(public_path($this->defaultPath)) 
            ? filesize(public_path($this->defaultPath)) 
            : null;

        // Crea il customer principale con il suo avatar
        $customer = \App\Models\Customer::factory()->create([
            'nome' => 'Cliente',
            'cognome' => 'Test',
            'username' => 'cliente.test',
            'email' => 'cliente@test.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'stato' => 'normale',
            'avatar' => false
        ]);

        // Crea il record dell'avatar
        $customer->avatar()->create([
            'path' => $this->defaultPath,
            'file_name' => $this->defaultFileName,
            'nome_originale' => $this->defaultFileName,
            'mime_type' => 'image/jpeg',
            'dimensione' => $fileSize
        ]);

        // Crea 5 customers con i loro avatar (alcuni con avatar true, altri false)
        \App\Models\Customer::factory(5)
            ->has(\App\Models\Avatar::factory())
            ->create(); // Rimuoviamo l'override e lasciamo il valore del factory

        // Crea gli utenti di test
        \App\Models\User::factory()->create([
            'name' => 'test2',
            'email' => 'test2@test.com',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'test',
            'email' => 'test@test.com',
        ]);
    }
}
