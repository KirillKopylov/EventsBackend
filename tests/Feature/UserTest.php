<?php

namespace Tests\Feature;


use Tests\TestCase;
use Throwable;
use Faker\Factory;

class UserTest extends TestCase
{
    private $faker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->faker = Factory::create();
    }

    /**
     * @return int
     * @throws Throwable
     */

    private function createEvent()
    {
        return $this
            ->put('api/events/create-event', [
            'title' => $this->faker->catchPhrase,
            'date' => $this->faker->dateTimeThisYear->format('Y-m-d h:i:s'),
            'city' => $this->faker->city,
        ])
            ->assertStatus(200)
            ->decodeResponseJson()['response']['id'];
    }

    /**
     * @param int $id
     * @return void
     */

    private function removeEvent(int $id)
    {
        $this->delete("api/events/remove-event/{$id}");
    }

    /**
     * @return array
     * @throws Throwable
     */

    public function testInsertUser()
    {
        $data = [
            'event_id' => $this->createEvent(),
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail
        ];
        $response = $this->put('api/users/create-user', $data);
        $data['id'] = $response
            ->assertStatus(200)
            ->assertJson([
                'error' => false,
                'response' => [
                    'message' => __('users_crud.userCreated')
                ]
            ])->decodeResponseJson()['response']['id'];
        return $data;
    }

    /**
     * @depends testInsertUser
     * @param array
     * @return array
     * @throws Throwable
     */

    public function testReadUserById(array $data)
    {
        $id = $data['id'];
        $response = $this->get("api/users/get-user/{$id}");
        return $response
            ->assertStatus(200)
            ->assertJson([
                'error' => false,
                'user' => $data
            ])
            ->decodeResponseJson()['user'];
    }

    /**
     * @depends testReadUserById
     * @param array
     * @return int []
     * @throws Throwable
     */

    public function testUpdateUser(array $data)
    {
        $newEvent = $this->createEvent();
        $oldEvent = $data['event_id'];
        $userId = $data['id'];
        $newData = [
            'id' => $userId,
            'event_id' => $newEvent,
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail
        ];
        $response = $this->patch('api/users/update-user', $newData);
        $response
            ->assertStatus(200)
            ->assertJson([
                'error' => false,
                'message' => __('users_crud.userUpdated')
            ]);
        $this->testReadUserById($newData);
        $this->removeEvent($oldEvent);
        return [
            'userId' => $userId,
            'newEventId' => $newEvent
        ];
    }

    /**
     * @depends testUpdateUser
     * @param string []
     * @return void
     */

    public function testDeleteUser(array $data)
    {
        $response = $this->delete("api/users/remove-user/{$data['userId']}");
        $response
            ->assertStatus(200)
            ->assertJson([
                'error' => false,
                'message' => __('users_crud.userDeleted')
            ]);
        $this->removeEvent($data['newEventId']);
    }

}
