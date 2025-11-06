<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Carbon\Carbon;

class FixUserTimestamps extends Command
{
    protected $signature = 'fix:user-timestamps';
    protected $description = 'Fix incorrect user timestamps';

    public function handle()
    {
        $this->info('Checking user timestamps...');
        
        $users = User::all();
        $fixedCount = 0;
        
        foreach ($users as $user) {
            $needsFix = false;
            
            // Check if last_seen is in the future
            if ($user->last_seen && $user->last_seen->gt(now())) {
                $this->warn("Fixing future timestamp for user {$user->id}: {$user->last_seen}");
                $user->last_seen = now()->subDays(7); // Set to 1 week ago
                $needsFix = true;
            }
            
            // Check if created_at is in the future
            if ($user->created_at && $user->created_at->gt(now())) {
                $this->warn("Fixing future created_at for user {$user->id}: {$user->created_at}");
                $user->created_at = now()->subDays(7);
                $needsFix = true;
            }
            
            if ($needsFix) {
                $user->save();
                $fixedCount++;
            }
        }
        
        $this->info("Fixed {$fixedCount} user records with incorrect timestamps.");
        return 0;
    }
}