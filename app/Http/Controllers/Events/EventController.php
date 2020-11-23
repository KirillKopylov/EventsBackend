<?php


namespace App\Http\Controllers\Events;


use App\Http\Requests\Events\CreateEventRequest;
use App\Http\Requests\Events\UpdateEventRequest;
use App\Http\Services\Events\EventService;

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

    public function removeEvent(int $id)
    {
        return $this->eventService->removeEvent($id);
    }

    public function getEvent(int $id)
    {
        return $this->eventService->getEvent($id);
    }

    public function updateEvent(UpdateEventRequest $request)
    {
        return $this->eventService->updateEvent($request->validated());
    }

    public function getEvents()
    {
        return $this->eventService->getEvents();
    }

    public function getEventMembers(int $id)
    {
        return $this->eventService->getEventMembers($id);
    }
}
