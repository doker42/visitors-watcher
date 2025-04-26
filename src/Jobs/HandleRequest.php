<?php

namespace Doker42\VisitorsWatcher\Jobs;

use Doker42\VisitorsWatcher\Handlers\RequestHandler;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class HandleRequest implements ShouldQueue
{
    use Queueable;

    public array $data;
    /**
     * Create a new job instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        RequestHandler::handle($this->data);
    }
}
