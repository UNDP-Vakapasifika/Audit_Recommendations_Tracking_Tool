<?php

namespace App\Http\Middleware;

use App\Models\ActivityLog;
use Closure;
use Illuminate\Support\Facades\Auth;


class LogActivity
{

    public function handle($request, Closure $next)
    {

        if (Auth::check()) {
            $user = Auth::user();
            $response = $next($request);

            $action = $request->method() . ' ' . $request->path();
            $description = $request->isMethod('get') ? null : json_encode($request->all());
            $statusCode = optional($response)->status();

            ActivityLog::create([
                'user_id' => $user?->{'id'},
                'name' => $user?->{'name'},
                'action' => $action,
                'activity' => json_encode([
                    'type' => 'request',
                    'action' => $action,
                    'description' => $description,
                    'status_code' => $statusCode,
                ]),
                'ip_address' => $request->ip(),
            ]);
        }

        return $next($request);

    }
}
