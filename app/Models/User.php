<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'branch_id',
        'role_id',
        'designation',
        'rank',
        'status',
        'phone_number',
        'region_id',     // New field
        'department_id', // New field
        'district_id',   // New field
        'command_id',    // New field
    ];

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
    ];



// If you are using Spatie's role system, you won't need this.
// If you are using a custom roles system:
public function role()
{
    return $this->belongsTo(Role::class, 'role_id');
}
public function branch()
{
    return $this->belongsTo(Branch::class, 'branch_id');
}
public function enquiries()
{
    return $this->belongsToMany(Enquiry::class, 'enquiry_user');
}

//added new

public function region()
{
    return $this->belongsTo(Region::class, 'region_id'); // New relationship
}

public function department()
{
    return $this->belongsTo(Department::class, 'department_id'); // New relationship
}

public function district()
{
    return $this->belongsTo(District::class, 'district_id'); // New relationship
}

public function command()
{
    return $this->belongsTo(Command::class, 'command_id'); // New relationship
}

//assigned users  in enquiry.show

// In User.php Model
 
public function rank()
{
    return $this->belongsTo(Rank::class); // Assuming the 'User' has a 'rank_id' field
}


}

