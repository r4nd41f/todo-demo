<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Task;

class TaskController extends Controller
{
    /**
     * Display a list of Tasks
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Task::byUser(Auth::id())->get();
    }

    /**
     * Display a list of incomplete Tasks
     *
     * @return \Illuminate\Http\Response
     */
    public function todo()
    {
        return Task::incomplete()->byUser(Auth::id())->get();
    }

    /**
     * Display a list of incomplete Tasks formatted as a calendar
     *
     * @return \Illuminate\Http\Response
     */
    public function calendar($year, $month)
    {
        $weeks = [];
        $weekNum = 0;

        $currentDay = Carbon::createFromDate($year, $month, 01)->startOfWeek();
        $lastDay = Carbon::createFromDate($year, $month, 01)->endOfMonth()->endOfWeek()->addDay();

        while ($currentDay->format('Y-m-d') !== $lastDay->format('Y-m-d')) {
            $weeks[$weekNum][] = [
                'date' => $currentDay->format('Y-m-d'),
                'tasks' => Task::dueDateOn($currentDay)->get(),
            ];
            $currentDay->addDay();
            if ($currentDay->isDayOfWeek(Carbon::MONDAY)) {
                $weekNum++;
            }
        }

        return json_encode($weeks);
    }

    /**
     * Store a newly created Task in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'description' => 'required|max:255',
            'due_date' => 'required',
        ]);

        $task = new Task();
        $task->description = $request->description;
        $task->due_date = Carbon::parse($request->due_date)->format('Y-m-d');
        $task->user_id = Auth::id();
        $task->save();

        return response()->json($task, 201);
    }

    /**
     * Display the specified Task.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $task = Task::find($id);
        $this->authorize('update', $task);
        return $task;
    }

    /**
     * Update the specified Task in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'description' => 'sometimes|required|max:255',
            'due_date' => 'sometimes|required',
            'completed' => 'sometimes|boolean'
        ]);
        
        $task = Task::find($id);
        $this->authorize('update', $task);

        $task->completed_date = $request->completed_date;
        if (isset($request->description)) {
            $task->description = $request->description;
        }
        $task->save();

        return response()->json($task, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::find($id);

        $this->authorize('update', $task);
        if ($task->delete()) {
            return response()->json(null, 204);
        }
    }
}
