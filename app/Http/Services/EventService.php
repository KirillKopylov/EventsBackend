<?php


namespace App\Http\Services;


use App\Models\Event;
use Illuminate\Http\JsonResponse;
use Exception;

class EventService
{
    public function createEvent(array $eventData): JsonResponse
    {
        try {
            Event::create($eventData);
            return ResponseService::successResponse( __('events_crud.eventCreated'));
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
}
