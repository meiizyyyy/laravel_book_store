<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'book_code',
        'quantity',
        'price',
    ];
    // Quan hệ với mô hình Order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Quan hệ với mô hình Book (nếu bạn có)
    public function book()
    {
        return $this->belongsTo(Book::class, 'book_code', 'book_code');
    }
}
