<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tasks;

class HomeController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->back();
        }

        $user = Auth::user();

        if ($user->usertype === 'admin') {
            // Fetch all tasks for admin
            $tasks = Tasks::all();
        } else {
            // Fetch tasks for regular user
            $tasks = $user->tasks ?? collect(); // Use an empty collection if $user->tasks is null
        }

        // Statistics for admin
        $totalTasksAdmin = Tasks::count();
        $completedTasksAdmin = Tasks::where('status', 'Completed')->count();
        $pendingTasksAdmin = Tasks::where('status', 'Pending')->count();
        $completionPercentageAdmin = $totalTasksAdmin > 0 ? ($completedTasksAdmin / $totalTasksAdmin) * 100 : 0;

        // Statistics for user
        $totalTasksUser = $tasks->count();
        $completedTasksUser = $tasks->where('status', 'Completed')->count();
        $pendingTasksUser = $tasks->where('status', 'Pending')->count();
        $completionPercentageUser = $totalTasksUser > 0 ? ($completedTasksUser / $totalTasksUser) * 100 : 0;

        if ($user->usertype === 'admin') {
            return view('admin.adminhome', [
                'tasks' => $tasks,
                'totalTasks' => $totalTasksAdmin,
                'completionPercentage' => $completionPercentageAdmin,
                'pendingTasks' => $pendingTasksAdmin,
            ]);
        } elseif ($user->usertype === 'user') {
            return view('user.dashboard', [
                'tasks' => $tasks,
                'totalTasks' => $totalTasksUser,
                'completionPercentage' => $completionPercentageUser,
                'pendingTasks' => $pendingTasksUser,
                'user' => $user,
            ]);
        } else {
            // Handle other user types or redirect as needed
            return redirect()->back();
        }
    }
}
