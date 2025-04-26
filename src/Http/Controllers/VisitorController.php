<?php

namespace Doker42\VisitorsWatcher\Http\Controllers;

use Doker42\VisitorsWatcher\Models\Url;
use Doker42\VisitorsWatcher\Models\Visitor;
use Doker42\VisitorsWatcher\Services\PathService;
use Doker42\VisitorsWatcher\Services\UriService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Cache;


class VisitorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'ip' => 'nullable|string|max:32'
        ]);
        $ip = $request->get('ip');
        $sortOrder = $request->get('sort', 'desc');
        $perPage   = $request->get('per_page', 15);
        $visitorQuery = Visitor::query();
        if ($ip) {
            $visitorQuery->where("ip","LIKE","%$ip%");
        }
        $visitors = $visitorQuery->orderBy('visited_date', $sortOrder)
            ->paginate($perPage)
            ->appends(['sort' => $sortOrder]);

        $allowedUrls  = config('visitors.site_urls');
        $badAgents = config('admin.bad_agents');
        $badPaths  = config('admin.bad_paths');

        return view('visitors::visitors.list',
            compact('visitors', 'sortOrder', 'perPage', 'allowedUrls','badAgents', 'badPaths'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Visitor $visitor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Visitor $visitor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Visitor $visitor)
    {
        //
    }

    public function banUpdate(Request $request)
    {
        $validated = $request->validate([
            'id'  => 'required|string|exists:visitors,id',
            'ban' => ['required', Rule::in([0,1])] ,
        ]);

        $visitor = Visitor::find($validated['id']);
        $visitor->update(['banned' => $validated['ban']]);
        $this->updateBanList();

        return redirect(route('visitors.visitor.list'));
    }


    protected function updateBanList()
    {
        if (Cache::has(Visitor::BAN_LIST)) {
            Cache::forget(Visitor::BAN_LIST);
        }

        $banned = Visitor::where('banned', true)
            ->get()
            ->pluck('ip')
            ->toArray();

        Cache::forever(Visitor::BAN_LIST, $banned);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Visitor $visitor)
    {
        //
    }


    public function autocompleteByIp(Request $request)
    {
        $data = Visitor::where("ip","LIKE","%{$request->input('query')}%")
            ->limit(10)
            ->get();

        return response()->json($data);
    }
}
