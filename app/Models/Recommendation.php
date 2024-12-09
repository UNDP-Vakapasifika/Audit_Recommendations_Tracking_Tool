<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// class Recommendation extends Model
// {
//     use HasFactory;
// }

class Recommendation extends Model
{
    protected $table = 'recommendations';

    protected $fillable = [
        'report_numbers',
        'report_title',
        'audit_type',
        'publication_date',
        'page_par_reference',
        'sector',
        'actual_expected_imp_date',
        'sai_confirmation',
        'responsible_entity',
        'recommendation',
        'client',
        'key_issues',
        'acceptance_status',
        'implementation_status',
        'recurence',
        'follow_up_date',
        'client_type',
        'summary_of_response',
        'classfication',
    ];

    public function auditedClient(){
        return $this->belongsTo(LeadBody::class,'client');
    }

    public function actionPlan()
    {
        return $this->hasOne(ActionPlan::class);
    }
}
