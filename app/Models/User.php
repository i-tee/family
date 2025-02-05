<?php

namespace App\Models;

use Orchid\Filters\Types\Like;
use Orchid\Filters\Types\Where;
use Orchid\Filters\Types\WhereDateStartEnd;
use Orchid\Platform\Models\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{

    use HasApiTokens; // Добавь этот трейт
    //use HasFactory, Notifiable;

    /**
     * Проверяет, есть ли у пользователя дерево.
     *
     * @return bool
     */
     public function hasTree()
    {
        return $this->trees()->exists();
    }

    /**
     * Получить список деревьев пользователя.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getTrees()
    {
        return $this->trees;
    }

    /**
     * Отношение "один ко многим" с моделью Tree.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function trees()
    {
        return $this->hasMany(Tree::class);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'permissions',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'permissions'          => 'array',
        'email_verified_at'    => 'datetime',
    ];

    /**
     * The attributes for which you can use filters in url.
     *
     * @var array
     */
    protected $allowedFilters = [
           'id'         => Where::class,
           'name'       => Like::class,
           'email'      => Like::class,
           'updated_at' => WhereDateStartEnd::class,
           'created_at' => WhereDateStartEnd::class,
    ];

    /**
     * The attributes for which can use sort in url.
     *
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'name',
        'email',
        'updated_at',
        'created_at',
    ];
}
