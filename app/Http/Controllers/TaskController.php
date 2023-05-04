<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\Task;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Services\TaskService;
use Illuminate\Support\Carbon;
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
        $task = Task::where('user_id', $user->id)->with('category:id,category_name,color')->get();

        return response()->json([
            'success' => true,
            'message' => 'Fetch Successfully',
            'data' => $task
        ], 200);
        // if ($category) {
        //     $task = Task::where('category_id', $category->id)->get();
        //     return response()->json([
        //         'success' => true,
        //         'message' => 'Fetch Successfully',
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

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Category does not exist'
            ], 422);
        }

        if (!$request->validated()) {
            return response()->json([
                'success' => false,
                'message' => 'Request not valid'
            ], 422);
        }

        //parsinggg stard_date, start_time, end_date, end_time //// format: 2023-05-05 23:00:00 
        $start = Carbon::parse($request->start_date . ' ' . $request->start_time);
        $end = Carbon::parse($request->end_date . ' ' . $request->end_time);

        //check if tehre are any conflicting tasks
        $conflicting_tasks = Task::where('user_id', $user->id)
            ->where('status', '<>', 'completed')
            ->where(function($query) use ($start, $end) {
                $query->where(function($q) use ($start, $end) {
                    $q->whereBetween('start_date', [$start, $end])
                        ->orWhereBetween('end_date', [$start, $end]);
                })
                ->orWhere(function($q) use ($start, $end) {
                    $q->where('start_date', '<=', $start)
                        ->where('end_date', '>=', $end);
                });
            })
            ->get();

        //if naay ni exists
        if ($conflicting_tasks->count() > 0) {
            if (!$request->has('confirmation') || !$request->confirmation) {
                return response()->json([
                    'success' => false,
                    'message' => 'Hoy! There are already scheduled tasks for this time period. Do you still want to proceed?',
                    'data' => $conflicting_tasks
                ], 422);
            }
        }

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
            'message' => 'Task added successfully',
            'data' => $task
        ], 200);
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
                'message' => 'Fetch Successfully',
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
                'message' => 'Task Updated Successfully',
                'data' => $task
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Task Not Found'
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
            'message' => 'Task Removed Successfully',
            'data' => $id
        ], 200);

    }

    public function allTasksByCategory($id)
    {
        $user = Auth::user();
        
        return response()->json([
            'success' => true,
            'message' => 'Fetch Successfully',
            'data' => Task::where('category_id', $id)
                          ->where('user_id', $user->id)->get()
        ], 200);
    }

    public function allStarredTasks()
    {
        $user = Auth::user();

        return response()->json([
            'success' => true,
            'message' => 'Fetch Successfully',
            'data' => Task::where('is_starred', 1)
                          ->where('user_id', $user->id)
                          ->with('category:id,category_name,color')->get()
        ], 200);
    }

    public function getTaskType($id)
    {
        $user = Auth::user();

        return response()->json([
            'success' => true,
            'message' => 'Fetch Successfully',
            'data' => Task::where('task_type_id', $id)
                          ->where('user_id', $user->id)
                          ->with('category:id,category_name,color')->get()
        ], 200);
    }

    public function filter(Request $request)
    {
        $user = Auth::user();
        
        try {
            return response()->json([
                'success' => true,
                'message' => 'Fetched Successfully',
                'data' =>  Task::OrWhere($this->getSearchFields($request))
                        ->where('user_id', $user->id)
                        ->with('category:id,category_name,color')->get()
            ], 200);
        } catch (UnprocessableEntityHttpException $e) {
            return $this->throwError($e->getMessage());
        }
    }

    public function sortFilter(Request $request, $by = 'id', $order = 'asc')
    {
        $user = Auth::user();
        $tasks = Task::OrWhere($this->getSearchFields($request))
                ->orderBy($by, $order)
                ->where('user_id', $user->id)
                ->with('category:id,category_name,color')->get();

        return response()->json([
            'success' => true,
            'message' => 'Fetch Successfully!',
            'data' => $tasks
        ], 200);

        return response()->json([
            'success' => false,
            'message' => 'Fetch Failed.'
        ], 422);
    }
    

    /**
     * @param Request $request
     * @return array
     */
    protected function getSearchFields(Request $request) {

        $params = $request->query->all();

        $where = [];

        foreach($params as $field => $value) {

            if(!in_array($field, $this->getValidSearchFields())) {
                throw new UnprocessableEntityHttpException('Invalid search field.');
            }

            $where[] =  [$field, "like", "%{$value}%", "or"];
        }

        return $where;
    }

    /**
     * @return array
     */
    protected function getValidSearchFields()
    {
        return [
            'category_id',
            'task_type_id',
            'task_name',
            'task_desc',
            'status',
            'is_starred',
            'priority',
            'start_date',
            'end_date',
            'start_time',
            'end_time',
            'updated_at',
            'category_name'
        ];
    }

    public function recent()
    {
        $user = Auth::user();
        $task = Task::latest('updated_at')->where('user_id', $user->id)->with('category:id,category_name,color')->get();

        return response()->json([
            'success' => true,
            'message' => 'Fetch Successfully',
            'data' => $task
        ], 200);

        return response()->json([
            'success' => false,
            'message' => 'Fetch Failed'
        ], 422);


    }

    public function sort($by, $order, $category ='status', $id = 'pending')
    {
        $user = Auth::user();
        $tasks = Task::orderBy($by, $order)
                ->where('user_id', $user->id)
                ->where($category, $id)
                ->with('category:id,category_name,color')->get();

        return response()->json([
            'success' => true,
            'message' => 'Fetch Successfully!',
            'data' => $tasks
        ], 200);

        return response()->json([
            'success' => false,
            'message' => 'Fetch Failed.'
        ], 422);


    }
}