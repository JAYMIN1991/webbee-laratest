<?php

namespace App\Repositories\Event;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class EventRepository
{

    protected $model;

    public function __construct(Event $model)
    {
        $this->model = $model;
    }

    public function getEventsWithWorkshops(){
        return $this->model->with('workshops')->get();
    }

    public function getFutureEventsWithWorkshops(){
        return $this->model->withAndWhereHas('workshops', function ($query){
            $query->where('start', '>=', Carbon::now());
        })->get();
    }
}
