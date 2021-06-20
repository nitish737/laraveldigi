<?php

namespace App\Enums;
use ReflectionClass;

class StatusType
{
    const ACTIVE = "active";
    const DISABLED = "disabled";

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
