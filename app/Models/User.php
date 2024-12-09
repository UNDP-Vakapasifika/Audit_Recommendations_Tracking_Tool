<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

/**
 * @method static where(string $string, mixed $email)
 * @method static create(array $defaultUser)
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    //for activity log
    protected static function boot(): void
    {
        parent::boot();
//
//        static::created(function ($user) {
//            $description = 'Created user: ' . $user->name;
//            $user->logActivity('create', $description);
//        });
//
//        static::updated(function ($user) {
//            $description = 'Updated user: ' . $user->name;
//            $user->logActivity('update', $description);
//        });
//
//        static::deleted(function ($user) {
//            $description = 'Deleted user: ' . $user->name;
//            $user->logActivity('delete', $description);
//        });
    }

    public function logActivity($type, $description): void
    {
        ActivityLog::create([
            'user_id' => $this->{'id'},
            'activity' => [
                'type' => $type,
                'description' => $description,
            ],
        ]);
    }

    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function leadBody(): BelongsTo
    {
        return $this->belongsTo(LeadBody::class, 'lead_body_id');
    }

    public function stakeholder(){
        return $this->belongsTo(Stakeholder::class, 'stakeholder_id');
    }

    public function responsiblePerson()
    {
        return $this->belongsTo(User::class, 'sai_responsible_person_id');
    }

    public function headOfAuditedEntity()
    {
        return $this->belongsTo(User::class, 'head_of_audited_entity_id');
    }

    public function isClient() {
        return $this->lead_body_id != null;
    }

    public function isStakeholder() {
        return $this->stakeholder_id != null;
    }

    public function implementationStatusChanges()
    {
        return $this->hasMany(ImplementationStatusChange::class, 'changed_by');
    }

    // public function leadBody()
    // {
    //     return $this->belongsTo(LeadBody::class, 'lead_body_id');
    // }

    // public function stakeholder()
    // {
    //     return $this->belongsTo(Stakeholder::class, 'stakeholder_id');
    // }

}
