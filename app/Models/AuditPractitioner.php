<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditPractitioner extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'email', 'audit_department', 'role', 'employment_number'];

}
