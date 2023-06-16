<?php

namespace App\Http\Controllers;

use App\Models\Subscriptions;
use App\Services\SubscribeService;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    /**
     * @var SubscribeService
     */
    private $subscribeService;

    public function __construct(SubscribeService $subscribeService)
    {
        $this->subscribeService = $subscribeService;
    }
    public function subscribe(Request $request)
    {

        $request->validate([
            'receipt' => ['required','max:255'],
        ]);

        $device = $request->user();

        $status = $this->subscribeService->checkReceipt($device, $request->receipt);

        $expire_date = $this->subscribeService->saveSubscription($device, $status, $request->receipt);

        return response()->json([
            'status' => $status,
            'expire-date' => $expire_date
        ], 201);
    }

    public function checkSubscribe(Request $request)
    {
        $device = $request->user();

        $subscribe = Subscriptions::where('device_uuid', $device->id)->first();

        return response()->json([
            'status' => $subscribe ? $subscribe->status : 0,
            'expire-date' => $subscribe ? $subscribe->expire_end : null
        ], 201);

    }

}
