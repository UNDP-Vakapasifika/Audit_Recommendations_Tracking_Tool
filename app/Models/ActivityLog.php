<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// class User extends Authenticatable
// {
//     use HasFactory, Notifiable;

//     // ... other user model code ...

//     public function logActivity($type, $description)
//     {
//         ActivityLog::create([
//             'user_id' => $this->id,
//             'activity' => [
//                 'type' => $type,
//                 'description' => $description,
//             ],
//         ]);
//     }
// }

/**
 * @method static create(array $array)
 */
class ActivityLog extends Model
{

    use HasFactory;

    protected $fillable = [
        'user_id',
        'action',
        'name',
        'activity',
        'ip_address',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
