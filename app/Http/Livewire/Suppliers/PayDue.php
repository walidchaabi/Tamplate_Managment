<?php

declare(strict_types=1);

namespace App\Http\Livewire\Suppliers;

use App\Models\PurchasePayment;
use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Enums\PaymentStatus;

class PayDue extends Component
{
    // get customer id
    // pay due amount

    public $amount;
    public $supplier_id;

    public function pay()
    {
        if ($this->amount > 0) {
            $supplier_purchases_due = Purchase::where([
                ['payment_statut', '!=', 'paid'],
                ['supplier_id', $this->supplier_id],
            ])->get();

            $paid_amount_total = $this->amount;

            foreach ($supplier_purchases_due as $key => $supplier_purchase) {
                if ($paid_amount_total == 0) {
                    break;
                }
                $due = $supplier_purchase->GrandTotal - $supplier_purchase->paid_amount;

                if ($paid_amount_total >= $due) {
                    $amount = $due;
                    $payment_status = PaymentStatus::Paid;
                } else {
                    $amount = $paid_amount_total;
                    $payment_status = PaymentStatus::Partial;
                }

                $payment_purchase = new PurchasePayment();
                $payment_purchase->purchase_id = $supplier_purchase->id;
                $payment_purchase->Ref = app('App\Http\Controllers\PaymentPurchasesController')->getNumberOrder();
                $payment_purchase->date = Carbon::now();
                $payment_purchase->montant = $amount;
                $payment_purchase->change = 0;
                $payment_purchase->notes = $this['notes'];
                $payment_purchase->user_id = Auth::user()->id;
                $payment_purchase->save();

                $supplier_purchase->paid_amount += $amount;
                $supplier_purchase->payment_statut = $payment_status;
                $supplier_purchase->save();

                $paid_amount_total -= $amount;
            }
        }
    }

    public function render()
    {
        return view('livewire.suppliers.pay-due');
    }
}
