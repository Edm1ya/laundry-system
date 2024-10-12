<?php

namespace App;

enum ServiceTypeEnum: string
{
    case Lavado = 'lavado';
    case Planchado = 'planchado';
    case Secado = 'secado';


    public static function indexed()
    {
        $arryIndexded = collect();
        foreach (Self::cases() as $key => $value) {
            $arryIndexded->put($value->value, $value->name);
        }

        return $arryIndexded;
    }
}
