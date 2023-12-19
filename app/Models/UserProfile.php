<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;
    protected $table = 'profiles';
    protected $fillable = [
        'user_id',
        'about',
        'picture',
        'facebook',
        'twitter'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
