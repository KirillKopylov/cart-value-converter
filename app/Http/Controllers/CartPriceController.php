<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Services\CartPriceService;

class CartPriceController
{
    public function getCartPrice(Request $request, CartPriceService $cartPriceService): \Illuminate\Http\JsonResponse
    {
        return $cartPriceService->getCartPrice($request);
    }
}
