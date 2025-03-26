@extends('layouts.app')

@section('title', 'Добавить кошку')

@section('main_content')
    <h1>Добавить нового котика)</h1>

    <form action="{{ route('cats.store') }}" method="POST" id="cat-form">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Имя</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror"
                   id="name" name="name" value="{{ old('name') }}" required>
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="gender" class="form-label">Пол</label>
            <select class="form-select @error('gender') is-invalid @enderror"
                    id="gender" name="gender" required>
                <option value="">Выбрать пол</option>
                <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
            </select>
            @error('gender')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="age" class="form-label">Возраст</label>
            <input type="number" class="form-control @error('age') is-invalid @enderror"
                   id="age" name="age" min="0" max="30" value="{{ old('age') }}" required>
            @error('age')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="mother_id" class="form-label">Мать</label>
            <select class="form-select" id="mother_id" name="mother_id">
                <option value="">Неизвестно(</option>
                @foreach($mothers as $mother)
                    <option value="{{ $mother->id }}" {{ old('mother_id') == $mother->id ? 'selected' : '' }}>
                        {{ $mother->name }} ({{ $mother->age }} годиков
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Отец</label>
            @foreach($fathers as $father)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox"
                           name="father_ids[]" value="{{ $father->id }}"
                           id="father_{{ $father->id }}"
                        {{ in_array($father->id, old('father_ids', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="father_{{ $father->id }}">
                        {{ $father->name }} ({{ $father->age }} годиков
                    </label>
                </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-primary">Добавить</button>
        <a href="{{ route('cats.index') }}" class="btn btn-secondary">На главную</a>
    </form>
@endsection
