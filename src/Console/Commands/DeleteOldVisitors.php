<?php

namespace Doker42\VisitorsWatcher\Console\Commands;

use Carbon\Carbon;
use Doker42\VisitorsWatcher\Models\Visitor;
use Illuminate\Console\Command;

class DeleteOldVisitors extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete-old-visitors';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'delete old visitors';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $oldDate = Carbon::now()->subMonth();
        Visitor::where('visited_date', '<', $oldDate)->delete();
    }
}
