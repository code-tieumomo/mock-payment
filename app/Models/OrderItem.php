<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $order_id
 * @property string $name
 * @property float $price
 * @property float $discount
 * @property float $tax
 * @property float $grand_total
 * @property int $quantity
 * @property string $thumbnail
 * @property array $extras
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Order $order
 */
class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'name',
        'price',
        'discount',
        'tax',
        'grand_total',
        'quantity',
        'thumbnail',
        'extras',
    ];

    protected $casts = [
        'extras' => 'array',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
