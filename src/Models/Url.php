<?php


namespace Doker42\VisitorsWatcher\Models;

use Doker42\VisitorsWatcher\Services\PathService;
use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    public const GET_METHOD = 'GET';

    protected $fillable = [
        'uri',
        'public',
        'method',
        'visitor_id'
    ];

    public static function store(Visitor $visitor, array $data)
    {

        $publicPaths = PathService::getPublicBasePaths();
        $public = in_array($data['path'], $publicPaths);

        Url::firstOrCreate(
            [
                'visitor_id' => $visitor->id,
                'uri'        => $data['url'],
                'public'     => $public,
                'method'     => $data['method'],
            ],
            []
        );
    }
}


