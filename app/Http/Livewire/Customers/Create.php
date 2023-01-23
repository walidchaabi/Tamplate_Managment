<?php

declare(strict_types=1);

namespace App\Http\Livewire\Customers;

use App\Models\Customer;
use App\Models\Wallet;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Create extends Component
{
    use LivewireAlert;

    /** @var string[] */
    public $listeners = ['createCustomer'];

    public $createCustomer = false;

    /** @var mixed */
    public $customer;

    public $name;

    public $email;

    public $phone;

    public $city;

    public $country;

    public $address;

    public $tax_number;

    public function updated($propertyName): void
    {
        $this->validateOnly($propertyName);
    }

    protected $rules = [
        'name'       => 'required|string|max:255',
        'email'      => 'nullable|max:255',
        'phone'      => 'required|numeric',
        'city'       => 'nullable',
        'country'    => 'nullable',
        'address'    => 'nullable',
        'tax_number' => 'nullable',
    ];

    public function render(): View|Factory
    {
        abort_if(Gate::denies('customer_create'), 403);

        return view('livewire.customers.create');
    }

    public function createCustomer(): void
    {
        $this->reset();

        $this->createCustomer = true;
    }

    public function create(): void
    {
        $validatedData = $this->validate();

        Customer::create($validatedData);

        if ($this->customer) {
            $wallet = Wallet::create([
                'customer_id' => $this->customer->id,
                'balance'     => 0,
            ]);
        }
        $this->alert('success', __('Customer created successfully'));

        $this->emit('refreshIndex');

        $this->createCustomer = false;
    }
}
