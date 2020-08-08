<?php

namespace Digikraaft\StripePaymentsTile;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Stripe\StripeClient;

class FetchPaymentsDataFromStripeApi extends Command
{
    protected $signature = 'dashboard:fetch-payments-data-from-stripe-api';

    protected $description = 'Fetch data for Stripe payments tile';

    public function handle()
    {
        $stripe = new StripeClient(
            config('dashboard.tiles.stripe.secret_key', env('STRIPE_SECRET'))
        );

        $this->info('Fetching Stripe payments ...');

        $payments = $stripe->charges->all([
            config('dashboard.tiles.stripe.payments.params') ?? [],
        ]);

        $payments = collect($payments->data)
            ->map(function ($payment) {
                return [
                    'id' => $payment->id,
                    'amount' => $this->toReadableAmount($payment->amount),
                    'currency' => strtoupper($payment->currency),
                    'customer' => $this->getCustomerEmailFromStripe($payment->customer),
                    'status' => $payment->status,
                    'captured' => $payment->captured,
                    'createdAt' => Carbon::parse($payment->created)
                        ->format("d.m.Y"),
                ];
            })->toArray();

        StripePaymentsStore::make()->setData($payments);

        $this->info('All done!');

        return 0;
    }

    public function toReadableAmount($baseAmount)
    {
        return $baseAmount / 100;
    }

    /**
     * @param string|null $customer
     * @return string|null
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function getCustomerEmailFromStripe(?string $customer = null): ?string
    {
        if (! $customer) {
            return null;
        }
        $stripe = new StripeClient(
            config('dashboard.tiles.stripe.secret_key', env('STRIPE_SECRET'))
        );

        return $stripe->customers->retrieve(
            $customer,
        )->email;
    }
}
