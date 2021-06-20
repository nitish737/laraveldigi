<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class StaffSchedule extends Model
{
    use HasFactory, LogsActivity;
    
    protected $fillable = [
        'staff_id',
        'timezone',
        'name',
        'is_default'
    ];

      /**
     * Attributes that will be logged
     */
    protected static $logAttributes = ['*'];

    /*
     * Relation between a business and its services
     */
    public function staff()
    {
        return $this->belongsTo('App\Models\BusinessStaffMember', 'staff_id', 'id');
    }

    /**
     * Relation between a schedule and its days
     */
    public function days()
    {
        return $this->hasMany('App\Models\StaffScheduleDay', 'staff_schedule_id', 'id');
    }


}
