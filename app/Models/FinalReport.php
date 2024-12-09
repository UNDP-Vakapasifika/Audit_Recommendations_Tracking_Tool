<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinalReport extends Model
{
    protected $table = 'final_reports';

    protected $fillable = [
        'audit_report_title',
        'audit_type',
        'country_office',
        'date_of_audit',
        'publication_date',
        'page_par_reference',
        'audit_recommendations',
        'classification',
        'key_issues',
        'acceptance_status',
        'current_implementation_status',
        'reason_not_implemented',
        'follow_up_date',
        'target_completion_date',
        'recurrence',
        'action_plan',
        'summary_of_response',
        'responsible_person_email',
        'client_id',
        'client_type_id',
        'sai_responsible_person_id',
        'head_of_audited_entity_id',
        'audited_entity_focal_point_id',
        'audit_team_lead_id',
        'mainstream_categories_id',
    ];

    protected $casts = [
        'date_of_audit' => 'date',
        'publication_date' => 'date',
        'target_completion_date' => 'date',
        'follow_up_date' => 'date',
    ];

    public function cautions()
    {
        return $this->hasMany(Caution::class, 'final_report_id')->orderBy('created_at', 'desc');
    }

    // Relationships for foreign key associations
    public function client()
    {
        return $this->belongsTo(LeadBody::class, 'client_id');
    }

    public function clientType()
    {
        return $this->belongsTo(ClientType::class, 'client_type_id');
    }

    public function saiResponsiblePerson()
    {
        return $this->belongsTo(User::class, 'sai_responsible_person_id');
    }

    public function headOfAuditedEntity()
    {
        return $this->belongsTo(User::class, 'head_of_audited_entity_id');
    }

    public function auditedEntityFocalPoint()
    {
        return $this->belongsTo(User::class, 'audited_entity_focal_point_id');
    }

    public function auditTeamLead()
    {
        return $this->belongsTo(User::class, 'audit_team_lead_id');
    }

    public function leadBody()
    {
        return $this->belongsTo(LeadBody::class, 'client_id');
    }
    
    public function responsiblePerson()
    {
        return $this->belongsTo(User::class, 'sai_responsible_person_id');
    }

    public function mainstreamCategory()
    {
        return $this->belongsTo(MainstreamCategory::class, 'mainstream_categories_id');
    }

    public function conversation() {
        return $this->hasOne(Conversation::class);
    }

    public function messages() {
        return $this->hasManyThrough(Message::class, Conversation::class);
    }

    public function countryOffice()
    {
        return $this->belongsTo(LeadBody::class, 'country_office', 'id');
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public function notescount()
    {
        return $this->hasMany(Note::class, 'final_report_id');
    }

    public function implementationStatusChanges()
    {
        return $this->hasMany(ImplementationStatusChange::class);
    }
    

}