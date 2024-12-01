<?php

namespace App\Orchid\Layouts;

use App\Models\Tree;
use Orchid\Screen\TD;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;

class TreeListLayout extends Table
{

    public $target = 'trees';

    public function columns(): array
    {
        return [
            TD::make('name', 'Title')
                ->render(function (Tree $tree) {
                    return Link::make($tree->name)
                        ->route('platform.tree.edit', $tree);
                }),

            TD::make('created_at', 'Created'),
            TD::make('updated_at', 'Last edit'),
        ];
    }
}
