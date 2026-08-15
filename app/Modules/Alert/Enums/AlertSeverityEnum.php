<?php
namespace App\Modules\Alert\Enums;

enum AlertSeverityEnum : int 
{
    case INFO = 1;
    case WARNING = 2;
    case URGENT = 3;

    public function getLabel(): string 
    {
        return match($this) {
            self::INFO      => 'Informaçao',
            self::WARNING   => 'Aviso',
            self::URGENT    => 'Urgent',
            default => ''
        };
    }
}