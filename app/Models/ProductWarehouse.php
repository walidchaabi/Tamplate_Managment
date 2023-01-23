<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\ProductWarehouse
 *
 * @property int $id
 * @property int $product_id
 * @property int $warehouse_id
 * @property float $qty
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\Warehouse $warehouse
 * @method static \Illuminate\Database\Eloquent\Builder|ProductWarehouse newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductWarehouse newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductWarehouse query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductWarehouse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductWarehouse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductWarehouse whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductWarehouse whereQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductWarehouse whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductWarehouse whereWarehouseId($value)
 * @mixin \Eloquent
 */
class ProductWarehouse extends Model
{
    protected $table = 'product_warehouse';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_id', 'warehouse_id', 'qte',
    ];

    protected $casts = [
        'product_id'   => 'integer',
        'warehouse_id' => 'integer',
        'qte'          => 'double',
    ];

    /** @return BelongsTo<Warehouse> */
    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    /** @return BelongsTo<Product> */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
