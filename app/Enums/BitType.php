<?php

namespace App\Enums;

use ReflectionClass;

class BitType
{
    const YES = "yes";
    const NO = "no";

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
