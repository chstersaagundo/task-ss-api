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
        //kalibog shyet ahaha
        $user = Auth::user();
        $datas = User::where('email', $user->email)->first();
        $categories = Category::where('user_id', $datas->id)->get();

        return response()->json([
            'success' => true,
            'message' => 'Fetch successfully',
            'data' => $categories
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
                "data" => $data
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
                'message' => 'Category Found',
                'data' => $category
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Category not found'
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
    public function update(CategoryRequest $request, $id)
    {
        //find first the category id
        $category = Category::find($id);
        //if true
        if ($category){
            //update category by requesting inputs
            $category->update($request->all());
            //using update() method to put data into updated_at field in database, and I thank you.
            return response()->json([
                'success' => true,
                'message' => 'Category Successfully Updated',
                'data' => $category
            ], 200);
        }

        //otherwise return json response
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
    public function destroy($id)
    {
        Category::where('id', $id)->delete();
        return response()->json([
            'success' => true,
            'message' => 'Category Removed Successfully',
            'data' => $id
        ], 200);
    }
}
