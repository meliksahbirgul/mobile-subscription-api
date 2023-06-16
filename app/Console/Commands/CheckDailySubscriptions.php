<?php

namespace App\Console\Commands;

use App\Models\Subscriptions;
use Illuminate\Console\Command;
use Carbon\Carbon;

class CheckDailySubscriptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-daily-subscriptions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check subscriptions expire date';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $subscriptions = Subscriptions::where('status', 1)->whereDate('expire_end', '<=', Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now(), 'UTC')->shiftTimezone('Etc/GMT-6'))->get();

        foreach($subscriptions  as $subscription) {
            $subscription->status = 0;
            $subscription->expire_start = null;
            $subscription->expire_end = null;
            $subscription->save();
        }
    }
}
