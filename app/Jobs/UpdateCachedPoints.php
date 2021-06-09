<?php

namespace App\Jobs;

use App\Helpers\UserHelper;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateCachedPoints implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $users = UserHelper::active()->get();
        $users->each(function ($user, $key) {
            $total = 0;
            foreach ($user->groups as $group) {
                $points = UserHelper::points($user, $group);
                UserHelper::cachePoints($user, $group, $points);
                $total += $points;
            }
            UserHelper::cachePoints($user, null, $total);
        });
    }
}
