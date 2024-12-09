<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function report() {
        return $this->belongsTo(FinalReport::class, 'final_report_id');
    }

    public function messages() {
        return $this->hasMany(Message::class, 'conversation_id');
    }

    public function stakeholder() {
        return $this->belongsTo(User::class, 'stakeholder_id');
    }

    public function client() {
        return $this->belongsTo(User::class, 'client_id');
    }
}
