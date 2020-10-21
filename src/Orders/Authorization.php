<?php

declare(strict_types=1);

namespace RedsysRest\Orders;

use RedsysRest\Common\CreditCard;
use RedsysRest\Common\Currency;
use RedsysRest\Common\Params;

class Authorization implements Order
{
    private const TYPE = 0;
    private $amount;
    private $number;
    private $credit_card;
    private $tokenize = null;
    private $currency;
    private $merchant;
    private $terminal;

    public function __construct(
        string $amount,
        string $number,
        CreditCard $credit_card,
        Currency $currency = null,
        string $merchant = null,
        string $terminal = null
    ) {
        $this->amount = $amount;
        $this->number = $number;

        $this->credit_card = $credit_card;

        $this->currency = $currency;
        $this->merchant = $merchant;
        $this->terminal = $terminal;
    }

    public function params(): array
    {
        $array = [
            Params::PARAM_AMOUNT => $this->amount,
            Params::PARAM_ORDER => $this->number,
            Params::PARAM_CURRENCY => isset($this->currency) ? $this->currency->code() : null,
            Params::PARAM_MERCHANT => $this->merchant,
            Params::PARAM_TERMINAL => $this->terminal,
            Params::PARAM_CARD_NUMBER => $this->credit_card->number(),
            Params::PARAM_CARD_CVV2 => $this->credit_card->cvv2(),
            Params::PARAM_CARD_EXPIRATION_DATE => $this->credit_card->expirationYear(). $this->credit_card->expirationMonth(),
            Params::PARAM_TRANSACTION_TYPE => self::TYPE,
        ];
        if ($this->tokenize != null) {
            $array = array_merge($array, [Params::PARAM_MERCHANT_IDENTIFIER => $this->tokenize]);
        }

        return $array;
    }

    public function number(): string
    {
        return $this->number;
    }

    public function tokenizeCard(): void
    {
        $this->tokenize = "REQUIRED";
    }
}
