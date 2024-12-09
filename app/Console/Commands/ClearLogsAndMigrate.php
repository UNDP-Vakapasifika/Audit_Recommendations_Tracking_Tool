<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use PDOException;
use PDO;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessTimedOutException;

class ClearLogsAndMigrate extends Command
{
    protected $signature = 'start_tool';
    protected $description = 'Clear logs, check GD extension, and run migrations with seeding';

    public function handle()
    {
        // Clear the laravel.log file
        $logPath = storage_path('logs/laravel.log');
        if (File::exists($logPath)) {
            File::put($logPath, '');
            $this->info('Logs cleared successfully.');
        } else {
            $this->warn('Log file does not exist.');
        }

        // Check if GD extension is enabled
        if (!extension_loaded('gd')) {
            $phpIniPath = php_ini_loaded_file();
            if ($phpIniPath && File::exists($phpIniPath)) {
                $content = File::get($phpIniPath);
                if (strpos($content, ';extension=gd') !== false) {
                    $content = str_replace(';extension=gd', 'extension=gd', $content);
                    File::put($phpIniPath, $content);
                    $this->info('GD extension enabled in php.ini.');
                } else {
                    $this->warn('GD extension is not found in php.ini. Please enable it manually.');
                }
            } else {
                $this->error('php.ini file not found. Please ensure the GD extension is enabled.');
            }
        } else {
            $this->info('GD extension is already enabled.');
        }

        // Clear contents of specified folders
        $folders = [
            public_path('impact'),
            public_path('evidence'),
            public_path('img/logo')
        ];

        foreach ($folders as $folder) {
            if (File::exists($folder)) {
                File::cleanDirectory($folder);
                $this->info("Contents of '{$folder}' cleared successfully.");
            } else {
                $this->warn("Folder '{$folder}' does not exist.");
            }
        }

        // Database credentials
        $databaseName = Config::get('database.connections.mysql.database');
        $host = Config::get('database.connections.mysql.host');
        $username = Config::get('database.connections.mysql.username');
        $password = Config::get('database.connections.mysql.password');

        try {
            // Connect to MySQL without a database
            $pdo = new PDO("mysql:host={$host}", $username, $password);

            // Create the database if it does not exist
            $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$databaseName}`");
            $this->info('Database created or already exists.');

            // Test connection to the newly created database
            DB::connection()->getPdo();
            $this->info('Database connection successful.');

        } catch (PDOException $e) {
            $this->error('Database connection failed. Please check your database configuration.');
            $this->error('Error details: ' . $e->getMessage());
            return 1; // Exit with an error status
        }

        // Run migrate:fresh --seed
        Artisan::call('migrate:fresh --seed');
        $this->info('Migrations and seeding completed successfully.');

        // Start the Laravel development server
        $this->info('Starting Laravel development server...');

        // Configure the process to run indefinitely
        $process = new Process(['php', 'artisan', 'serve'], null, null, null, null); // No timeout

        try {
            $process->start();

            // Output the process messages to the console
            $this->info('Laravel development server has started. Here are the logs:');

            // Read process output and error streams asynchronously
            foreach ($process as $type => $data) {
                if ($type === Process::OUT) {
                    $this->line($data);
                } elseif ($type === Process::ERR) {
                    $this->error($data);
                }
            }

        } catch (ProcessTimedOutException $e) {
            $this->error('The Laravel development server process timed out.');
            $this->error('Error details: ' . $e->getMessage());
            return 1; // Exit with an error status
        }
    }
}
