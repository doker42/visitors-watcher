<?php

namespace Doker42\VisitorsWatcher\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class IgnoredIp extends Model
{
    protected $fillable = ['ip'];

    public const IGNORED_IP_LIST = 'ignored_ip_list';


    public static function updateIgnoredIpList(): void
    {
        if (Cache::has(self::IGNORED_IP_LIST)) {
            Cache::forget(self::IGNORED_IP_LIST);
        }

        $ips = self::all()
            ->pluck('ip')
            ->toArray();

        Cache::forever(self::IGNORED_IP_LIST, $ips);
    }
}
