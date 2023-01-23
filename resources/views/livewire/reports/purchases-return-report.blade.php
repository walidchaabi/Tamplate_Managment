<div>
    <div class="flex flex-row">
        <div class="w-full">
            <div class="card border-0 shadow-sm">
                <div class="p-4">
                    <form wire:submit.prevent="generateReport">
                        <div class="flex flex-wrap -mx-2 mb-3">
                            <div class="w-full md:w-1/3 px-3 mb-4 md:mb-0">
                                <div class="mb-4">
                                    <label>{{ __('Start Date') }} <span class="text-red-500">*</span></label>
                                    <input wire:model.defer="start_date" type="date"
                                        class="block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md mt-1"
                                        name="start_date">
                                    @error('start_date')
                                        <span class="text-danger mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="w-full md:w-1/3 px-3 mb-4 md:mb-0">
                                <div class="mb-4">
                                    <label>{{ __('End Date') }} <span class="text-red-500">*</span></label>
                                    <input wire:model.defer="end_date" type="date"
                                        class="block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md mt-1"
                                        name="end_date">
                                    @error('end_date')
                                        <span class="text-danger mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="w-full md:w-1/3 px-3 mb-4 md:mb-0">
                                <div class="mb-4">
                                    <label>{{ __('Supplier') }}</label>
                                    <select wire:model.defer="supplier_id"
                                        class="block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md mt-1"
                                        name="supplier_id">
                                        <option value="">{{__('Select Supplier')}}</option>
                                        @foreach ($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-wrap -mx-2 mb-3">
                            <div class="xl:w-1/3 lg:w-1/2 sm:w-full px-3">
                                <div class="mb-4">
                                    <label>{{ __('Status') }}</label>
                                    <select wire:model.defer="purchase_return_status"
                                        class="block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md mt-1"
                                        name="purchase_return_status">
                                        <option value="">{{__('Select Status')}}</option>
                                        <option value="Pending">{{ __('Pending') }}</option>
                                        <option value="Shipped">{{__('Shipped')}}</option>
                                        <option value="Completed">{{ __('Completed') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="xl:w-1/3 lg:w-1/2 sm:w-full px-3">
                                <div class="mb-4">
                                    <label>{{ __('Payment Status') }}</label>
                                    <select wire:model.defer="payment_status"
                                        class="block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md mt-1"
                                        name="payment_status">
                                        <option value="">{{__('Select Payment Status')}}</option>
                                        <option value="Paid">{{ __('Paid') }}</option>
                                        <option value="Unpaid">{{__('Unpaid')}}</option>
                                        <option value="Partial">{{__('Partial')}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4 md:mb-0">
                            <button type="submit"
                                class="block uppercase mx-auto shadow bg-indigo-800 hover:bg-indigo-700 focus:shadow-outline focus:outline-none text-white text-xs py-3 px-10 rounded">
                                <span wire:target="generateReport" wire:loading class="spinner-border spinner-border-sm"
                                    role="status" aria-hidden="true"></span>
                                <i wire:target="generateReport" wire:loading.remove class="bi bi-shuffle"></i>
                                {{ __('Filter Report') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-row">
        <div class="w-full">
            <div class="card border-0 shadow-sm">
                <div class="p-4">
                    <x-table>
                        <x-slot name="thead">
                            <x-table.th>{{ __('Date') }}</x-table.th>
                            <x-table.th>{{ __('Reference') }}</x-table.th>
                            <x-table.th>{{ __('Supplier') }}</x-table.th>
                            <x-table.th>{{ __('Status') }}</x-table.th>
                            <x-table.th>{{ __('Total') }}</x-table.th>
                            <x-table.th>{{ __('Paid') }}</x-table.th>
                            <x-table.th>{{ __('Due') }}</x-table.th>
                            <x-table.th>{{ __('Payment Status') }}</x-table.th>
                        </x-slot>
                        <x-table.tbody>
                            @forelse($purchase_returns as $purchase_return)
                                <x-table.tr>
                                    <x-table.td>{{ \Carbon\Carbon::parse($purchase_return->date)->format('d M, Y') }}
                                    </x-table.td>
                                    <x-table.td>{{ $purchase_return->reference }}</x-table.td>
                                    <x-table.td>{{ $purchase_return->supplier->name }}</x-table.td>
                                    <x-table.td>
                                        @if ($purchase_return->status == 'Pending')
                                            <span class="badge badge-info">
                                                {{ $purchase_return->status }}
                                            </span>
                                        @elseif ($purchase_return->status == 'Shipped')
                                            <span class="badge badge-primary">
                                                {{ $purchase_return->status }}
                                            </span>
                                        @else
                                            <span class="badge badge-success">
                                                {{ $purchase_return->status }}
                                            </span>
                                        @endif
                                    </x-table.td>
                                    <x-table.td>{{ format_currency($purchase_return->total_amount) }}</x-table.td>
                                    <x-table.td>{{ format_currency($purchase_return->paid_amount) }}</x-table.td>
                                    <x-table.td>{{ format_currency($purchase_return->due_amount) }}</x-table.td>
                                    <x-table.td>
                                        @if ($purchase_return->payment_status == 'Partial')
                                            <x-badge warning>
                                                {{ $purchase_return->payment_status }}
                                            </x-badge>
                                        @elseif ($purchase_return->payment_status == 'Paid')
                                            <x-badge success>
                                                {{ $purchase_return->payment_status }}
                                            </x-badge>
                                        @else
                                            <x-badge danger>
                                                {{ $purchase_return->payment_status }}
                                            </x-badge>
                                        @endif

                                    </x-table.td>
                                </x-table.tr>
                            @empty
                                <x-table.tr>
                                    <x-table.td colspan="8">
                                        <span class="text-red-500">{{__('No Purchase Return Data Available!')}}</span>
                                    </x-table.td>
                                </x-table.tr>
                            @endforelse
                        </x-table.tbody>
                    </x-table>
                    <div @class(['mt-3' => $purchase_returns->hasPages()])>
                        {{ $purchase_returns->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
