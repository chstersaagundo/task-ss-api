<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\Task;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Services\TaskService;
use App\Http\Requests\TaskRequest;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    private TaskService $taskService;

    public function __construct(TaskService $taskService){
        $this->taskService = $taskService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'success' => true,
            'message' => 'Fetch successfully',
            'data' => [
                "data" => Task::all()
            ]
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskRequest $request)
    {
        //
        if($request->validated()) {

            $data = $this->taskService->createTask($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Adding Task Succesful!',
                "data" => [
                    "data" => $data
                ]
            ], 200);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Request not valid'
        ], 422);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Task::find($id);

        if ($task) {
            return response()->json([
                'success' => true,
                'message' => 'Fetch Successfully',
                'data' => $task
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Fetch Failed'
        ], 404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TaskRequest $request, $id)
    {
        //
        $task = Task::find($id);
        if ($task){
            $task->update($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Task Successfully Updated',
                'data' => $task
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Task not found'
        ], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Task::where('id', $id)->delete();
        return response()->json([
            'success' => true,
            'message' => 'Removed Successfully',
            'data' => $id
        ], 200);
    }

    public function allTasksById($id)
    {
        return response()->json([
            'success' => true,
            'message' => 'Fetch successfully',
            'data' => Task::where('category_id', $id)->get()
        ], 200);
    }

    public function allStarredTasks()
    {
        return response()->json([
            'success' => true,
            'message' => 'Fetch successfully',
            'data' => Task::where('is_starred', 1)->get()
        ], 200);
    }
}
