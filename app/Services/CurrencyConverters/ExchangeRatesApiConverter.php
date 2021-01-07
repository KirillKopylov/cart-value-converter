<?php


namespace App\Services\CurrencyConverters;


use App\Services\NetworkWrappers\Exceptions\RequestException;
use App\Services\CurrencyConverters\Exceptions\ConverterException;
use App\Services\NetworkWrappers\RequestWrapper;
use App\Services\CurrencyConverters\Interfaces\ConvertCurrencyInterface;

class ExchangeRatesApiConverter implements ConvertCurrencyInterface
{
    private $requestWrapper;

    public function __construct()
    {
        $this->requestWrapper = new RequestWrapper;
    }

    public function convert(string $baseCurrency, string $currency, float $amount): float
    {
        $apiUrl = config('app.exchange_rates_api_url');
        $response = null;
        try {
            $response = $this->requestWrapper->get($apiUrl, ['base' => $baseCurrency]);
        } catch (RequestException $requestException) {
            throw new ConverterException("Request error: {$requestException->getMessage()}");
        }
        $rates = json_decode($response, true);
        if (!array_key_exists('rates', $rates)) {
            throw new ConverterException("Invalid response from $apiUrl: $response.");
        }
        $rates = $rates['rates'];
        if (!array_key_exists($currency, $rates) && $baseCurrency != $currency) {
            throw new ConverterException("Currency \"$currency\" is not supported.");
        }
        if ($currency == "EUR") {
            return $amount;
        }
        return $amount * $rates[$currency];
    }
}
