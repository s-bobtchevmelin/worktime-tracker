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

    public function update(Request $request, WorkedPeriod $period)
    {
        $validated = $request->validate([
            'start' => 'required|string',
            'end' => 'required|string',
            'tag' => 'nullable|string',
        ]);

        $userId = Auth::id();
        
        // Manage tag
        $tagName = $validated['tag'] ?? null;
        $tagId = null;
        
        if ($tagName) {
            // Use repository to get or create the tag
            $tag = TagRepository::getOrCreateTag($userId, $tagName);
            $tagId = $tag ? $tag['id'] : null;
        }
        
        // Update period with start, end and tag values
        $period->update([
            'start' => $validated['start'],
            'end' => $validated['end'],
            'tag_id' => $tagId,
        ]);
        
        return response()->json([
            'message' => 'Period updated successfully',
            'period' => $period->fresh()->load('tag')
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
