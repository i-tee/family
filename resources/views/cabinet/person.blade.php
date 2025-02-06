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
                        <label class="form-label">Мать</label>
                        @if($person->mother)
                            <a href="{{ route('persons.edit', $person->mother->id) }}"
                                class="d-block">{{ $person->mother->fullName() }}</a>
                        @else
                            <span class="text-muted">Нет данных</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Отец</label>
                        @if($person->father)
                            <a href="{{ route('persons.edit', $person->father->id) }}"
                                class="d-block">{{ $person->father->fullName() }}</a>
                        @else
                            <span class="text-muted">Нет данных</span>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>