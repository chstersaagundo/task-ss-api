<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
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
            'data' => Task::all()
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
    public function store(Request $request)
    {
        //
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
