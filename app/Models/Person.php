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
        'mother_id',
        'father_id',
    ];

    /**
     * Возвращает полное имя персоны.
     *
     * @return string
     */
    public function fullName()
    {
        return trim(implode(' ', [
            $this->first_name,
            $this->middle_name,
            $this->last_name
        ]));
    }

    /**
     * Связь с матерью.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mother()
    {
        return $this->belongsTo(Person::class, 'mother_id');
    }

    /**
     * Связь с отцом.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function father()
    {
        return $this->belongsTo(Person::class, 'father_id');
    }

    /**
     * Связь с деревом.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tree()
    {
        return $this->belongsTo(Tree::class);
    }

    /**
     * Устанавливает текущую персону как центральную для указанного дерева.
     *
     * @param int $treeId ID дерева
     * @return bool
     */
    public function setAsCenterPerson($treeId)
    {
        // Подключаем модель Tree
        $tree = Tree::find($treeId);

        // Если дерево не найдено, возвращаем false
        if (!$tree) {
            return false;
        }

        // Проверяем, что текущая персона принадлежит указанному дереву
        if ($this->tree_id !== $treeId) {
            return false;
        }

        // Проверяем, что центральная персона ещё не установлена
        if ($tree->cp_id === null) {
            // Устанавливаем центральную персону
            $tree->cp_id = $this->id;
            $tree->save();

            return true; // Успешно установлено
        }

        return false; // Центральная персона уже установлена
    }

    /**
     * Проверяет, является ли персона частью дерева, которое принадлежит авторизованному пользователю.
     *
     * @return bool
     */
    public function isOwnedByAuthUser()
    {
        return $this->tree && $this->tree->user_id === auth()->id();
    }

}
