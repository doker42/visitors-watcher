<?php

namespace Doker42\VisitorsWatcher\Models;


use Doker42\VisitorsWatcher\Services\LocationVisitors;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Visitor extends Model
{
    public const BAN_LIST = 'visitorsBanList';
    public const IGNORED_IP = 'ignored_ip';

    protected $fillable = [
        'ip',
        'visited_date',
        'hits',
        'banned',
        'location'
    ];

    public function agents()
    {
        return $this->hasMany(Agent::class);
    }

    public function urls()
    {
        return $this->hasMany(Url::class);
    }


    private function urlsArray()
    {
        return $this->urls()->pluck('uri')->toArray();
    }


    public function hasExtraUri()
    {
        $extraUrls = array_diff($this->urlsArray(),config('admin.site_urls'));
        return !empty($extraUrls);
    }


    public static function isBanned(string $ip)
    {
        $banned = false;
        if (Cache::has(Visitor::BAN_LIST)) {
            $banList = Cache::get(Visitor::BAN_LIST);
            if (is_array($banList) && count($banList)) {
                $banned = in_array($ip, $banList);
            }
        }
        else {
            $visitor = self::where('ip', $ip)->first();
            $banned = $visitor ? $visitor->banned : false;
        }

        return $banned;
    }


    public static function store(array $data): Visitor
    {
        $ip     = $data['ip'];
        $method = $data['method'];
        $visited_date = Date("Y-m-d:H:i:s");
        $location = LocationVisitors::getLocation($ip);
        $location = $location ? $location['country'] . " : " . $location['city'] : "noname";
        $visitor  = Visitor::updateOrCreate([
            'ip' => $ip,
        ],
        [
            'location' => $location,
            'visited_date' => $visited_date
        ]);
        $visitor->increment('hits');

        if ($method != Url::GET_METHOD) {
            $visitor->banned = true;
        }

        return $visitor;
    }

    public static function isIgnoredIp(string $ip): bool
    {
        $ignored = false;
        if (Cache::has(IgnoredIp::IGNORED_IP_LIST)) {
            $ignoredIpList = Cache::get(IgnoredIp::IGNORED_IP_LIST);
            if (is_array($ignoredIpList) && count($ignoredIpList)) {
                $ignored = in_array($ip, $ignoredIpList);
            }
        }
        else {
            $ip = IgnoredIp::where('ip', $ip)->first();
            $ignored = (bool)$ip;
        }

        return $ignored ;
    }
}
