<?php

namespace App\Http\Controllers;

use App\Http\Requests\Event\ShowEventRequest;
use App\Http\Resources\EventResource;
use App\services\EventService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class EventController extends Controller
{
    use ResponseTrait;

    public EventService $eventService;
    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    public function index(ShowEventRequest $request)
    {
        $events = $this->eventService->index($request->validated());
        $events = EventResource::collection($events);
        return $this->paginateSuccessResponse($events);
    }

    public function show($id)
    {
        $event = $this->eventService->show($id);
        $event = new EventResource($event);
        return $this->successResponse($event);
    }
}
