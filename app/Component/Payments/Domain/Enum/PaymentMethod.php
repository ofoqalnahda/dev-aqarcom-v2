<?php

namespace App\Component\Payments\Domain\Enum;

enum PaymentMethod: string
{
    case ELECTRONIC = 'electronic';
    case BANK = 'bank';
    case CREDIT_CARD = 'credit_card';
    case DEBIT_CARD = 'debit_card';
    case WALLET = 'wallet';
} 