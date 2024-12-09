<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserActivity;
use Illuminate\Support\Facades\DB;

class LogUserActivity
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if ($request->isMethod('post') || $request->isMethod('put') || $request->isMethod('patch')) {
            $action = $request->isMethod('post') ? 'created' : 'updated';
            $controller = $request->route()->getController();

            // Check if the controller has the getAttributes method
            if (method_exists($controller, 'getAttributes')) {
                $attributes = $controller->getAttributes($request);
                $attributesDescription = '';
                foreach ($attributes as $key => $value) {
                    $attributesDescription .= "$key: '$value'; ";
                }

                // Improved logging description
                $this->logActivity($action, $controller, $attributesDescription);
            }
        }

        return $response;
    }

    protected function logActivity($action, $model, $description)
    {
        // Check if there are any users in the users table
        if (DB::table('users')->count() === 0) {
            return; // Skip logging if no users exist
        }

        $user = Auth::user();
        $userId = Auth::id(); // Get the user ID
        $userName = $user ? $user->name : 'Guest'; // Use 'Guest' or another placeholder if no user is logged in

        // Skip logging if there's no authenticated user (during logout or similar cases)
        if (!$userId && $action !== 'logged in') {
            return; // Skip logging
        }

        $modelClass = get_class($model);
        $modelId = method_exists($model, 'getKey') ? $model->getKey() : (property_exists($model, 'id') ? $model->id : null);

        // Enhanced description
        $logDescription = "User $userName $action a $modelClass" .
                          ($modelId ? " with ID $modelId." : '') . 
                          " Changes made: " . $description;

        UserActivity::create([
            'user_id' => $userId,
            'action' => $action,
            'description' => $logDescription,
        ]);
    }
}
