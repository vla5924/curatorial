<?php

namespace App\Jobs;

use App\Helpers\PracticeHelper;
use App\Models\Practice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DestroyOldPractices implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    const RETENTION_PERIOD = 30 * 86400; // 30 days

    protected $initiatedAt;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->initiatedAt = time();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $oldCreatedAt = date('Y-m-d H:i:s', $this->initiatedAt - self::RETENTION_PERIOD);
        $oldPractices = Practice::where('created_at', '<', $oldCreatedAt)->get();
        $oldPractices->each(function ($practice, $key) {
            PracticeHelper::deepDestroy($practice);
        });
    }
}
