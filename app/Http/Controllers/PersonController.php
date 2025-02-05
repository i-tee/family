<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Person;
use App\Models\Tree;

class PersonController extends Controller
{
    /**
     * Отображает форму для редактирования персоны.
     *
     * @param  \App\Models\Person  $person
     * @return \Illuminate\View\View
     */
    public function edit(Person $person)
    {

        // Передаем данные в Blade-шаблон
        return view('cabinet.person', [
            'tree_id' => 0,
            '$persons' => 11,
        ]);
    }

    /**
     * Обновляет персону.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Person  $person
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Person $person)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'middle_name' => 'string|max:255',
            'birth_date' => 'nullable|date',
            'death_date' => 'nullable|date',
            'tree_id' => 'nullable|exists:trees,id',
            'mother_id' => 'nullable|exists:persons,id',
            'father_id' => 'nullable|exists:persons,id',
        ]);

        $person->update($validated);

        return redirect()->route('dashboard.tree.show', $person->tree_id)->with('success', 'Person updated successfully.');
    }
}