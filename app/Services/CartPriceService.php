<?php


namespace App\Services;


use App\Services\CurrencyConverters\Exceptions\ConverterException;
use App\Services\CurrencyConverters\ExchangeRatesApiConverter;
use Illuminate\Http\Request;

class CartPriceService
{
    private $exchangeRatesApiConverter;

    public function __construct(ExchangeRatesApiConverter $exchangeRatesApiConverter)
    {
        $this->exchangeRatesApiConverter = $exchangeRatesApiConverter;
    }

    public function getCartPrice(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = validator($request->only('cart'), [
            'cart' => 'required|json'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'explain' => $validator->errors()
            ]);
        }
        $cartItems = json_decode($request->cart, true);
        $checkoutCurrency = $cartItems['checkoutCurrency'];
        $totalAmount = 0.0;
        foreach ($cartItems['items'] as $cartItem) {
            $currency = $cartItem['currency'];
            $price = $cartItem['price'];
            $quantity = $cartItem['quantity'];
            try {
                $totalAmount += $this->exchangeRatesApiConverter
                        ->convert($checkoutCurrency, $currency, $price) * $quantity;
            } catch (ConverterException $converterException) {
                return response()->json([
                    'error' => true,
                    'explain' => $converterException->getMessage(),
                ], 500);
            }
        }

        return response()->json([
            'error' => false,
            'checkoutPrice' => round($totalAmount, 2),
            'checkoutCurrency' => $checkoutCurrency,
        ]);
    }
}
