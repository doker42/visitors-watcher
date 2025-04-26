<?php

namespace Doker42\VisitorsWatcher\Models;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    protected $fillable = [
        'name',
        'visitor_id'
    ];

    public static function store(Visitor $visitor, array $data)
    {
        self::firstOrCreate(
            [
                'visitor_id' => $visitor->id,
                'name'       => $data['agent'],
            ],
            []
        );
    }
}
