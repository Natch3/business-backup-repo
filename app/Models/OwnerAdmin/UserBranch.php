<?php

namespace App\Models\OwnerAdmin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\OwnerAdmin\RegisterBranch;
class UserBranch extends Model
{
    use HasFactory;

    protected $table = 'user_branch';

    protected $fillable = [
        'id_users',
        'id_branch',
        
    ];

    /**
     * Relationship: Branch belongs to a User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_users');
    }
    
        public function branch()
    {
        return $this->belongsTo(RegisterBranch::class, 'id_branch');
    }

}