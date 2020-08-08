<x-dashboard-tile :position="$position" :refresh-interval="$refreshIntervalInSeconds">
    <div class="grid grid-rows-auto-1 gap-2 h-auto">
        @isset($title)
            <h1 class="font-bold">
                {{ $title }} <span class="text-dimmed">({{$paginator->total()}})</span>
            </h1>
        @else
            <h1 class="font-bold">
               Stripe Customers <span class="text-dimmed">({{$paginator->total()}})</span>
            </h1>
        @endisset
        <ul class="self-center divide-y-2 divide-canvas">
            @foreach($customers as $customer)
                <li class="py-1">
                    <div class="my-2">
                        <div class="font-bold">
                            ID: <a href="https://dashboard.paystack.com/#/customers/{{ $customer['customer_id'] }}" target="_blank">
                                {{ $customer['customer_id'] }}
                            </a>
                        </div>
                        @isset($customer['name'])
                            <div class="text-sm text-dimmed">
                                Name: {{ $customer['name'] }}
                            </div>
                        @endisset
                        <div class="text-sm text-dimmed">
                            Email: <a href="mailto:{{ $customer['email'] }}">{{ $customer['email'] }}</a>
                        </div>
                        <div class="text-sm text-dimmed">
                            Added on: {{$customer['createdAt']}}
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
        {{$paginator}}
    </div>
</x-dashboard-tile>
