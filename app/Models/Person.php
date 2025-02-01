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
}