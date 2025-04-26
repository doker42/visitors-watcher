<?php

namespace Doker42\VisitorsWatcher\Handlers;


use Doker42\VisitorsWatcher\Models\Agent;
use Doker42\VisitorsWatcher\Models\Url;
use Doker42\VisitorsWatcher\Models\Visitor;

class RequestHandler
{

    public static function handle(array $data)
    {
        $visitor = Visitor::store($data);
        Url::store($visitor, $data);
        Agent::store($visitor, $data);
    }
}
