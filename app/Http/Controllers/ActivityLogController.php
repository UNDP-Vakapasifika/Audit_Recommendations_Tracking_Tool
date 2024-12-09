<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ActivityLog;
use App\Models\User;
use Carbon\Carbon;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        // Validate the request data
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Get a list of all users with logs
        $usersWithLogs = User::has('activityLogs')
            ->with(['activityLogs' => function ($query) use ($startDate, $endDate) {
                if ($startDate && $endDate) {
                    $query->whereBetween('created_at', [$startDate, $endDate]);
                }
            }])
            ->get();

        return view('activity-logs.index', compact('usersWithLogs', 'startDate', 'endDate'));
    }

    // public function showLogs($userId)
    // {
    //     // Get the user and their activity logs
    //     $user = User::findOrFail($userId);
    //     $logs = ActivityLog::where('user_id', $userId)->get();
        

    //     return view('activity-logs.show', compact('user', 'logs'));
    // }

    public function showLogs($userId )
    {
        $perPage = request('perPage', 10); // Number of logs per page

        $user = User::findOrFail($userId);

        // Get the user's name from the activity logs
        $userName = DB::table('activity_logs')->where('user_id', $userId)->value('name');

        // Get the user's activity logs with pagination
        $logs = ActivityLog::where('user_id', $userId)->paginate($perPage);

        return view('activity-logs.show', compact('userName', 'logs', 'user'));
    }
}