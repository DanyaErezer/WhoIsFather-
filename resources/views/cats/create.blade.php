@extends('layouts.app')

@section('title', 'Добавление котика')

@section('main_content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3>Добавить нового кота</h3>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('cats.store') }}">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Имя *</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                       name="name" value="{{ old('name') }}" required>
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Пол *</label>
                                <select class="form-select @error('gender') is-invalid @enderror" name="gender" required>
                                    <option value="">Выберите пол</option>
                                    <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                                </select>
                                @error('gender')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Возраст (лет) *</label>
                                <input type="number" class="form-control @error('age') is-invalid @enderror"
                                       name="age" min="0" value="{{ old('age') }}" required>
                                @error('age')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Мать (необязательно)</label>
                                <select class="form-select" name="mother_id">
                                    <option value="">Не указана</option>
                                    @foreach($mothers as $mother)
                                        <option value="{{ $mother->id }}" {{ old('mother_id') == $mother->id ? 'selected' : '' }}>
                                            {{ $mother->name }} ({{ $mother->age }} лет)
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Отец (необязательно)</label>
                                <select class="form-select" name="father_id">
                                    <option value="">Не указан</option>
                                    @foreach($fathers as $father)
                                        <option value="{{ $father->id }}" {{ old('father_id') == $father->id ? 'selected' : '' }}>
                                            {{ $father->name }} ({{ $father->age }} лет)
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">Добавить кота</button>
                                <a href="{{ route('cats.index') }}" class="btn btn-secondary">Отмена</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
