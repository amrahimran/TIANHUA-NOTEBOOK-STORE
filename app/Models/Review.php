<?php
/** @noinspection PhpUndefinedClassInspection */

namespace App\Models;

// use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use MongoDB\Laravel\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Eloquent
{
    use HasFactory;

    protected $connection = 'mongodb'; // Use MongoDB
    protected $collection = 'reviews'; // Collection name

    protected $fillable = [
        'user_id',
        'product_id',
        'comment',
        'rating',
    ];

    // A review belongs to a user (MySQL users table)
 

    // public function user()
    // {
    //     return $this->belongsTo(\App\Models\User::class, 'user_id', '_id');
    // }


    // A review belongs to a product (MySQL products table)
    public function product()
    {
        return $this->belongsTo(\App\Models\Products::class, 'product_id', 'id');
    }
}
