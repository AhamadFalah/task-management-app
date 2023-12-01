<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Tasks;
use App\Models\User;

class TaskController extends Controller
{
    public function add()
    {
        $users = User::where('id', '!=', auth()->user()->id)->get();

        return view('task.add', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'task_name' => 'required',
            'description' => 'required',
            'deadline' => 'required|date',
            'status' => 'required|in:Pending,In Progress,Completed',
            'user_id' => 'required|exists:users,id',
            'admin_id' => 'required|exists:users,id', 
        ]);
    
        $data = $request->except(['_token']);
        Tasks::create($data);
    
        return redirect()->route('home')->with('success', 'Task added successfully!');
    }

    public function showDashboard()
{
    $tasks = Tasks::all(); 
    return view('dashboard', ['tasks' => $tasks]);
}

public function edit($id)
{
    $task = Tasks::find($id);

    if (!$task) {
        return redirect()->back()->with('error', 'Task not found.');
    }

    $users = User::where('id', '!=', auth()->user()->id)->get();

    return view('task.edit', compact('task', 'users'));
}


    public function deleteTask($id)
    {
        
        $task = Tasks::find($id);

        if (!$task) {
            return redirect()->back()->with('error', 'Task not found.');
        }

        $task->delete();
        return redirect()->route('home')->with('success', 'Task deleted successfully.');
    }

    public function update(Request $request, $id)
{

    $request->validate([
        'task_name' => 'required',
        'description' => 'required',
        'deadline' => 'required|date',
        'user_id' => 'required', 
        'status' => 'required|in:Pending,In Progress,Completed',
    ]);

    $data = $request->except(['_token', '_method']);
    $task = Tasks::findOrFail($id);
    $task->update($data);
    return redirect()->route('home')->with('success', 'Task updated successfully!');
}

public function updateTask($id)
{
    $task = Tasks::find($id);

    if (!$task) {
        return redirect()->back()->with('error', 'Task not found.');
    }

    $users = User::where('id', '!=', auth()->user()->id)->get();

    return view('task.update', compact('task', 'users'));
}

}
