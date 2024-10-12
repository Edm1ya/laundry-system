<?php

namespace App;

enum OrderStatusEnum: string
{
    case Pending = 'pending';
    case InProgress = 'in_progress';
    case Completed = 'completed';
    case Canceled = 'canceled';

    public static function indexed()
    {
        $arryIndexded = collect();
        foreach (Self::cases() as $key => $value) {
            $arryIndexded->put($value->value, $value->name);
        }

        return $arryIndexded;
    }
}
