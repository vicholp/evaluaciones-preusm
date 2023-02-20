<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class CreateBackupDb extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $host = config('database.connections.mysql.host');
        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');
        $database = config('database.connections.mysql.database');

        $env = config('app.actual_env');
        $file = config('filesystems.backup_database_path').'/'.config('app.name').'_'.$env.'_'.date('Y-m-d-H:m:s').'.sql';

        $process = Process::fromShellCommandline(
            "mysqldump --quick --single-transaction --add-drop-database --add-drop-table --lock-tables --extended-insert --host={$host} --user={$username} --password={$password} {$database} > $file"
        );

        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $process = Process::fromShellCommandline(
            "cp {$file} 'last_{$env}.sql'"
        );

        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $this->info('Backup created successfully!');

        return 0;
    }
}
