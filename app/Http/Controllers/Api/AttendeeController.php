<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AttendeeResource;
use App\Models\Attendee;
use App\Models\Event;
use Illuminate\Http\Request;

class AttendeeController extends Controller
{

    public function  __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'show', 'update']);
        $this->authorizeResource(Event::class, 'event');
    }
    public function index(Event $event)
    {
        $attendees = $event->attendees()->latest();

        return AttendeeResource::collection(
            $attendees->paginate(5)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Event $event)
    {
        $attendee = $event->attendees()->create([
            'user_id' => 1
        ]);

        return new AttendeeResource($attendee);
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event, Attendee $attendee)
    {
        return new AttendeeResource($attendee);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event, Attendee $attendee)
    {
        // $this->authorize('delete-attendee', [$event, $attendee]);

        $attendee->delete();

        return response(status: 204);
    }
}
