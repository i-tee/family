<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Orchid\Screen\AsSource;

class Tree extends Model
{

    use AsSource;
    use HasFactory;

    protected $table = 'trees';

    protected $fillable = [
        'name',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function persons()
    {
        return $this->hasMany(Person::class);
    }
    
}
