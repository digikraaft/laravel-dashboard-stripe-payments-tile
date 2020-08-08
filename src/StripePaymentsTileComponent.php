<?php

namespace Digikraaft\StripePaymentsTile;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithPagination;

class StripePaymentsTileComponent extends Component
{
    use WithPagination;

    /** @var string */
    public string $position;

    /** @var string|null */
    public ?string $title;

    public $perPage;

    /** @var int|null */
    public ?int $refreshInSeconds;

    public function mount(string $position, $perPage = 5, ?string $title = null, int $refreshInSeconds = null)
    {
        $this->position = $position;
        $this->perPage = $perPage;
        $this->title = $title;
        $this->refreshInSeconds = $refreshInSeconds;
    }

    public function render()
    {
        $payments = collect(StripePaymentsStore::make()->getData());
        $paginator = $this->getPaginator($payments);

        return view('dashboard-stripe-payments-tile::tile', [
            'payments' => $payments->skip(($paginator->firstItem() ?? 1) - 1)->take($paginator->perPage()),
            'paginator' => $paginator,
            'refreshIntervalInSeconds' => $this->refreshInSeconds ?? config('dashboard.tiles.stripe.payments.refresh_interval_in_seconds') ?? 1800,
        ]);
    }

    public function getPaginator(Collection $payments): LengthAwarePaginator
    {
        return new LengthAwarePaginator($payments, $payments->count(), $this->perPage, $this->page);
    }

    public function paginationView()
    {
        return 'dashboard-stripe-payments-tile::pagination';
    }
}
