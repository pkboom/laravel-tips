<?php

$factory->define(Order::class, function (Faker $faker) {
    $faker->addProvider(new PaymentTypeProvider($faker));
    return [
        'paymentMethod' => $faker->paymentMethod,
        'paymentPayload' => $faker->paymentPayload,
    ];
});

class PaymentTypeProvider extends \Faker\Provider\Base
{
    public function availablePaymentTypes()
    {
        return [CreditCard::class, BankPayment::class, ];
    }
    public function paymentMethod()
    {
        $paymentMethod = $this->generator->randomElement($this->availablePaymentTypes());

        return new $paymentMethod($this->paymentPayload());
    }

    public function paymentPayload()
    {
        return $this->generator->text;
    }
}
