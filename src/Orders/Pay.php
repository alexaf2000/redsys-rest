<?php

declare(strict_types=1);

namespace RedsysRest\Orders;

use RedsysRest\Common\Currency;
use RedsysRest\Common\Params;

class Pay implements Order
{
    private const TYPE = 0;
    private $amount;
    private $number;
    private $card_number, $expiracy_date, $ccv2;
    private $tokenize = null;
    private $currency;
    private $merchant;
    private $terminal;

    public function __construct(
        string $amount,
        string $number,
        string $card_number,
        string $expiracy_date,
        string $ccv2,
        Currency $currency = null,
        string $merchant = null,
        string $terminal = null
    ) {
        $this->amount = $amount;
        $this->number = $number;

        $this->card_number = $card_number;
        $this->expiracy_date = $expiracy_date;
        $this->ccv2 = $ccv2;

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
            Params::PARAM_CARD_NUMBER => $this->card_number,
            Params::PARAM_CARD_CVV2 => $this->ccv2,
            Params::PARAM_CARD_EXPIRATION_DATE => $this->expiracy_date,
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
