<?php


namespace App\Http\Services\Events;


use App\Models\Event;
use Illuminate\Http\JsonResponse;
use App\Http\Services\Helpers\ResponseService;
use Exception;

class EventService
{
    public function createEvent(array $eventData): JsonResponse
    {
        try {
            $event = Event::create($eventData);
            return ResponseService::successResponse([
                'message' => __('events_crud.eventCreated'),
                'id' => $event->id
            ], 200, 'response');
        } catch (Exception $exception) {
            return ResponseService::errorResponse(__('events_crud.eventNotCreated'));
        }
    }

    public function removeEvent(int $id): JsonResponse
    {
        try {
            $event = Event::whereId($id)->first();
            if (is_null($event)) {
                return ResponseService::errorResponse(__('events_crud.eventNotExists'), 404);
            } else {
                $event->delete();
                return ResponseService::successResponse(__('events_crud.eventDeleted'));
            }
        } catch (Exception $exception) {
            return ResponseService::errorResponse(__('events_crud.eventNotDeleted'));
        }
    }

    public function getEvent(int $id): JsonResponse
    {
        try {
            $event = Event::whereId($id)->first();
            if (is_null($event)) {
                return ResponseService::errorResponse(__('events_crud.eventNotExists'), 404);
            } else {
                return ResponseService::successResponse($event, 200, 'event');
            }
        } catch (Exception $exception) {
            return ResponseService::errorResponse(__('events_crud.unableToFetchEvent'));
        }
    }

    public function updateEvent(array $eventData): JsonResponse
    {
        try {
            Event::whereId($eventData['id'])->update($eventData);
            return ResponseService::successResponse(__('events_crud.eventUpdated'));
        } catch (Exception $exception) {
            return ResponseService::errorResponse(__('events_crud.eventNotUpdated'));
        }
    }

    public function getEvents(): JsonResponse
    {
        try {
            $events = Event::paginate();
            return ResponseService::successResponse($events, 200, 'events');
        } catch (Exception $exception) {
            return ResponseService::errorResponse(__('events_crud.unableToFetchEvents'));
        }
    }

    public function getEventMembers(int $id): JsonResponse
    {
        try {
            $event = Event::whereId($id)->first();
            if (is_null($event)) {
                return ResponseService::errorResponse(__('events_crud.eventNotExists'), 404);
            }
            $eventMembers = $event->members()->paginate();
            return ResponseService::successResponse($eventMembers, 200, 'members');
        } catch (Exception $exception) {
            return ResponseService::errorResponse(__('events_crud.unableToFetchEvent'));
        }
    }
}
