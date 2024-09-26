<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders'; 
    protected $primaryKey = 'order_id'; 
    public $timestamps = false;

    protected $fillable = [
        'customer_id',
        'order_date',
        'status',
        'comments',
        'shipped_date',
        'shipper_id',
    ];

  
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }
}
