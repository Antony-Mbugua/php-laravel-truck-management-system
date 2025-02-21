<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class MakeFilamentUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:filament-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Filament user';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $firstName = $this->ask('First name');
        $lastName = $this->ask('Last name');
        $email = $this->ask('Email address');
        $phone = $this->ask('Phone Number');
        $password = $this->secret('Password');

        // Validate input
        if (User::where('email', $email)->exists()) {
            $this->error("A user with the email $email already exists.");
            return Command::FAILURE;
        }

        // Create the user
        $user = User::create([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'phone' => $phone,
            'password' => Hash::make($password),
        ]);

        $this->info("User {$user->first_name} {$user->last_name} has been created successfully!");

        return Command::SUCCESS;
    }
}
