<?php


namespace App\Http\Services\Users;


use App\Models\EventUser;
use Illuminate\Http\JsonResponse;
use App\Http\Services\Helpers\ResponseService;
use Illuminate\Support\Facades\Mail;
use App\Models\Event;
use Illuminate\Support\Facades\DB;
use App\Mail\EventMemberAdded;
use Exception;

class UserService
{
    public function createUser(array $userData): JsonResponse
    {
        try {
            return DB::transaction(function () use ($userData) {
                $user = EventUser::create($userData);
                $eventName = Event::whereId($user->event_id)->first();
                Mail::to($user->email)
                    ->queue(new EventMemberAdded("{$user->first_name} {$user->last_name}", $eventName->title));
                return ResponseService::successResponse([
                    'message' => __('users_crud.userCreated'),
                    'id' => $user->id
                ], 200, 'response');
            });
        } catch (Exception $exception) {
            return ResponseService::errorResponse(__('users_crud.userNotCreated'));
        }
    }

    public function removeUser(int $id): JsonResponse
    {
        try {
            $user = EventUser::whereId($id)->first();
            if (is_null($user)) {
                return ResponseService::errorResponse(__('users_crud.userNotExists'), 404);
            } else {
                $user->delete();
                return ResponseService::successResponse(__('users_crud.userDeleted'));
            }
        } catch (Exception $exception) {
            return ResponseService::errorResponse(__('users_crud.userNotDeleted'));
        }
    }

    public function getUser(int $id): JsonResponse
    {
        try {
            $user = EventUser::whereId($id)->first();
            if (is_null($user)) {
                return ResponseService::errorResponse(__('users_crud.userNotExists'), 404);
            } else {
                return ResponseService::successResponse($user, 200, 'user');
            }
        } catch (Exception $exception) {
            return ResponseService::errorResponse(__('users_crud.unableToFetchUser'));
        }
    }

    public function updateUser(array $userData): JsonResponse
    {
        try {
            EventUser::whereId($userData['id'])->update($userData);
            return ResponseService::successResponse(__('users_crud.userUpdated'));
        } catch (Exception $exception) {
            return ResponseService::errorResponse(__('users_crud.userNotUpdated'));
        }
    }

    public function getUsers(): JsonResponse
    {
        try {
            $users = EventUser::paginate();
            return ResponseService::successResponse($users, 200, 'users');
        } catch (Exception $exception) {
            return ResponseService::errorResponse(__('users_crud.unableToFetchUsers'));
        }
    }
}
