<?php

namespace App\Models\OwnerAdmin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class RegisterBranch extends Model
{
    use HasFactory;

    protected $table = 'branches';

    protected $fillable = [
        'branch_name',
        'business_type',
        'address',
        'city',
        'province',
        'contact_number',
        'email',
        'id_users',
        'branch_logo',
        'status',
        'IDp'
    ];

    /**
     * Relationship: Branch belongs to a User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_users');
    }
    public function userBranches()
{
    return $this->hasMany(UserBranch::class, 'id_branch');
}
 protected static function booted()
    {
        static::creating(function ($registerbranch) {
            $registerbranch->b = bin2hex(random_bytes(16)); 
            $registerbranch->IDp = bin2hex(random_bytes(16)); 
        });
    }
}
