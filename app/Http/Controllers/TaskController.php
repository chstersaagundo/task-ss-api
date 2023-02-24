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
    public function index($id)
    {
        $category = Category::find($id);
        if ($category) {
            $task = Task::where('category_id', $category->id)->get();
            return response()->json([
                'success' => true,
                'message' => 'Fetch successfully',
                'data' => [
                    "data" => $task
                ]
            ], 200);
        }

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
    public function store(TaskRequest $request, $id)
    {
        //
        $category = Category::find($id);
        if ($category) {
            if($request->validated()) {
                $task = new Task;
                $task->category_id = $id;
                $task->task_type_id = $request->task_type_id;
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
                    "data" => [
                        "data" => $task
                    ]
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
    public function show($cat_id, $t_id)
    {
        
        $category = Category::find($cat_id);
        if ($category) {
            $task = Task::find($t_id);
            return response()->json([
                'success' => true,
                'message' => 'Fetch successfully',
                'data' => [
                    "data" => $task
                ]
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
    public function update(TaskRequest $request, $c_id, $t_id)
    {
        //
        $category = Category::find($c_id);
        if($category){
            $task = Task::find($t_id);
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

        return response()->json([
            'success' => false,
            'message' => 'Category not found'
        ], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($c_id, $t_id)
    {
        $category = Category::find($c_id);
        if($category){
            Task::where('id', $t_id)->delete();
            return response()->json([
                'success' => true,
                'message' => 'Removed Successfully',
                'data' => $t_id
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => 'Category not found'
        ], 404);

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
