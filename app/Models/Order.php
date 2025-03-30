<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $id
 * @property string $user_id
 * @property float $total_price
 * @property float $discount
 * @property float $total_discount
 * @property float $tax
 * @property float $total_tax
 * @property float $shipping_cost
 * @property float $grand_total
 * @property string $currency
 * @property string $payment_method
 * @property string $status
 * @property string $success_url
 * @property string $cancel_url
 * @property string $failure_url
 * @property array $extras
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property User $user
 * @property OrderItem[] $orderItems
 */
class Order extends Model
{
    use HasUuids;

    protected $fillable = [
        'user_id',
        'total_price',
        'discount',
        'total_discount',
        'tax',
        'total_tax',
        'shipping_cost',
        'grand_total',
        'currency',
        'payment_method',
        'status',
        'success_url',
        'cancel_url',
        'failure_url',
        'extras',
    ];

    protected $casts = [
        'extras' => 'array',
        'created_at' => 'datetime:Y-m-d H:i:s',
    ];

    protected $hidden = ['updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
