<?php

namespace App\Orchid\Screens;

use App\Orchid\Layouts\TreeListLayout;
use App\Models\Tree;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class TreeListScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'trees' => Tree::paginate()
        ];
    }

    /**
     * The name is displayed on the user's screen and in the headers.
     */
    public function name(): ?string
    {
        return 'Family Trees';
    }

    /**
     * The description is displayed on the user's screen under the heading.
     */
    public function description(): ?string
    {
        return "List of all family trees";
    }

    /**
     * Button commands.
     *
     * @return Link[]
     */
    public function commandBar(): array
    {
        return [
            Link::make('Create new tree')
                ->icon('plus')
                ->route('platform.tree.edit')
        ];
    }

    /**
     * Views.
     *
     * @return Layout[]
     */
    public function layout(): array
    {
        return [
            TreeListLayout::class
        ];
    }
}
