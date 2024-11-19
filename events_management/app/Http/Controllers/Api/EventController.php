<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Database\Eloquent\Collection
    {
        return Event::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): Event
    {
        $event = Event::create([
            ...$request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'start_time' => 'required|date',
                'end_time' => 'required|date|after:start_time',
            ]),
            'user_id' => 1, // 暫時把新增的活動都先掛在 user_id 1 身上
        ]);

        return $event;
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event): Event
    {
        return $event;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
