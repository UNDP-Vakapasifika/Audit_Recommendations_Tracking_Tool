<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'user_id', 'final_report_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function finalReport()
    {
        return $this->belongsTo(FinalReport::class);
    }

    public function replies()
    {
        return $this->hasMany(NoteReply::class);
    }
}
