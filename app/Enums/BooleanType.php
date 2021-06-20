<?php

namespace App\Enums;

use ReflectionClass;

class BooleanType
{
    const NO = "no";
    const YES = "yes";

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
