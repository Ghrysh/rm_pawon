<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = ['id'];

    public const EXPIRATION_MINUTES = 15;

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public static function cleanExpired()
    {
        $expiredTime = now()->subMinutes(self::EXPIRATION_MINUTES);
        self::where('status', 'menunggu_pembayaran')
            ->where('created_at', '<', $expiredTime)
            ->update(['status' => 'kadaluwarsa']);
    }
}
