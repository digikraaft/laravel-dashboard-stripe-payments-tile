<x-dashboard-tile :position="$position" :refresh-interval="$refreshIntervalInSeconds">
    <div class="grid grid-rows-auto-1 gap-2 h-auto">
        @isset($title)
            <h1 class="font-bold">
                {{ $title }} <span class="text-dimmed">({{$paginator->total()}})</span>
            </h1>
        @else
            <h1 class="font-bold">
               Stripe Payments <span class="text-dimmed">({{$paginator->total()}})</span>
            </h1>
        @endisset
        <ul class="self-center divide-y-2 divide-canvas">
            @foreach($payments as $payment)
                <li class="py-1">
                    <div class="my-2">
                        <div class="font-bold">
                            Amount: {{$payment['currency']}} {{ $payment['amount'] }}
                        </div>
                        <div class="text-sm">
                            ID: <a href="https://dashboard.stripe.com/payments/{{ $payment['id'] }}" target="_blank">
                                {{ $payment['id'] }}
                            </a>
                        </div>
                        <div class="text-sm">
                            Status: <span class="{{($payment['status']=='succeeded')? 'text-green-700' : 'text-red-700'}}">{{$payment['status']}}</span>
                        </div>
                        @isset($payment['customer'])
                            <div class="text-sm text-dimmed">
                                Customer: <a href="mailto:{{$payment['customer']}}">
                                {{ $payment['customer'] }} </a>
                            </div>
                        @endisset
                        <div class="text-sm text-dimmed">
                            Date: {{$payment['createdAt']}}
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
        {{$paginator}}
    </div>
</x-dashboard-tile>
