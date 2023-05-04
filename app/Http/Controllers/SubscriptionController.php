<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Subscription;
use App\Models\SubscriptionType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\SubscriptionService;
use App\Http\Requests\SubscriptionRequest;

class SubscriptionController extends Controller
{
    private SubscriptionService $subService;

    public function __construct(SubscriptionService $subService){
        $this->subService = $subService;
    }   
    
    public function index()
    {
        $user = Auth::user();
        $subscription = Subscription::where('user_id', $user->id)->with('subscription_type')->get();

        return response()->json([
            'success' => true,
            'message' => 'Fetch successfully',
            'data' => $subscription
        ], 200);
    }

    public function allSubscriptions()
    {
        $user = Auth::user();
        
        return response()->json([
            'success' => true,
            'message' => 'Fetch successfully',
            'data' => $subscription = Subscription::with('subscription_type')->get(),
        ], 200);
    }

    public function storeSubData(SubscriptionRequest $request)
    {
        if($request->validated()) {

            if(!$this->subService->checkActiveSubscription()) {
                $data = $this->subService->create($request->validated());
    
                return response()->json([
                    'success' => true,
                    'message' => 'Adding Subscription Successful!',
                    "data" => [
                        "data" => $data
                    ]
                ], 200);
            }

            return response()->json([
                'success' => true,
                'message' => 'Already Subscribed to a Plan!'
            ], 422);

        }
        
        return response()->json([
            'success' => false,
            'message' => 'Request not valid'
        ], 422);
    }

    public function currentPlan()
    {
        $user = Auth::user();
        $subscription = Subscription::where('user_id', $user->id)
                    ->where('status', 'active')
                    ->with('subscription_type')->first();

        return response()->json([
            'success' => true,
            'message' => 'Fetch successfully',
            'data' => $subscription
        ], 200);
    }
}