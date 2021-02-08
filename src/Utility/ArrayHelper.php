<?php


namespace App\Utility;


class ArrayHelper
{
    public static function getArrayFalse(): array // todo passer number example 5 en params boucle
    {
        return [
            1 => false,
            2 => false,
            3 => false,
            4 => false,
            5 => false
        ];
    }
}