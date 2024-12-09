<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientType extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function leadBodies()
    {
        return $this->hasMany(LeadBody::class, 'client_type_id');
    }
}
