<?php

namespace App\Http\Controllers;

use App\Task;
use App\Ticket;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $task = Task::create($request->all());

        return \Redirect::back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Task $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        return view('ticket.tasks.show')->with('task',$task);
    }

    /**
     * Show the form for editing the specified resource
     *
     * @param  \App\Task $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Task $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        Task::where('id',$task->id)->update(['title'=>$request->title,
            'description'=>$request->description,
            'priority_id'=>$request->priority_id,
            'technician_id'=>$request->technician_id,
            'group_id'=>$request->group_id]);
        $ticket = Ticket::find($task->ticket_id);
        return view('ticket.show')->with('ticket',$ticket);
    }

    public function getTasksOfTicket(Ticket $ticket)
    {
        $tasks = Task::where('ticket_id', $ticket->id)->get()->map(function ($task) {
            return ['task_id' => $task->id,
                'title' => $task->title,
                'description' => $task->description,
                'status' => $task->status->name ?? '',
                'group' => $task->group->name ?? '',
                'technician' => $task->technician->name ?? '',
                'priority' => $task->priority->name ?? '',
                'comments' => $task->comments ?? ''
            ];
        });

        return $tasks;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task = Task::find($task->id);
        $oldTask = $task;
        $task->delete();
        return $oldTask;
    }
}
