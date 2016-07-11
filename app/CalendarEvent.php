<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use MaddHatter\LaravelFullcalendar\Event;

class CalendarEvent extends Model implements Event
{   
    

    protected $fillable = ['title', 'start', 'end', 'is_all_day', 'background_color'];
    


    protected $dates = ['start', 'end'];

    /**
     * Get the event's title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Is it an all day event?
     *
     * @return bool
     */
    public function isAllDay()
    {
        return $this->is_all_day;
    }

    /**
     * Get the start time
     *
     * @return DateTime
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Get the end time
     *
     * @return DateTime
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * Get the event's ID
     *
     * @return int|string|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Optional FullCalendar.io settings for this event
     *
     * @return array
     */
    public function getEventOptions()
    {
        return [
            'color' => $this->background_color,
        ];
    }
    /**
     * Optional FullCalendar.io settings for this event
     *
     * @return array
     */
     public function Organization()
    {
        return $this->belongsTo('App\Organization');
    }

    public function volunteers()
    {
        return $this->belongsToMany('App\Volunteer');
    }
}