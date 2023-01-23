<?php

declare(strict_types=1);

namespace App\Http\Livewire\Purchase\Payment;

use App\Http\Livewire\WithSorting;
use App\Models\Purchase;
use App\Models\PurchasePayment;
use App\Traits\Datatable;
use Illuminate\Support\Facades\Gate;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    use WithSorting;
    use LivewireAlert;
    use Datatable;

    public $purchase;

    /** @var string[] */
    public $listeners = [
        'showPayments',
        'refreshIndex' => '$refresh',
    ];

    public $refreshIndex;

    public $showPayments;

    public array $listsForFields = [];

    public $purchase_id;

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

    public function mount($purchase): void
    {
        $this->purchase = $purchase;

        if ($purchase) {
            $this->purchase_id = $purchase->id;
        }

        $this->perPage = 10;
        $this->sortBy = 'id';
        $this->sortDirection = 'desc';
        $this->paginationOptions = config('project.pagination.options');
        $this->orderable = (new PurchasePayment())->orderable;
    }

    public function render(): View|Factory
    {
        //    abort_if(Gate::denies('access_purchase_payments'), 403);

        $query = PurchasePayment::where('purchase_id', $this->purchase_id)->advancedFilter([
            's'               => $this->search ?: null,
            'order_column'    => $this->sortBy,
            'order_direction' => $this->sortDirection,
        ]);

        $purchasepayments = $query->paginate($this->perPage);

        return view('livewire.purchase.payment.index', compact('purchasepayments'));
    }

    public function showPayments($purchase_id): void
    {
        abort_if(Gate::denies('access_purchases'), 403);

        $this->purchase_id = $purchase_id;

        $this->showPayments = true;
    }
}
