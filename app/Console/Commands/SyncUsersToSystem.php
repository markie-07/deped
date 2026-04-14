<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\SyncService;
use Illuminate\Console\Command;

class SyncUsersToSystem extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:users-to-system';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync all existing users from DepEd Manager to DepEd System';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::all();
        $this->info("Found " . $users->count() . " users to sync.");

        foreach ($users as $user) {
            $this->info("Syncing user: {$user->email}...");
            SyncService::syncUser($user, 'updated');
        }

        $this->info("Synchronization complete!");
    }
}
