<?php


namespace App\Http\Controllers\Events;


use App\Http\Requests\CreateEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Http\Services\EventService;

class EventController
{
    private $eventService;

    public function __construct(EventService $service)
    {
        $this->eventService = $service;
    }

    public function createEvent(CreateEventRequest $request)
    {
        return $this->eventService->createEvent($request->validated());
    }

    public function removeEvent($id)
    {
        return $this->eventService->removeEvent($id);
    }

    public function getEvent($id)
    {
        return $this->eventService->getEvent($id);
    }

    public function updateEvent(UpdateEventRequest $request)
    {
        return $this->eventService->updateEvent($request->validated());
    }
}
