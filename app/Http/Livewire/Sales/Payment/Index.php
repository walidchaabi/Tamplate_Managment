<?php

declare(strict_types=1);

namespace App\Http\Livewire\Sales\Payment;

use App\Http\Livewire\WithSorting;
use App\Models\Sale;
use App\Models\SalePayment;
use App\Traits\Datatable;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    use WithSorting;
    use LivewireAlert;
    use Datatable;

    public $sale;

    /** @var string[] */
    public $listeners = [
        'showPayments',
        'refreshIndex' => '$refresh',
    ];

    public $showPayments;

    public array $listsForFields = [];

    public $sale_id;

    /** @var string[][] */
    protected $queryString = [
        'search' => [
            'except' => '',
        ],
        'sortBy' => [
            'except' => 'id',
        ],
        'sortDirection' => [
            'except' => 'desc',
        ],
    ];

    public function mount($sale)
    {
        $this->sale = $sale;

        if ($sale) {
            $this->sale_id = $sale->id;
        }

        $this->perPage = 10;
        $this->sortBy = 'id';
        $this->sortDirection = 'desc';
        $this->paginationOptions = config('project.pagination.options');
        $this->orderable = (new SalePayment())->orderable;
    }

    public function render()
    {
        //    abort_if(Gate::denies('access_sale_payments'), 403);

        $query = SalePayment::where('sale_id', $this->sale_id)->advancedFilter([
            's'               => $this->search ?: null,
            'order_column'    => $this->sortBy,
            'order_direction' => $this->sortDirection,
        ]);

        $salepayments = $query->paginate($this->perPage);

        return view('livewire.sales.payment.index', compact('salepayments'));
    }

    public function showPayments($sale_id)
    {
        abort_if(Gate::denies('access_sales'), 403);

        $this->sale_id = $sale_id;

        $this->showPayments = true;
    }
}
