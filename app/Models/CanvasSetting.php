<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CanvasSetting extends Model
{
    use HasFactory;

    protected $table = 'canvas_settings';
    protected $fillable = ['width', 'height', 'vertical_margin', 'horizontal_margin'];
    public $timestamps = true;

    // Получение единственной записи
    public static function instance(): self
    {
        return self::first() ?? new self();
    }
}
