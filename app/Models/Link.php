<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Link extends Model
{
    use HasFactory;
    public function userName(){

    }
    public  function user():BelongsTo{
        return $this->belongsTo(User::class,'user_id');
}

    protected $fillable=[
        'users_id',
        'name',
        'visits',
        'original',
        'shortened'
    ];
}
