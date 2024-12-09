<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogActivity extends Model
{
    use HasFactory;

    protected static function booted(): void
    {
        static::created(function ($actionPlan) {
            $user = auth()->user();
            $description = 'Created action plan: ' . $actionPlan->id;

            $user->logActivity('create', $description);
        });

        static::updated(function ($actionPlan) {
            $user = auth()->user();
            $description = 'Updated action plan: ' . $actionPlan->id;

            $user->logActivity('update', $description);
        });

        static::deleted(function ($actionPlan) {
            $user = auth()->user();
            $description = 'Deleted action plan: ' . $actionPlan->id;

            $user->logActivity('delete', $description);
        });
    }
}
