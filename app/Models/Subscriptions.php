<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscriptions extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'device_uuid',
        'receipt_hash',
        'expire_start',
        'expire_end',
        'status'
    ];

    protected $dates = [
        'expire_start',
        'expire_end',
    ];

    public function device()
    {
        return $this->belongsTo(Devices::class, 'device_uuid');
    }

}
