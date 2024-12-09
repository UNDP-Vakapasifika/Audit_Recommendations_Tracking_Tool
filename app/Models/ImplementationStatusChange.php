<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImplementationStatusChange extends Model
{
    use HasFactory;

    protected $fillable = [
        'final_report_id',
        'from_status',
        'to_status',
        'from_date',
        'to_date',
        'evidence',
        'impact',
        'changed_by',
    ];

    public function finalReport()
    {
        return $this->belongsTo(FinalReport::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
