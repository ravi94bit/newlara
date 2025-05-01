<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $table = 'profiles';

    // Allow these fields to be mass assignable
    protected $fillable = ['name', 'email', 'phone', 'address'];
}
