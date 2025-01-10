<?php
namespace App\Services;

use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;

class GoogleCalendarService
{
    private $client;
    private $service;

    public function __construct()
    {
        $this->client = new Google_Client();
        $this->client->setAuthConfig(storage_path('app/google-calendar/credentials.json'));
        $this->client->addScope(Google_Service_Calendar::CALENDAR);
        
        $this->service = new Google_Service_Calendar($this->client);
    }

    public function createTaskEvent($task)
    {
        $event = new Google_Service_Calendar_Event([
            'summary' => $task->title,
            'description' => $task->description,
            'start' => [
                'dateTime' => $task->due_date->format('c'),
                'timeZone' => 'UTC',
            ],
            'end' => [
                'dateTime' => $task->due_date->format('c'),
                'timeZone' => 'UTC',
            ],
        ]);

        return $this->service->events->insert('primary', $event);
    }
}