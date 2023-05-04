<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Feedback;
use Illuminate\Http\Request;
use App\Services\FeedbackService;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\FeedbackRequest;


class FeedbackController extends Controller
{
    private FeedbackService $feedbackService;

    public function __construct(FeedbackService $feedbackService){
        $this->feedbackService = $feedbackService;
    }   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $datas = User::where('email', $user->email)->first();
        $feedback = Feedback::where('user_id', $datas->id)->get();

        return response()->json([
            'success' => true,
            'message' => 'Fetch successfully',
            'data' => [
                "data" => $feedback
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
    public function store(FeedbackRequest $request)
    {
        //
        if($request->validated()) {

            $data = $this->feedbackService->create($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Adding Feedback Succesful!',
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
        $feedback = Feedback::find($id);
        if ($feedback) {
            return response()->json([
                'success' => true,
                'message' => 'Feedback Found',
                'data' => $feedback
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Feedback not found'
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
    public function update(FeedbackRequest $request, $id)
    {
        $feedback = Feedback::find($id);
        if ($feedback){
            $feedback->update($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Feedback Successfully Updated',
                'data' => $feedback
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Feedback not found'
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
        Feedback::where('id', $id)->delete();
        return response()->json([
            'success' => true,
            'message' => 'Feedback Removed Successfully',
            'data' => $id
        ], 200);
    }

    public function allFeedbacks()
    {
        $feedback = Feedback::with('user')->get();

        return response()->json([
            'success' => true,
            'message' => 'Fetch successfully',
            'data' => [
                "data" => $feedback
            ]
        ], 200);
    }
}