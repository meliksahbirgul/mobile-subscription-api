<?php

namespace App\Services;

use App\Models\Devices;
use App\Models\Subscriptions;
use Carbon\Carbon;

class SubscribeService
{
    /**
         * Verilen recepti kontrol eder.
         *
         *  @return bool
         */
    public function checkReceipt($receipt)
    {
        $value = (int) substr($receipt, -1);

        if($value % 2 == 1) {
            return true;
        }

        return false;

    }

    public function saveSubscription(Devices $device, $status, $receipt)
    {
        $subscribe = Subscriptions::updateOrCreate(
            ['device_uuid' => $device->id,],
            [
            'receipt_hash'=> $receipt,
            'status' => $status,
            'expire_start' => $status ? Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now(), 'UTC')->shiftTimezone('Etc/GMT-6') : null,
            'expire_end' => $status ? Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now(), 'UTC')->shiftTimezone('Etc/GMT-6')->addMonth() : null,
        ]
        );

        return $subscribe->expire_end;
    }
}
