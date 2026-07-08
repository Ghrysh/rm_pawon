<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = ['id'];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public static function cleanExpired()
    {
        // Delete "menunggu_pembayaran" orders that are older than 40 minutes
        $expiredTime = now()->subMinutes(40);
        self::where('status', 'menunggu_pembayaran')
            ->where('created_at', '<', $expiredTime)
            ->delete();
    }
}
