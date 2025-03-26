@extends('layouts.app')

@section('title', 'Главная')

@section('main_content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Регистрация котиков</h1>
        <a href="{{ route('cats.create') }}" class="btn btn-primary">Добавить нового котика</a>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-light">Фильтр</div>
        <div class="card-body">
            <form method="GET" action="{{ route('cats.index') }}">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label for="gender" class="form-label">Пол</label>
                        <select name="gender" id="gender" class="form-select">
                            <option value="">Все</option>
                            <option value="Male" {{ request('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ request('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="age_min" class="form-label">Мин</label>
                        <input type="number" name="age_min" id="age_min"
                               class="form-control" min="0"
                               value="{{ request('age_min') }}"
                               placeholder="От">
                    </div>
                    <div class="col-md-3">
                        <label for="age_max" class="form-label">Макс</label>
                        <input type="number" name="age_max" id="age_max"
                               class="form-control" min="0"
                               value="{{ request('age_max') }}"
                               placeholder="До">
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="bi bi-funnel"></i> Искать
                        </button>
                        <a href="{{ route('cats.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-counterclockwise"></i> Сбросить
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Имя</th>
                <th>Пол</th>
                <th>Возраст</th>
                <th>Мать</th>
                <th>Отец</th>
                <th>Функции</th>
            </tr>
            </thead>
            <tbody>
            @foreach($cats as $cat)
                <tr>
                    <td>{{ $cat->name }}</td>
                    <td>{{ ucfirst($cat->gender) }}</td>
                    <td>{{ $cat->age }} годиков</td>
                    <td>
                        @if($cat->mother)
                            {{ $cat->mother->name }}
                        @else
                            Неизвестно(
                        @endif
                    </td>
                    <td>
                        @if($cat->father)
                            {{ $cat->father->name }}
                        @else
                            Неизвестно)
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('cats.show', $cat->id) }}" class="btn btn-sm btn-info">Подробнее</a>
                        <a href="{{ route('cats.edit', $cat->id) }}" class="btn btn-sm btn-warning">Редактировать</a>
                        <form action="{{ route('cats.destroy', $cat->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Удалить</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center">
        {{ $cats->links() }}
    </div>
@endsection
