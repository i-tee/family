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
        'cp_id',
        'selected', // Добавляем новое поле
        'archived', // Добавляем новое поле
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function persons()
    {
        return $this->hasMany(Person::class);
    }

    // Связь с центральной персоной
    public function centerPerson()
    {
        return $this->belongsTo(Person::class, 'cp_id');
    }

    public function setCenterPerson($personId)
    {
        // Проверяем, существует ли персона с таким ID
        if (!Person::where('id', $personId)->exists()) {
            throw new \Exception("Персона с ID {$personId} не найдена.");
        }
    
        // Обновляем cp_id
        $this->cp_id = $personId;
        $this->save();
    
        return $this;
    }

}