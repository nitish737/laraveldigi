<?php

namespace App\Enums;
use ReflectionClass;

class LanguageType
{
    const ENGLISH = "en";
    const SPANISH = "es";

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
