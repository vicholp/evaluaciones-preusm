<?php

namespace App\Console\Commands;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'make:user {--admin}
                            {--admin : Whether the user should be admin}
                            {--default : Whether the user should use the default values}';

    /**
     * The console command description.
     */
    protected $description = 'Create a new user';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $isAdmin = $this->option('admin');

        $name = 'Admin';
        $email = 'admin@example.com';
        $password = 'password';

        if (!$this->option('default')) {
            $name = $this->ask('What is your name?');
            $email = $this->ask('What is your email?');
            $password = $this->secret('What is your password?');
        }

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $this->info('User created successfully!');

        if ($isAdmin) {
            Admin::create([
                'user_id' => $user->id,
            ]);

            $this->info('Admin created successfully!');
        }

        return 0;
    }
}
