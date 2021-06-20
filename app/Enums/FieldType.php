<?php

namespace App\Enums;

use ReflectionClass;

class FieldType
{
    const TEXT = "text";
    const NUMBER = "number";
    const TEL = "tel";
    const CHECKBOX = "checkbox";
    const EMAIL = "email";
    const DATE = "date";
    const SELECT = "select";
    const RADIO = "radio";
    const TEXTAREA = "textarea";

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
