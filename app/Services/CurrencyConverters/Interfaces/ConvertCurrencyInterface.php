<?php


namespace App\Services\CurrencyConverters\Interfaces;


interface ConvertCurrencyInterface
{
    public function convert(string $baseCurrency, string $currency, float $amount): float;
}
