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

        $payments = $stripe->customers->all([
            config('dashboard.tiles.stripe.payments.params') ?? [],
        ]);

        $payments = collect($payments->data)
            ->map(function ($payment) {
                return [
                    'name' => $payment->name,
                    'customer_id' => $payment->id,
                    'email' => $payment->email,
                    'createdAt' => Carbon::parse($payment->created)
                        ->format("d.m.Y"),
                ];
            })->toArray();

        StripePaymentsStore::make()->setData($payments);

        $this->info('All done!');

        return 0;
    }
}
