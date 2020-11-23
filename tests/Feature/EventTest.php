<?php

namespace Tests\Feature;


use Tests\TestCase;
use Throwable;
use Faker\Factory;

class EventTest extends TestCase
{
    private $faker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->faker = Factory::create();
    }

    /**
     * @return string[]
     * @throws Throwable
     */

    public function testInsertEvent()
    {
        $data = [
            'title' => $this->faker->catchPhrase,
            'date' => $this->faker->dateTimeThisYear->format('Y-m-d h:i:s'),
            'city' => $this->faker->city,
        ];
        $response = $this->put("api/events/create-event", $data);
        $data['id'] = $response
            ->assertStatus(200)
            ->assertJson([
                'error' => false,
                'response' => [
                    'message' => __('events_crud.eventCreated')
                ]
            ])
            ->decodeResponseJson()['response']['id'];

        return $data;
    }

    /**
     * @depends testInsertEvent
     * @param array
     * @return int
     */

    public function testReadEventById(array $data)
    {
        $id = $data['id'];
        $response = $this->get("api/events/get-event/{$id}");
        $response
            ->assertStatus(200)
            ->assertJson([
                'error' => false,
                'event' => $data
            ]);
        return $id;
    }

    /**
     * @depends testReadEventById
     * @param int
     * @return int
     * @throws Throwable
     */

    public function testUpdateEvent(int $id)
    {
        $data = [
            'id' => $id,
            'title' => $this->faker->catchPhrase,
            'date' => $this->faker->dateTimeThisYear->format('Y-m-d h:i:s'),
            'city' => $this->faker->city
        ];
        $response = $this->patch('api/events/update-event', $data);
        $response
            ->assertStatus(200)
            ->assertJson([
                'error' => false,
                'message' => __('events_crud.eventUpdated')
            ]);
        $this->testReadEventById($data);
        return $id;
    }

    /**
     * @depends testUpdateEvent
     * @param $id
     * @return void
     */

    public function testDeleteEvent($id)
    {
        $response = $this->delete("api/events/remove-event/{$id}");
        $response
            ->assertStatus(200)
            ->assertJson([
                'error' => false,
                'message' => __('events_crud.eventDeleted')
            ]);
    }
}
