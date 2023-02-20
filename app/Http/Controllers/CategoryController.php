<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Services\TaskService;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CategoryRequest;


class CategoryController extends Controller
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
        //kalibog shyet
        $user = Auth::user();
        $datas = User::where('email', $user->email)->first();
        $category = Category::where('user_id', $datas->id)->get();

        return response()->json([
            'success' => true,
            'message' => 'Fetch successfully',
            'data' => [
                "data" => $category
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
    public function store(CategoryRequest $request)
    {
        //
        if($request->validated()) {

            $data = $this->taskService->create($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Adding Category Succesful!',
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
        $category = Category::find($id);

        if ($category) {
            return response()->json([
                'success' => true,
                'message' => 'Fetch Successfully',
                'data' => $category
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Category::where('id', $id)->delete();
        return response()->json([
            'success' => true,
            'message' => 'Removed Successfully',
            'data' => $id
        ], 200);
    }
}
