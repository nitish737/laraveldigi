<?php

namespace App\Enums;

use ReflectionClass;

class DayType
{
    const MONDAY = "monday";
    const TUESDAY = "tuesday";
    const WEDNESDAY = "wednesday";
    const THURSDAY = "thursday";
    const FRIDAY = "friday";
    const SATURDAY = "saturday";
    const SUNDAY = "sunday";

    public static function getItems() : array
    {
        $class = new ReflectionClass(__CLASS__);
        $items = [];
        foreach ($class->getConstants() as $item)
        {
            array_push($items, $item);
        }
        return $items;
    }
}
