<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\BlockWebsite;
use Illuminate\Http\Request;
use App\Services\BlockWebsiteService;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\BlockWebsiteRequest;


class BlockWebsiteController extends Controller
{
    private BlockWebsiteService $websiteBlockService;

    public function __construct(BlockWebsiteService $websiteBlockService){
        $this->websiteBlockService = $websiteBlockService;
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
        $blockwebsite = BlockWebsite::where('user_id', $datas->id)->get();

        return response()->json([
            'success' => true,
            'message' => 'Fetch successfully',
            'data' => $blockwebsite
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
    public function store(BlockWebsiteRequest $request)
    {
        //
        if($request->validated()) {

            $data = $this->websiteBlockService->create($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Adding Website Blocker Succesful!',
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
        $blockwebsite = BlockWebsite::find($id);
        if ($blockwebsite) {
            return response()->json([
                'success' => true,
                'message' => 'Data Found',
                'data' => $blockwebsite
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Data not found'
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
    public function update(BlockWebsiteRequest $request, $id)
    {
        $blockwebsite = BlockWebsite::find($id);
        if ($blockwebsite){
            $blockwebsite->update($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Website Block Successfully Updated',
                'data' => $blockwebsite
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Data not found'
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
        BlockWebsite::where('id', $id)->delete();
        return response()->json([
            'success' => true,
            'message' => 'Feedback Removed Successfully',
            'data' => $id
        ], 200);
    }

    // public function getBlockWebsitesById($id)
    // {
    //     $block_websites = BlockWebsite::where('user_id', $id)->get();

    //     if(count($block_websites) > 0) {
    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Fetch successfully',
    //             'data' => $block_websites
    //         ], 200);
    //     }

    //     return response()->json([
    //         'success' => false,
    //         'message' => 'Fetch Failed'
    //     ], 422);
    // }
}

    

