<?php

namespace App\Http\Controllers;

use App\Http\Requests\WorkedPeriodStoreRequest;
use App\Http\Requests\WorkedPeriodUpdateRequest;
use App\Models\WorkedPeriod;
use App\Repositories\TagRepository;
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

    public function store(WorkedPeriodStoreRequest $request)
    {
        $userId = Auth::id();

        if($tag = $request->validated('tag')) {
            $tag = TagRepository::getOrCreateTag($userId, $tag);
        }

        WorkedPeriod::create([
            'user_id' => $userId,
            'date' => $request->validated('date'),
            'start' => $request->validated('start'),
            'end' => $request->validated('end'),
            'tag_id' => $tag ? $tag->id : null,
        ]);

        return redirect()->back();
    }

    public function update(WorkedPeriodUpdateRequest $request, WorkedPeriod $period)
    {
        // Verify permissions
        $this->authorize('update', $period);

        $userId = Auth::id();

        if($tag = $request->validated('tag')) {
            $tag = TagRepository::getOrCreateTag($userId, $tag);
        }

        $period->update([
            'start' => $request->validated('start'),
            'end' => $request->validated('end'),
            'tag_id' => $tag ? $tag->id : null,
        ]);

        return redirect()->back();
    }

    public function destroy(WorkedPeriod $period)
    {
        // Verify permissions
        $this->authorize('destroy', $period);

        // Delete time
        $period->delete();
    }
}
