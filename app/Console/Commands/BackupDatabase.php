<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class BackupDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup the database and store it locally.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $dbName = 'kohisar';
        $dbUser = 'root';
        $dbPass = '';
        $dbHost = '127.0.0.1';
        $backupPath = storage_path('backups');
        $fileName = $backupPath . '/backup_' . date('Y_m_d_His') . '.sql';

        if (!is_dir($backupPath)) {
            mkdir($backupPath, 0755, true);
        }

        $command = "mysqldump -h {$dbHost} -u {$dbUser} -p{$dbPass} {$dbName} > {$fileName}";
        exec($command);

        if (file_exists($fileName)) {
            $this->info("Backup created: {$fileName}");
        } else {
            $this->error("Backup failed.");
        }
    }
}
