<?php
namespace App\Modules\Restaurant\Enums;

enum DepartmentEnum : int 
{
    case KITCHEN = 1;
    case HOT_KITCHEN = 2;
    case COLD_KITCHEN = 3;
    case PATISSERIE = 4;
    case WAITER_ROOM = 5;
    case BAR = 6;
    case ALL = 7;

    public function getLabel(): string {
        return match($this){
            self::KITCHEN       => "Cozinha",
            self::HOT_KITCHEN   => "Cozinha quente",
            self::COLD_KITCHEN  => "Cozinha fria",
            self::PATISSERIE    => "Confeitaria",
            self::WAITER_ROOM   => "Sala",
            self::BAR           => "Bar",
            self::ALL           => "Todos",
        };
    }
}