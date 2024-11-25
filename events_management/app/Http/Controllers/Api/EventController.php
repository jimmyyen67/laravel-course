<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventResource;
use App\Http\Traits\CanLoadRelationships;
use App\Models\Event;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection as AnonymousResourceCollectionAlias;
use Illuminate\Support\Facades\Gate;

class EventController extends Controller
{
    use CanLoadRelationships;

    // 這個屬性是用來定義該資源的關聯，這樣在載入資源時就可以一次載入所有關聯
    private readonly array $relations;

    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'show']);

        // authorizeResource 會將以下的授權檢查，自動映射到 Policy 中的對應方法：
        // index()   -> viewAny
        // show()    -> view
        // create()  -> create
        // store()   -> create
        // edit()    -> update
        // update()  -> update
        // delete()  -> delete
        $this->authorizeResource(Event::class, 'event');

        $this->relations = [
            'user',
            'attendees',
            'attendees.user',
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollectionAlias
    {
        $query = $this->loadRelationships(Event::query());
        return EventResource::collection(
            $query->latest()->paginate()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): EventResource
    {
        $event = Event::create([
            ...$request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'start_time' => 'required|date',
                'end_time' => 'required|date|after:start_time',
            ]),
            'user_id' => $request->user()->id,
        ]);
        return new EventResource($this->loadRelationships($event));
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event): EventResource
    {
        return new EventResource($this->loadRelationships($event));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event): EventResource
    {
        // if (Gate::denies('update-event', $event)) {
        //     abort(403, 'You are not authorized to update this event');
        // }

        // Using authorize is just the same as Gate, but you don't need to use abort() to return 403
        // also you are not able to use custom error message like "You are not authorized to update this event"
        // $this->authorize('update-event', $event);

        $event->update(
            $request->validate([
                'name' => 'sometimes|string|max:255',
                'description' => 'nullable|string',
                'start_time' => 'sometimes|date',
                'end_time' => 'sometimes|date|after:start_time',
            ])
        );
        return new EventResource($this->loadRelationships($event));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event): JsonResponse
    {
        $event->delete();
        return response()->json(status: 204); // 無論是否有找到該ID的活動，接返回204 success with no content
    }
}
