<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:user {--admin}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create user
                                    {--admin : Whether the user should be admin}';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->ask('What is your name?');
        $email = $this->ask('What is your email?');
        $password = $this->secret('What is your password?');
        $is_admin = $this->option('admin');

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $this->info('User created successfully!');

        if ($is_admin) {
            Admin::create([
                'user_id' => $user->id,
            ]);

            $this->info('Admin created successfully!');
        }

        return 0;
    }
}
