<div>
    <x-modal wire:model="recentSales" maxWidth="3xl">
        <x-slot name="title">
            {{ __('Recent Sales') }}
        </x-slot>
        <x-slot name="content">
            <div class="flex flex-wrap justify-center">
                <div class="lg:w-1/2 md:w-1/2 sm:w-full flex flex-wrap my-2">
                    <select wire:model="perPage"
                        class="w-20 block p-3 leading-5 bg-white dark:bg-dark-eval-2 text-gray-700 dark:text-gray-300 rounded border border-gray-300 mb-1 text-sm focus:shadow-outline-blue focus:border-blue-300 mr-3">
                        @foreach ($paginationOptions as $value)
                            <option value="{{ $value }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="lg:w-1/2 md:w-1/2 sm:w-full my-2">
                    <div class="my-2">
                        <input type="text" wire:model.debounce.300ms="search"
                            class="block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md mt-1"
                            placeholder="{{ __('Search') }}" />
                    </div>
                </div>
            </div>
            <div>
                <x-table>
                    <x-slot name="thead">
                        <x-table.th >
                            <input type="checkbox" wire:model="selectPage" />
                        </x-table.th>
                        <x-table.th sortable multi-column wire:click="sortBy('date')" :direction="$sorts['date'] ?? null">
                            {{ __('Date') }}
                        </x-table.th>
                        <x-table.th sortable multi-column wire:click="sortBy('customer_id')" :direction="$sorts['customer_id'] ?? null">
                            {{ __('Customer') }}
                        </x-table.th>
                        <x-table.th sortable multi-column wire:click="sortBy('payment_status')" :direction="$sorts['payment_status'] ?? null">
                            {{ __('Payment status') }}
                        </x-table.th>
                        <x-table.th sortable multi-column wire:click="sortBy('due_amount')" :direction="$sorts['due_amount'] ?? null">
                            {{ __('Due Amount') }}
                        </x-table.th>
                        <x-table.th sortable multi-column wire:click="sortBy('total')" :direction="$sorts['total'] ?? null">
                            {{ __('Total') }}
                        </x-table.th>
                        <x-table.th sortable multi-column wire:click="sortBy('status')" :direction="$sorts['status'] ?? null">
                            {{ __('Status') }}
                        </x-table.th>
                        <x-table.th>
                            {{ __('Actions') }}
                        </x-table.th>
                    </x-slot>

                    <x-table.tbody>
                        @forelse ($sales as $sale)
                            <x-table.tr wire:loading.class.delay="opacity-50">
                                <x-table.td class="pr-0">
                                    <input type="checkbox" value="{{ $sale->id }}" wire:model="selected" />
                                </x-table.td>
                                <x-table.td>
                                    {{ $sale->date }}
                                </x-table.td>
                                <x-table.td>
                                    {{ $sale->customer->name }}
                                </x-table.td>
                                <x-table.td>
                                    @if ($sale->payment_status == \App\Enums\PaymentStatus::Paid)
                                        <x-badge success>{{ __('Paid') }}</x-badge>
                                    @elseif ($sale->payment_status == \App\Enums\PaymentStatus::Partial)
                                        <x-badge warning>{{ __('Partially Paid') }}</x-badge>
                                    @elseif($sale->payment_status == \App\Enums\PaymentStatus::Due)
                                        <x-badge danger>{{ __('Due') }}</x-badge>
                                    @endif
                                </x-table.td>
                                <x-table.td>
                                    {{ format_currency($sale->due_amount) }}
                                </x-table.td>

                                <x-table.td>
                                    {{ format_currency($sale->total_amount) }}
                                </x-table.td>

                                <x-table.td>
                                    @if ($sale->status == \App\Enums\SaleStatus::Pending)
                                        <x-badge warning>{{ __('Pending') }}</x-badge>
                                    @elseif ($sale->status == \App\Enums\SaleStatus::Ordered)
                                        <x-badge info>{{ __('Ordered') }}</x-badge>
                                    @elseif($sale->status == \App\Enums\SaleStatus::Completed)
                                        <x-badge success>{{ __('Completed') }}</x-badge>
                                    @endif
                                </x-table.td>
                                <x-table.td>
                                    <div class="flex justify-start space-x-2">
                                        <x-dropdown align="right" width="56">
                                            <x-slot name="trigger" class="inline-flex">
                                                <x-button primary type="button" class="text-white flex items-center">
                                                    <i class="fas fa-angle-double-down"></i>
                                                </x-button>
                                            </x-slot>

                                            <x-slot name="content">
                                                <x-dropdown-link wire:click="showModal({{ $sale->id }})"
                                                    wire:loading.attr="disabled">
                                                    <i class="fas fa-eye"></i>
                                                    {{ __('View') }}
                                                </x-dropdown-link>

                                                <x-dropdown-link target="_blank"
                                                    href="{{ route('sales.pos.pdf', $sale->id) }}"
                                                    wire:loading.attr="disabled">
                                                    <i class="fas fa-print"></i>
                                                    {{ __('Print') }}
                                                </x-dropdown-link>
                                            </x-slot>
                                        </x-dropdown>
                                    </div>
                                </x-table.td>
                            </x-table.tr>
                        @empty
                            <x-table.tr>
                                <x-table.td>
                                    <div class="flex justify-center items-center">
                                        <span
                                            class="text-gray-400 dark:text-gray-300">{{ __('No results found') }}</span>
                                    </div>
                                </x-table.td>
                            </x-table.tr>
                        @endforelse
                    </x-table.tbody>
                </x-table>
            </div>

            <div class="px-6 py-3">
                {{ $sales->links() }}
            </div>

            {{-- Show Sale --}}
            @if ($sale)
                <div>
                    <x-modal wire:model="showModal">
                        <x-slot name="title">
                            {{ __('Show Sale') }} - {{ __('Reference') }}: <strong>{{ $sale->reference }}</strong>
                        </x-slot>

                        <x-slot name="content">
                            <div class="px-4 mx-auto">
                                <div class="flex flex-row">
                                    <div class="w-full">
                                        <div class="p-2 d-flex flex-wrap items-center">
                                            <x-button secondary class="d-print-none" target="_blank"
                                                wire:loading.attr="disabled" href="{{ route('sales.pdf', $sale->id) }}"
                                                class="ml-auto">
                                                <i class="fas fa-print"></i> {{ __('Print') }}
                                            </x-button>
                                            <x-button secondary class="d-print-none" target="_blank"
                                                wire:loading.attr="disabled" href="{{ route('sales.pdf', $sale->id) }}"
                                                class="ml-2">
                                                <i class="fas fa-download"></i> {{ __('Download') }}
                                            </x-button>
                                        </div>
                                        <div class="p-4">
                                            <div class="flex flex-row mb-4">
                                                <div class="md:w-1/3 mb-3 md:mb-0">
                                                    <h5 class="mb-2 border-bottom pb-2">{{ __('Company Info') }}:</h5>
                                                    <div><strong>{{ settings()->company_name }}</strong></div>
                                                    <div>{{ settings()->company_address }}</div>
                                                    <div>{{ __('Email') }}: {{ settings()->company_email }}</div>
                                                    <div>{{ __('Phone') }}: {{ settings()->company_phone }}</div>
                                                </div>

                                                <div class="md:w-1/3 mb-3 md:mb-0">
                                                    <h5 class="mb-2 border-bottom pb-2">{{ __('Customer Info') }}:</h5>
                                                    <div><strong>{{ $sale->customer->name }}</strong></div>
                                                    <div>{{ $sale->customer->address }}</div>
                                                    <div>{{ __('Email') }}: {{ $sale->customer->email }}</div>
                                                    <div>{{ __('Phone') }}: {{ $sale->customer->phone }}</div>
                                                </div>

                                                <div class="md:w-1/3 mb-3 md:mb-0">
                                                    <h5 class="mb-2 border-bottom pb-2">{{ __('Invoice Info') }}:</h5>
                                                    <div>{{ __('Invoice') }}:
                                                        <strong>{{ settings()->sale_prefix }} - {{ $sale->reference }}</strong>
                                                    </div>
                                                    <div>{{ __('Date') }}:
                                                        {{ \Carbon\Carbon::parse($sale->date)->format('d/m/Y') }}
                                                    </div>
                                                    <div>
                                                        {{ __('Status') }} :
                                                        @if ($sale->status == \App\Enums\SaleStatus::Pending)
                                                            <x-badge warning>{{ __('Pending') }}</x-badge>
                                                        @elseif ($sale->status == \App\Enums\SaleStatus::Ordered)
                                                            <x-badge info>{{ __('Ordered') }}</x-badge>
                                                        @elseif($sale->status == \App\Enums\SaleStatus::Completed)
                                                            <x-badge success>{{ __('Completed') }}</x-badge>
                                                        @endif
                                                    </div>
                                                    <div>
                                                        {{ __('Payment Status') }} :
                                                        @if ($sale->payment_status == \App\Enums\PaymentStatus::Paid)
                                                            <x-badge success>{{ __('Paid') }}</x-badge>
                                                        @elseif ($sale->payment_status == \App\Enums\PaymentStatus::Partial)
                                                            <x-badge warning>{{ __('Partially Paid') }}</x-badge>
                                                        @elseif($sale->payment_status == \App\Enums\PaymentStatus::Due)
                                                            <x-badge danger>{{ __('Due') }}</x-badge>
                                                        @endif
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="">
                                                <x-table>
                                                    <x-slot name="thead">
                                                        <x-table.th>{{ __('Product') }}</x-table.th>
                                                        <x-table.th>{{ __('Quantity') }}</x-table.th>
                                                        <x-table.th>{{ __('Unit Price') }}</x-table.th>
                                                        <x-table.th>{{ __('Subtotal') }}</x-table.th>
                                                    </x-slot>

                                                    <x-table.tbody>
                                                        @foreach ($sale->saleDetails as $item)
                                                            <x-table.tr>
                                                                <x-table.td>
                                                                    {{ $item->name }} <br>
                                                                    <x-badge success>
                                                                        {{ $item->code }}
                                                                    </x-badge>
                                                                </x-table.td>
                                                                <x-table.td>
                                                                    {{ format_currency($item->unit_price) }}
                                                                </x-table.td>

                                                                <x-table.td>
                                                                    {{ $item->quantity }}
                                                                </x-table.td>

                                                                <x-table.td>
                                                                    {{ format_currency($item->sub_total) }}
                                                                </x-table.td>
                                                            </x-table.tr>
                                                        @endforeach
                                                    </x-table.tbody>
                                                </x-table>
                                            </div>
                                            <div class="flex flex-row">
                                                <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0 col-sm-5 ml-md-auto">
                                                    <table class="table">
                                                        <tbody>
                                                            <tr>
                                                                <td class="left"><strong>{{ __('Discount') }}
                                                                        ({{ $sale->discount_percentage }}%)</strong>
                                                                </td>
                                                                <td class="right">
                                                                    {{ format_currency($sale->discount_amount) }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="left"><strong>{{ __('Tax') }}
                                                                        ({{ $sale->tax_percentage }}%)</strong></td>
                                                                <td class="right">
                                                                    {{ format_currency($sale->tax_amount) }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="left">
                                                                    <strong>{{ __('Shipping') }}</strong>
                                                                </td>
                                                                <td class="right">
                                                                    {{ format_currency($sale->shipping_amount) }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="left">
                                                                    <strong>{{ __('Grand Total') }}</strong>
                                                                </td>
                                                                <td class="right">
                                                                    <strong>{{ format_currency($sale->total_amount) }}</strong>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </x-slot>
                    </x-modal>
                </div>
            @endif
            {{-- End Show Sale --}}
        </x-slot>
    </x-modal>
</div>
