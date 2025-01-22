<?php

namespace App\Orchid\Screens;

use App\Models\Person;
use App\Models\Tree; // Модель для связи с семейным деревом
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;

class PersonEditScreen extends Screen
{
    /**
     * @var Person
     */
    public $person;

    /**
     * Query data.
     *
     * @param Person $person
     *
     * @return array
     */
    public function query(Person $person): array
    {
        return [
            'person' => $person
        ];
    }

    /**
     * The name is displayed on the user's screen and in the headers
     */
    public function name(): ?string
    {
        return $this->person->exists ? 'Edit Person' : 'Creating a new Person';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Person Details";
    }

    /**
     * Button commands.
     *
     * @return Link[] 
     */
    public function commandBar(): array
    {
        return [
            Button::make('Create Person')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->person->exists),

            Button::make('Update')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->person->exists),

            Button::make('Remove')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->person->exists),
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
                Input::make('person.first_name')
                    ->title('First Name')
                    ->placeholder('Enter first name')
                    ->required(),

                Input::make('person.last_name')
                    ->title('Last Name')
                    ->placeholder('Enter last name')
                    ->required(),

                Input::make('person.middle_name') // Изменено на middle_name
                    ->title('Middle Name') // Изменено на "Middle Name"
                    ->placeholder('Enter middle name'),

                DateTimer::make('person.birth_date')
                    ->title('Date of Birth')
                    ->placeholder('Select date of birth')
                    ->required(),

                DateTimer::make('person.death_date')
                    ->title('Date of Death')
                    ->placeholder('Select date of death'),

                Relation::make('person.tree_id')
                    ->title('Family Tree')
                    ->fromModel(Tree::class, 'name') // Ссылаемся на модель Tree
                    ->required(),
            ])
        ];
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createOrUpdate(Request $request)
    {
        $this->person->fill($request->get('person'))->save();

        Alert::info('You have successfully created or updated a person.');

        return redirect()->route('platform.person.list'); // Переадресация на список людей
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove()
    {
        $this->person->delete();

        Alert::info('You have successfully deleted the person.');

        return redirect()->route('platform.person.list'); // Переадресация на список людей
    }
}
