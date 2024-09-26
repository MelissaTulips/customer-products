<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers';
    protected $primaryKey = 'customer_id';
    public $timestamps = false;

    protected $fillable = [
        'first_name',
        'last_name',
        'address',
        'city',
        'state',
        'points',
    ];

    // Define the relationship: Customer has many Orders
    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id', 'customer_id');
    }

    public function isGoldenMember()
    {
        return $this->points > 2000;
    }




    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
