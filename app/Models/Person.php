<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Person extends Model
{
    
    use AsSource;

    protected $table = 'persons';

    protected $fillable = [
        'first_name',
        'last_name',
        'middle_name',
        'birth_date',
        'death_date',
        'tree_id',
    ];
    
    public function tree()
    {
        return $this->belongsTo(Tree::class);
    }

}
