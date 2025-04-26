<?php

namespace Doker42\VisitorsWatcher\Http\Controllers;

use Doker42\VisitorsWatcher\Models\IgnoredIp;
use Illuminate\Http\Request;

class IgnoredIpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ignoredIps = IgnoredIp::all();
        return view('visitors::visitors.ignoredIps.list', compact('ignoredIps'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('visitors::visitors.ignoredIps.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->validate([
            'ip' => 'required|ip',
        ]);

        $ip = IgnoredIp::create([
            'ip' => $input['ip']
        ]);

        if (!$ip) {
            return redirect(route('visitors.ignored_ip.create'))->withError('Failed to create!');
        }

        IgnoredIp::updateIgnoredIpList();

        return redirect(route('visitors.ignored_ip.list'))->with(['status' => 'Ok']);
    }

    /**
     * Display the specified resource.
     */
    public function show(IgnoredIp $ignoredIp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(IgnoredIp $ip)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, IgnoredIp $ip)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IgnoredIp $ip)
    {
        $ip = IgnoredIp::find($ip->id);
        if ($ip) {
            $ip->delete();
            IgnoredIp::updateIgnoredIpList();
            return redirect(route('visitors.ignored_ip.list'))->with(['status' => 'Ok']);
        }
        return redirect(route('visitors.ignored_ip.list'))->withError('Failed to delete!');
    }
}
