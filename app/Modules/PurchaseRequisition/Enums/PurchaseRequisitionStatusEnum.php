<?php
namespace App\Modules\PurchaseRequisition\Enums;

use App\Modules\PurchaseRequisition\Exceptions\PurchaseRequisitionException;

enum PurchaseRequisitionStatusEnum: int 
{
    case DRAFT = 1;
    case APPROVED = 2;
    case PARCIAL = 3;
    case COMPLETED = 4;
    case REJECTED = 5;

    public function getLabel(): string
    {
        return match($this) {
            self::DRAFT => "Pendente",
            self::APPROVED => "Aprovado",
            self::PARCIAL => "Parcial",
            self::COMPLETED => "Completo",
            self::REJECTED => "Rejeitada",
            default => throw new PurchaseRequisitionException("status da requisiçao nao existe.", 400)
        };
    }
    public function getSeverity(): string
    {
        return match($this) {
            self::DRAFT => "severity-amber",
            self::APPROVED => "severity-success",
            self::PARCIAL => "severity-purple",
            self::COMPLETED => "severity-blue",
            self::REJECTED => "severity-danger"
        };
    }

    public function isDraft(): bool
    {
        return $this->value === 1;
    }

    public function isApproved(): bool
    {
        return $this->value === 2;
    }

    public function isParcial(): bool
    {
        return $this->value === 3;
    }

    public function isCompleted(): bool
    {
        return $this->value === 4;
    }
    public function isRjected(): bool
    {
        return $this->value === self::REJECTED->value;
    }

    public function isEditable(): bool
    {
        return in_array($this->value, [self::DRAFT->value, self::REJECTED->value]);
    }
}