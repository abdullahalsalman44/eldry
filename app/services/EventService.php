<?php

namespace App\services;

use App\Exceptions\NotFoundException;
use App\Models\Event;

class EventService
{

    public function index(array $data)
    {
        $query = Event::with('elderly');

        if (array_key_exists('from_date', $data) && array_key_exists('to_date', $data)) {
            $query = $query->whereBetween('date', [$data['from_date'], $data['to_date']]);
        }


        return $query->paginate();
    }

    public function show($id)
    {

        $event = Event::with('elderly')->find($id);

        if ($event == null) {
            throw new NotFoundException('Event Not Found', 404);
        }

        return $event;
    }
}
