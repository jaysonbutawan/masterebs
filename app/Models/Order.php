<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
<<<<<<< HEAD
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'total_amount',
        'status',
    ];

    public function user(): BelongsTo
=======
use App\Models\OrderItems;

class Order extends Model
{
   protected $fillable = [
        'user_id',
        'total_amount',
        'status'
    ];

    public function user()
>>>>>>> 4dec91ea328f5278c10eae27510fb09f6c5c986d
    {
        return $this->belongsTo(User::class);
    }

<<<<<<< HEAD
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItems::class);
    }
=======
    public function items()
    {
        return $this->hasMany(OrderItems::class);
    }

>>>>>>> 4dec91ea328f5278c10eae27510fb09f6c5c986d
}
