<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodCart extends Model
{
    use HasFactory;
    protected $fillable = ['foodId','userIp'];
}
