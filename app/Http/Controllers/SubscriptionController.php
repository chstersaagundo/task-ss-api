<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SubscriptionService;

class SubscriptionController extends Controller
{
    private SubscriptionService $subService;

    public function __construct(SubscriptionService $subService){
        $this->subService = $subService;
    }   
    //
    public function storeSubData(){
        
        $data = $this->subService->create();

        return response()->json([
            'success' => true,
            'message' => 'Adding Subscription Succesful!',
        ], 200);
    }
}
