###Context
An online marketplace is looking for a new partner to handle the calculation of the cart value of its visitors. Given the items in the cart, and their price with the reseller currency, we must return the total price of the cart, in the currency chosen by the visitor. The prices of the various items in the cart might be expressed in different currencies. At least US dollars, Euros, and Japanese Yen are supported as input and output currencies
###Goal

Provide an endpoint that will consume the openexchangerates.org to calculate the cart value at current exchange rates, rounded to 2 decimal places. Must be written in PHP.  The solution should include automated tests.
###Example of received payload (POST)
```json
{
    "items":{
        "42":{
            "currency":"EUR",
            "price":49.99,
            "quantity":1
        },
        "55":{
            "currency":"USD",
            "price":12,
            "quantity":3
        }
    },
    "checkoutCurrency":"EUR"
}
```

###Expected response
The response should be JSON encoded, and contains at least the following keys:
```json
{
    "checkoutPrice":82.18,
    "checkoutCurrency":"EUR"
}
```
###How to Deliver the Solution
Produce an archive of your Git repository, either a ZIP file or a tarball. Send us the archive along with instructions how to build, run, and test your application

<hr>

Installation:
- composer install
- cp .env.example .env
- php artisan key:generate

<hr>

Request:
```shell
curl -s -X POST /api/cart-price -d 'cart={"items":{"42":{"currency":"EUR","price":49.99,"quantity":1},"55":{"currency":"USD","price":12,"quantity":3}},"checkoutCurrency":"EUR"}'
```

Example of response:
```json
{
   "error":false,
   "checkoutPrice":94.41,
   "checkoutCurrency":"EUR"
}
```

Example of response error:
```json
{
    "error":true,
    "explain":"Currency \"someInvalidCurrency\" is not supported."
}
```
