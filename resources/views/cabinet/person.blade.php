<x-app-layout>
    <div class="container py-4">
        <h1 class="mb-4">{{ $person->fullName() }}</h1>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('dashboard.person.update', $person->id) }}" method="POST">

                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Имя</label>
                        <input type="text" name="first_name" value="{{ old('first_name', $person->first_name) }}"
                            class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Отчество</label>
                        <input type="text" name="middle_name" value="{{ old('middle_name', $person->middle_name) }}"
                            class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Фамилия</label>
                        <input type="text" name="last_name" value="{{ old('last_name', $person->last_name) }}"
                            class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Дата рождения</label>
                        <input type="date" name="birth_date" value="{{ old('birth_date', $person->birth_date) }}"
                            class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Дата смерти</label>
                        <input type="date" name="death_date" value="{{ old('death_date', $person->death_date) }}"
                            class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Пол</label>
                        <div class="form-check form-check-inline">
                            <input 
                                type="radio" 
                                name="gender" 
                                value="1" 
                                class="form-check-input" 
                                {{ old('gender', $person->gender) == 1 ? 'checked' : '' }}
                            />
                            <label class="form-check-label">Мужской</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input 
                                type="radio" 
                                name="gender" 
                                value="0" 
                                class="form-check-input" 
                                {{ old('gender', $person->gender) == 0 ? 'checked' : '' }}
                            />
                            <label class="form-check-label">Женский</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Мать</label>
                        @if($person->mother)
                            <a href="{{ route('dashboard.person.edit', $person->mother_id) }}"
                                class="d-block">{{ $person->mother->fullName() }}</a>
                        @else
                            <span class="text-muted">Нет данных</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Отец</label>
                        @if($person->father)
                            <a href="{{ route('dashboard.person.edit', $person->father_id) }}"
                                class="d-block">{{ $person->father->fullName() }}</a>
                        @else
                            <span class="text-muted">Нет данных</span>
                        @endif
                    </div>

                    <pre>
                        {{ var_dump($person->motherFriendly()) }}
                    </pre>

                    <pre>
                        {{ var_dump($person->fotherFriendly()) }}
                    </pre>

                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>
