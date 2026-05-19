<?php
namespace App\Modules\Payment\Enums;

enum PaymentMethodEnum: int {
    case CASH = 1;
    case DEBIT = 2;
    case CREDIT = 3;
    case VOUCHER = 4;
    case PIX = 5;

    public function getLabel(): string
    {
        return match($this) {
            self::CASH      => 'Dinheiro / Cash',
            self::DEBIT     => 'Cartao de débito',
            self::CREDIT    => 'Cartao de crédito',
            self::VOUCHER   => 'Vaoucher - VA/VR',
            self::PIX       => 'Pix'
        };
    }

    public function getSeverity(): string 
    {
        return match($this) {
            self::CASH => 'tag-blue',
            self::DEBIT  => 'tag-purple',
            self::CREDIT => 'tag-green-dark',
            self::VOUCHER    => 'tag-purple',
            self::PIX => 'tag-greenlight'
        };
    }
}