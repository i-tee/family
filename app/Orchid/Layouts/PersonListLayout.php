<?php

namespace App\Orchid\Layouts;

use App\Models\Person;
use Orchid\Screen\TD;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;

class PersonListLayout extends Table
{

    public $target = 'persons';

    public function columns(): array
    {
        return [
            TD::make('first_name', 'Name')
                ->render(function (Person $person) {
                    return Link::make($person->first_name)
                        ->route('platform.post.edit', $person);
                }),

            TD::make('created_at', 'Created'),
            TD::make('updated_at', 'Last edit'),
        ];
    }
}