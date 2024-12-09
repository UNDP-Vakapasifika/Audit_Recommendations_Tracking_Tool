<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stakeholder extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'location',
        'postal_address',
        'telephone',
        'email',
        'website',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
