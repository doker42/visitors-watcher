<?php

namespace App\Jobs;

use App\Models\Visitor;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class VisitorLocationSet implements ShouldQueue
{
    use Queueable;

    public string $ip;

    /**
     * Create a new job instance.
     */
    public function __construct(string $ip)
    {
        $this->ip = $ip;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Visitor::handle($this->ip);
    }
}
