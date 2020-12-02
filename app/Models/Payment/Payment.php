<?php

namespace App\Models\Payment;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $sum
 * @property bool $is_success
 * @property User $user
 */
class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'is_success',
    ];

    protected $casts = [
        'sum'        => 'float',
        'is_success' => 'bool',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function paymentService()
    {
        return $this->belongsTo(PaymentService::class);
    }
}
