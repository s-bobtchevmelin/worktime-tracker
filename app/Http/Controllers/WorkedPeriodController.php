<?php

namespace App\Http\Controllers;

use App\Http\Requests\WorkedPeriodRequest;
use App\Models\WorkedPeriod;
use App\Repositories\TagRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkedPeriodController extends Controller
{
    /**
     * Get all worked periods for a date range.
     */
    public function indexWeek(string $start, string $end)
    {
        return WorkedPeriod::where('user_id', Auth::id())
            ->whereBetween('date', [date($start), date($end)])
            ->with('tag')
            ->get();
    }

    public function store(WorkedPeriodRequest $request)
    {
        $userId = Auth::id();
        $tag = $request->get('tag');

        if($request->get('tag')) {
            $tag = TagRepository::getOrCreateTag($userId, $tag);
        }

        WorkedPeriod::create([
            'user_id' => $userId,
            'date' => $request->get('date'),
            'start' => $request->get('start'),
            'end' => $request->get('end'),
            'tag_id' => $tag ? $tag->id : null,
        ]);
    }

    public function update(Request $request, WorkedPeriod $workedPeriod): WorkedPeriod
    {
        $userId = Auth::id();
        $workedPeriod = WorkedPeriod::find($workedPeriod->id);
        $tag = $request->get('tag');

        // Get worked period associate tag
        $workedPeriodTag = $workedPeriod->any('tag');

        // Update tag
        if($tag && $workedPeriodTag) {
            $workedPeriod->tag = TagRepository::getOrCreateTag($userId, $tag);
        }

        // Update period
        if ($workedPeriod) {
            $workedPeriod->date = $request->get('date');
            $workedPeriod->start = $request->get('start');
            $workedPeriod->end = $request->get('end');
        }

        // Save item
        $workedPeriod->save();
        
        return $workedPeriod;
    }

    public function destroy(WorkedPeriod $period)
    {
        abort_if(!$period, 404, "La plage horaire indiquée n'existe pas.");

        $this->authorize('destroy', $period);

        $period->delete();
    }
}
