@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"
        integrity="sha512-ElRFoEQdI5Ht6kZvyzXhYG9NqjtkmlkfYk0wr6wHxU9JEHakS7UJZNeml5ALk+8IKlU6jDgMabC3vkumRokgJA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('js/chart-config.js') }}"></script>
    <script>
        document.querySelectorAll('.js-date').forEach(el => {
            el.addEventListener('click', event => {
                clearActive();
                hideAll();
                el.classList.add('active:bg-indigo-800');
                document.querySelector(`#${el.dataset.date}`).style.display = 'flex';
            });
        });

        const clearActive = () => {
            document.querySelectorAll('.js-date').forEach(el => {
                el.classList.remove('active');
            });
        };

        const hideAll = () => {
            document.querySelectorAll('.js-date-row').forEach(el => {
                el.style.display = 'none';
            });
        };
    </script>
@endpush

@section('title', __('Dashboard'))

@section('breadcrumb')
    <section class="py-3 px-4">
        <div class="flex flex-wrap items-center">
            <div class="mb-5 lg:mb-0">
                <h2 class="mb-1 text-2xl font-bold">{{ __('Dashboard') }}</h2>
                <div class="flex items-center">
                    <a class="flex items-center text-sm text-gray-500" href="{{ route('home') }}">
                        <span class="inline-block mx-2">
                            <svg class="h-4 w-4 text-gray-500" viewBox="0 0 16 18" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M14.6666 5.66667L9.66662 1.28333C9.20827 0.873372 8.6149 0.646725 7.99996 0.646725C7.38501 0.646725 6.79164 0.873372 6.33329 1.28333L1.33329 5.66667C1.0686 5.9034 0.857374 6.1938 0.713683 6.51854C0.569993 6.84328 0.497134 7.1949 0.499957 7.55V14.8333C0.499957 15.4964 0.763349 16.1323 1.23219 16.6011C1.70103 17.0699 2.33692 17.3333 2.99996 17.3333H13C13.663 17.3333 14.2989 17.0699 14.7677 16.6011C15.2366 16.1323 15.5 15.4964 15.5 14.8333V7.54167C15.5016 7.18797 15.4282 6.83795 15.2845 6.51474C15.1409 6.19152 14.9303 5.90246 14.6666 5.66667V5.66667ZM9.66662 15.6667H6.33329V11.5C6.33329 11.279 6.42109 11.067 6.57737 10.9107C6.73365 10.7545 6.94561 10.6667 7.16662 10.6667H8.83329C9.0543 10.6667 9.26626 10.7545 9.42255 10.9107C9.57883 11.067 9.66662 11.279 9.66662 11.5V15.6667ZM13.8333 14.8333C13.8333 15.0543 13.7455 15.2663 13.5892 15.4226C13.4329 15.5789 13.221 15.6667 13 15.6667H11.3333V11.5C11.3333 10.837 11.0699 10.2011 10.6011 9.73223C10.1322 9.26339 9.49633 9 8.83329 9H7.16662C6.50358 9 5.8677 9.26339 5.39886 9.73223C4.93002 10.2011 4.66662 10.837 4.66662 11.5V15.6667H2.99996C2.77894 15.6667 2.56698 15.5789 2.4107 15.4226C2.25442 15.2663 2.16662 15.0543 2.16662 14.8333V7.54167C2.16677 7.42335 2.19212 7.30641 2.24097 7.19865C2.28982 7.09089 2.36107 6.99476 2.44996 6.91667L7.44996 2.54167C7.60203 2.40807 7.79753 2.33439 7.99996 2.33439C8.20238 2.33439 8.39788 2.40807 8.54996 2.54167L13.55 6.91667C13.6388 6.99476 13.7101 7.09089 13.7589 7.19865C13.8078 7.30641 13.8331 7.42335 13.8333 7.54167V14.8333Z"
                                    fill="currentColor"></path>
                            </svg></span>
                        <span>{{ __('Home') }}</span>
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
<x-app-layout>
    <div class="px-2 mx-auto">

        <livewire:livesearch />

        {{-- <livewire:calculator /> --}}
        <div class="bg-white ">
            <div class="sm:flex sm:flex-wrap md:inline-flex lg:text-lg sm:text-sm float-right space-y-2 py-2">
                <x-button type="button" primary data-date="today" class="js-date mr-2 py-2 active:bg-indigo-800">
                    {{ __('Today') }}
                </x-button>

                <x-button type="button" primary data-date="month" class="js-date py-2  mr-2">
                    {{ __('Last month') }}
                </x-button>

                <x-button type="button" primary data-date="semi" class="js-date py-2  mr-2">
                    {{ __('Last 6 month') }}
                </x-button>

                <x-button type="button" primary data-date="year" class="js-date py-2 ">
                    {{ __('Last year') }}
                </x-button>
            </div>
            @foreach ($data as $key => $d)
                @if ($loop->first)
                    <div class="w-full flex flex-wrap align-center mb-4 js-date-row" id="{{ $key }}">
                        <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 w-full">
                            <div
                                class="flex items-center p-4 bg-white rounded-lg shadow-md">
                                <div class="p-5 mr-4 text-blue-500 bg-blue-100 rounded-full">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="mb-2 text-lg font-medium text-gray-800 dark:text-gray-300">
                                        {{ __('Sales') }}
                                    </p>
                                    <p class="text-3xl sm:text-lg font-bold text-gray-700">
                                        {{ format_currency($d['salesTotal']) }}
                                    </p>
                                </div>
                            </div>

                            <div
                                class="flex items-center p-4 bg-white rounded-lg shadow-md">
                                <div class="p-5 mr-4 text-blue-500 bg-blue-100 rounded-full">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="mb-2 text-lg font-medium text-gray-600">
                                        {{ __('Stock Value') }}
                                    </p>
                                    <p class="text-3xl sm:text-lg font-bold text-gray-700">
                                        {{ format_currency($d['stockValue']) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="w-full flex flex-wrap align-center mb-4 js-date-row" style="display: none"
                        id="{{ $key }}">
                        <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 w-full">
                            <div
                                class="flex items-center p-4 bg-white rounded-lg shadow-md">
                                <div class="p-5 mr-4 text-blue-500 bg-blue-100 rounded-full">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="mb-2 text-lg font-medium text-gray-600">
                                        {{ __('Sales') }}
                                    </p>
                                    <p class="text-3xl sm:text-lg font-bold text-gray-700">
                                        {{ format_currency($d['salesTotal']) }}
                                    </p>
                                </div>
                            </div>

                            <div
                                class="flex items-center p-4 bg-white rounded-lg shadow-md">
                                <div class="p-5 mr-4 text-blue-500 bg-blue-100 rounded-full">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="mb-2 text-lg font-medium text-gray-600">
                                        {{ __('Stock Value') }}
                                    </p>
                                    <p class="text-3xl sm:text-lg font-bold text-gray-700">
                                        {{ format_currency($d['stockValue']) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
        @can('show_total_stats')
            <div class="grid gap-6 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-4 w-full mb-4 py-4">
                <div class="flex items-center p-4 bg-white rounded-lg shadow-md">
                    <div>
                        <div class="flex mb-2">
                            <span class="inline-block mx-2">
                                <i class="bi bi-bar-chart font-2xl"></i>
                            </span>
                            <h3 class="text-sm text-gray-600">
                                {{ __('Revenue') }}
                            </h3>
                        </div>
                        <h2 class="mb-2 text-3xl font-bold">{{ format_currency($revenue) }}</h2>
                    </div>
                </div>

                <div class="flex items-center p-4 bg-white rounded-lg shadow-md">
                    <div>
                        <div class="flex mb-2">
                            <span class="inline-block mx-2">
                                <i class="bi bi-arrow-return-left font-2xl"></i>
                            </span>
                            <h3 class="text-sm text-gray-600">
                                {{ __('Sales Return') }}
                            </h3>
                        </div>
                        <h2 class="mb-2 text-3xl font-bold">{{ format_currency($sale_returns) }}</h2>
                    </div>
                </div>

                <div class="flex items-center p-4 bg-white rounded-lg shadow-md">
                    <div>
                        <div class="flex mb-2">
                            <span class="inline-block mx-2">
                                <i class="bi bi-arrow-return-right font-2xl"></i>
                            </span>
                            <h3 class="text-sm text-gray-600">
                                {{ __('Purchases Return') }}
                            </h3>
                        </div>
                        <h2 class="mb-2 text-3xl font-bold">{{ format_currency($purchase_returns) }}</h2>
                    </div>
                </div>


                <div class="flex items-center p-4 bg-white rounded-lg shadow-md">
                    <div>
                        <div class="flex mb-2">
                            <span class="inline-block mx-2">
                                <i class="bi bi-trophy font-2xl"></i>
                            </span>
                            <h3 class="text-sm text-gray-600">
                                {{ __('Profit') }}
                            </h3>
                        </div>
                        <h2 class="mb-2 text-3xl font-bold">{{ format_currency($profit) }}</h2>
                    </div>
                </div>
            </div>
        @endcan

        @can('show_weekly_sales_purchases|show_month_overview')
            <div class="bg-white flex flex-wrap py-4">
                @can('show_weekly_sales_purchases')
                    <div class="lg:w-3/5 sm:w-full px-2 mb-4">
                        <div>
                            <div class="text-xl mb-2">
                                {{ __('Sales & Purchases of Last 7 Days') }}
                            </div>
                            <div class="p-4">
                                <canvas id="salesPurchasesChart"></canvas>
                            </div>
                        </div>
                    </div>
                @endcan
                @can('show_month_overview')
                    <div class="lg:w-2/5 sm:w-full px-2 mb-4">
                        <div>
                            <div class="text-xl mb-2">
                                {{ __('Overview of') }} {{ now()->format('F, Y') }}
                            </div>
                            <div class="card-body d-flex justify-content-center">
                                <div class="chart-container" style="position: relative; height:auto; width:280px">
                                    <canvas id="currentMonthChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan
            </div>
        @endcan

        @can('show_monthly_cashflow')
            <div class="bg-white flex flex-wrap mb-4 py-4">
                <div class="w-full px-2">
                    <div>
                        <div class="text-xl mb-2">
                            {{ __('Monthly Cash Flow (Payment Sent & Received)') }}
                        </div>
                        <div class="p-4">
                            <canvas id="paymentChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        @endcan
    </div>
</x-app-layout>
