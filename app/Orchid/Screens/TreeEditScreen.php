<?php

namespace App\Orchid\Screens;

use App\Models\Tree;
use App\Models\User;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;

class TreeEditScreen extends Screen
{
    /**
     * @var Tree
     */
    public $tree;

    /**
     * Query data.
     *
     * @param Tree $tree
     *
     * @return array
     */
    public function query(Tree $tree): array
    {
        return [
            'tree' => $tree,
        ];
    }

    /**
     * The name is displayed on the user's screen and in the headers
     */
    public function name(): ?string
    {
        return $this->tree->exists ? 'Edit Tree' : 'Creating a New Tree';
    }

    /**
     * Button commands.
     *
     * @return Link[]
     */
    public function commandBar(): array
    {
        return [
            Button::make('Create Tree')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->tree->exists),

            Button::make('Update')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->tree->exists),

            Button::make('Remove')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->tree->exists),
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
            Layout::rows([
                Input::make('tree.name')
                    ->title('Name')
                    ->placeholder('Enter the tree name')
                    ->help('Specify a unique name for this family tree.'),

                Relation::make('tree.user_id')
                    ->title('User')
                    ->fromModel(User::class, 'name')
                    ->required(),
            ]),
        ];
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createOrUpdate(Request $request)
    {
        $this->tree->fill($request->get('tree'))->save();

        Alert::info('You have successfully saved the tree.');

        return redirect()->route('platform.tree.list');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove()
    {
        $this->tree->delete();

        Alert::info('You have successfully deleted the tree.');

        return redirect()->route('platform.tree.list');
    }
}
