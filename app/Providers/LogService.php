<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class LogService extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }

    public function log($action, $description)
    {
        $user = auth()->user();
        $ipAddress = request()->ip();

        ActivityLog::create([
            'user_id' => $user->id,
            'action' => $action,
            'description' => $description,
            'ip_address' => $ipAddress,
        ]);
    }
    
}
