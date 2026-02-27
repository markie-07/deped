<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class WipeData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:wipe-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Wipe all operational data (leave records, schools, positions, etc.) while preserving user accounts.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (!$this->confirm('This will delete all leave records and directory data. User accounts will be preserved. Do you want to continue?')) {
            return;
        }

        $this->info('Wiping data...');

        // Disable foreign key checks for truncation
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $tables = [
            'leave_records',
            'employees',
            'schools',
            'positions',
            'leave_types',
            'remarks',
            'forwardeds'
        ];

        foreach ($tables as $table) {
            if (\Schema::hasTable($table)) {
                \DB::table($table)->truncate();
                $this->line("Truncated: {$table}");
            }
        }

        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->info('Operational data wiped successfully! User accounts were not affected.');
    }
}
