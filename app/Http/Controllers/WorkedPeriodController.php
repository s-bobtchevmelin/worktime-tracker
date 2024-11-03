<?php

namespace App\Http\Controllers;

use App\Models\WorkedPeriod;
use App\Repositories\TagRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class WorkedPeriodController extends Controller
{
    private function validator($request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'start' => 'required|date_format:H:i:s',
            'end' => 'required|date_format:H:i:s',
            'tag' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect('/dashboard')->withErrors($validator)->withInput();
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function indexWeek(string $start, string $end)
    {
        return WorkedPeriod::where('user_id', Auth::id())
            ->whereBetween('date', [date($start), date($end)])
            ->with('tag')
            ->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validator($request);

        $userId = Auth::id();

        $tag = TagRepository::getOrCreateTag($userId, $request->get('tag'));

        WorkedPeriod::create([
            'user_id' => $userId,
            'date' => $request->get('date'),
            'start' => $request->get('start'),
            'end' => $request->get('end'),
            'tag_id' => $tag->id,
        ]);

        return redirect('/dashboard');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WorkedPeriod $workedPeriod)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $period = WorkedPeriod::find($id);
        if ($period && $period->user_id === Auth::id()) {
            WorkedPeriod::destroy($id);
        }
    }
}
