<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActionPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'country_office',
        'date_of_audit',
        'head_of_audited_entity',
        'audited_entity_focal_point',
        'audit_team_lead',
        'created_person',
        'action_plan',
        'current_implementation_status',
        'target_completion_date',
        'responsible_person',
        'classfication',
        'recommendation_id',
        'category_type_id',
    ];

    protected $attributes = [
        'supervised' => null,
        'reason' => null,
    ];

    // Define the relationship with Recommendation
    public function recommendation()
    {
        return $this->belongsTo(Recommendation::class);
    }
}

