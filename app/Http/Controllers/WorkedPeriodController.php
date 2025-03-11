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

    /**
     * Update the worked period values.
     */
    public function update(WorkedPeriodRequest $request, WorkedPeriod $period)
    {
        $userId = Auth::id();
        $tagName = $request->get('tag') ?? null;
        $tagId = null;
        
        if ($tagName) {
            $tag = TagRepository::getOrCreateTag($userId, $tagName);
            $tagId = $tag ? $tag['id'] : null;
        }
        
        $period->update([
            'start' => $request->get('start'),
            'end' => $request->get('end'),
            'tag_id' => $tagId,
        ]);
    }

    public function destroy(WorkedPeriod $period)
    {
        // Verify permissions
        $this->authorize('destroy', $period);

        // Delete time
        $period->delete();
    }
}
