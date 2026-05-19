<?php
namespace App\Modules\Table\Enums;

enum TableStatusEnum : int 
{
    case ACTIVE = 1;
    case INACTIVE = 2;
    case MANUTENTION = 3;
}