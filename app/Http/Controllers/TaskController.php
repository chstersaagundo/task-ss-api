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
        $user = Auth::user();
        $task = Task::where('user_id', $user->id)->get();

        return response()->json([
            'success' => true,
            'message' => 'Fetch successfully',
            'data' => $task
        ], 200);
        // if ($category) {
        //     $task = Task::where('category_id', $category->id)->get();
        //     return response()->json([
        //         'success' => true,
        //         'message' => 'Fetch successfully',
        //         'data' => [
        //             "data" => $task
        //         ]
        //     ], 200);
        // }

        return response()->json([
            'success' => false,
            'message' => 'Fetch Failed'
        ], 422);


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
        $user = Auth::user();
        $category = Category::where('user_id', $user->id)->exists();
        if ($category) {
            if($request->validated()) {
                $task = new Task;
                $task->category_id = $request->category_id;
                $task->task_type_id = $request->task_type_id;
                $task->user_id = $user->id;
                $task->task_name = $request->task_name;
                $task->task_desc = $request->task_desc;
                $task->is_starred = $request->is_starred;
                $task->priority = $request->priority;
                $task->status = $request->status;
                $task->start_date = $request->start_date;
                $task->end_date = $request->end_date;
                $task->start_time = $request->start_time;
                $task->end_time = $request->end_time;
    
                $task->save();
                return response()->json([
                    'success' => true,
                    'message' => 'Adding Task Succesful!',
                    "data" => $task
                ], 200);
            }

            return response()->json([
                'success' => false,
                'message' => 'Request not valid'
            ], 422);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Category not exist'
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
        $user = Auth::user();
        $category = Category::where('user_id', $user->id)->exists();
        if ($category) {
            $task = Task::find($id);
            return response()->json([
                'success' => true,
                'message' => 'Fetch successfully',
                'data' => $task
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Fetch Failed'
        ], 422);
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
        if($task){
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

    public function allTasksByCategory($id)
    {
        $user = Auth::user();
        
        return response()->json([
            'success' => true,
            'message' => 'Fetch successfully',
            'data' => Task::where('category_id', $id)
                          ->where('user_id', $user->id)->get()
        ], 200);
    }

    public function allStarredTasks()
    {
        $user = Auth::user();

        return response()->json([
            'success' => true,
            'message' => 'Fetch successfully',
            'data' => Task::where('is_starred', 1)
                          ->where('user_id', $user->id)->get()
        ], 200);
    }

    public function getTaskType($id)
    {
        $user = Auth::user();

        return response()->json([
            'success' => true,
            'message' => 'Fetch successfully',
            'data' => Task::where('task_type_id', $id)
                          ->where('user_id', $user->id)->get()
        ], 200);
    }



}
