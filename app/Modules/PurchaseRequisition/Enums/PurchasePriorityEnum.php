<?php
namespace App\Modules\PurchaseRequisition\Enums;

enum PurchasePriorityEnum : int
{
    case NORMAL = 1;
    case HIGHT = 2;
    case URGENT = 3;

    public function getLabel(): string
    {
        return match($this){
            self::NORMAL => "normal",
            self::HIGHT     => "alta",
            self::URGENT    => "urgente"
        };
    }

    public function getSeverity(): string
    {
        return match($this){
            self::NORMAL => "tag-blue",
            self::HIGHT     => "tag-amber",
            self::URGENT    => "tag-danger"
        };
    }
}