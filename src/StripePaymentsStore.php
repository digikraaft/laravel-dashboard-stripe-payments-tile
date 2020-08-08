<?php

namespace Digikraaft\StripePaymentsTile;

use Spatie\Dashboard\Models\Tile;

class StripePaymentsStore
{
    private Tile $tile;

    public static function make()
    {
        return new static();
    }

    public function __construct()
    {
        $this->tile = Tile::firstOrCreateForName("stripePayments");
    }

    public function setData(array $data): self
    {
        $this->tile->putData('stripe.payments', $data);

        return $this;
    }

    public function getData(): array
    {
        return $this->tile->getData('stripe.payments') ?? [];
    }
}
