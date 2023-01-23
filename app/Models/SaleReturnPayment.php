<?php

declare(strict_types=1);

namespace App\Models;

use App\Support\HasAdvancedFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;

/**
 * App\Models\SaleReturnPayment
 *
 * @property int $id
 * @property int $sale_return_id
 * @property int $amount
 * @property string $date
 * @property string $reference
 * @property string $payment_method
 * @property string|null $note
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \App\Models\SaleReturn $saleReturn
 * @method static \Illuminate\Database\Eloquent\Builder|SaleReturnPayment advancedFilter($data)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleReturnPayment bySaleReturn()
 * @method static \Illuminate\Database\Eloquent\Builder|SaleReturnPayment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SaleReturnPayment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SaleReturnPayment query()
 * @method static \Illuminate\Database\Eloquent\Builder|SaleReturnPayment whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleReturnPayment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleReturnPayment whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleReturnPayment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleReturnPayment whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleReturnPayment wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleReturnPayment whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleReturnPayment whereSaleReturnId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleReturnPayment whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SaleReturnPayment extends Model
{
    use HasAdvancedFilter;

    /** @var string[] */
    public $orderable = [
        'id',
        'sale_return_id',
        'amount',
        'payment_method',
        'payment_note',
        'created_at',
        'updated_at',
    ];

    /** @var string[] */
    public $filterable = [
        'id',
        'sale_return_id',
        'amount',
        'payment_method',
        'payment_note',
        'created_at',
        'updated_at',
    ];

    protected $guarded = [];

    /** @return \Illuminate\Database\Eloquent\Relations\BelongsTo */
    public function saleReturn(): BelongsTo
    {
        return $this->belongsTo(SaleReturn::class, 'sale_return_id', 'id');
    }

    /**
     * Interact with the expenses amount
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function amount(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value / 100,
            set: fn ($value) => $value * 100,
        );
    }

   /**
    * Get ajustement date.
    * @return \Illuminate\Database\Eloquent\Casts\Attribute
    */
    public function date(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('d M, Y'),
        );
    }

    /**
     * @param mixed $query
     * @return mixed
     */
    public function scopeBySaleReturn($query)
    {
        return $query->whereSaleReturnId(request()->route('sale_return_id'));
    }
}
