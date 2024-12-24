<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ActivityLog;
use App\Models\User;

class ActivityLogsController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * Apply middleware to ensure only authenticated, verified admins can access these methods.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'role:admin']);
    }

    /**
     * Display a listing of activity logs.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Fetch activity logs with associated user, ordered by latest
        $activityLogs = ActivityLog::with('user')
            ->latest()
            ->paginate(20);

        return view('admin.activity_logs.index', compact('activityLogs'));
    }

    /**
     * Display the specified activity log details.
     *
     * @param  \App\Models\ActivityLog  $activityLog
     * @return \Illuminate\View\View
     */
    public function show(ActivityLog $activityLog)
    {
        // Load the associated user
        $activityLog->load('user');

        return view('admin.activity_logs.show', compact('activityLog'));
    }

    /**
     * Search activity logs based on filters like user, action, date range.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function search(Request $request)
    {
        $query = ActivityLog::with('user')->latest();

        // Filter by user ID
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by action keyword
        if ($request->filled('action')) {
            $query->where('action', 'like', '%' . $request->action . '%');
        }

        // Filter by date range
        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('created_at', [
                $request->from_date . ' 00:00:00',
                $request->to_date . ' 23:59:59'
            ]);
        }

        $activityLogs = $query->paginate(20);

        // Fetch all users for the filter dropdown
        $users = User::all();

        return view('admin.activity_logs.index', compact('activityLogs', 'users'));
    }

    /**
     * Export activity logs to a CSV file.
     *
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function exportCsv()
    {
        $filename = 'activity_logs_' . now()->format('Y_m_d_H_i_s') . '.csv';

        $activityLogs = ActivityLog::with('user')->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $columns = ['ID', 'User', 'Action', 'IP Address', 'Created At'];

        $callback = function() use ($activityLogs, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($activityLogs as $log) {
                fputcsv($file, [
                    $log->id,
                    $log->user ? $log->user->name : 'System',
                    $log->action,
                    $log->ip_address,
                    $log->created_at->toDateTimeString(),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}