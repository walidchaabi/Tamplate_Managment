<?php

declare(strict_types=1);

namespace App\Http\Livewire\Sales;

use App\Http\Livewire\WithSorting;
use App\Models\Sale;
use App\Traits\Datatable;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Recent extends Component
{
    use WithPagination;
    use WithSorting;
    use WithFileUploads;
    use LivewireAlert;
    use Datatable;

    public $sale;

    /** @var string[] */
    public $listeners = [
        'recentSales', 'showModal',
        'importModal', 'refreshIndex' => '$refresh',
    ];

    public $showModal = false;

    public $recentSales;

    public array $listsForFields = [];

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

    public function mount(): void
    {
        $this->sortBy = 'id';
        $this->sortDirection = 'desc';
        $this->perPage = 10;
        $this->paginationOptions = config('project.pagination.options');
        $this->orderable = (new Sale())->orderable;
    }

    public function render()
    {
        abort_if(Gate::denies('access_sales'), 403);

        $query = Sale::with('customer', 'saleDetails')->advancedFilter([
            's'               => $this->search ?: null,
            'order_column'    => $this->sortBy,
            'order_direction' => $this->sortDirection,
        ]);

        $sales = $query->paginate($this->perPage);

        return view('livewire.sales.recent', compact('sales'));
    }

    public function showModal(Sale $sale)
    {
        abort_if(Gate::denies('access_sales'), 403);

        $this->sale = Sale::find($sale->id);

        $this->showModal = true;
    }

    public function recentSales()
    {
        abort_if(Gate::denies('access_sales'), 403);

        $this->recentSales = true;
    }
}
