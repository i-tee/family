<?php

namespace App\Orchid\Screens;

use App\Models\CanvasSetting;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout as OrchidLayout;

class CanvasSettingScreen extends Screen
{
    public $canvas;

    public function query(): array
    {
        return [
            'canvas' => CanvasSetting::instance(),
        ];
    }

    public function name(): string
    {
        return 'Настройки холста';
    }

    public function commandBar(): array
    {
        return [
            Button::make('Сохранить')
                ->icon('check')
                ->method('update'),
        ];
    }

    public function layout(): array
    {
        return [
            OrchidLayout::rows([
                Input::make('canvas.width')
                    ->type('number')
                    ->title('Ширина')
                    ->required(),

                Input::make('canvas.height')
                    ->type('number')
                    ->title('Высота')
                    ->required(),

                Input::make('canvas.vertical_margin')
                    ->type('number')
                    ->title('Вертикальный отступ')
                    ->required(),

                Input::make('canvas.horizontal_margin')
                    ->type('number')
                    ->title('Горизонтальный отступ')
                    ->required(),
            ]),
        ];
    }

    public function update()
    {
        $canvas = CanvasSetting::instance();
        $canvas->fill(request()->get('canvas'));
        $canvas->save();

        \Orchid\Support\Facades\Toast::info('Настройки сохранены.');
    }
}
