<?php
namespace App\Modules\Order\Enums;

enum OrderCancelItemReasonEnum: int 
{
    case ORDER_ERR = 1;
    case CUSTOMER_REQUIRE = 2;
    case UNVAILABLE_ITEM = 3;
    case ITEM_LATE_DELIVERY = 4;
    case DISSATISFIED_CUSTOMER = 5;
    case OTHER = 6;

    public function getLabel(): string
    {
        return match($this){
            self::ORDER_ERR => "Erro no pedido",
            self::CUSTOMER_REQUIRE => "Solicaçao do cliente",
            self::UNVAILABLE_ITEM => "Item esgotado",
            self::ITEM_LATE_DELIVERY => "Demora na entrega",
            self::DISSATISFIED_CUSTOMER => "Qualidade insatisfatória/Cliente insatisfeito",
            self::OTHER => "Outro",
            default => ''
        };
    }
}