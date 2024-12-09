<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadBody extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'client_type_id'];

    public function users()
    {
        return $this->hasMany(User::class, 'lead_body_id');
    }

    public function clientTypes(): BelongsTo
    {
        return $this->belongsTo(ClientType::class, 'client_type_id');
    }

    public function leadBody()
    {
        return $this->belongsTo(LeadBody::class, 'client_id');
    }

        public function clientType()
    {
        return $this->belongsTo(ClientType::class, 'client_type_id');
    }

}
