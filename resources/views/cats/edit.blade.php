@extends('layouts.app')

@section('title', 'Редактирование')

@section('main_content')
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h3>Редактирование кота: {{ $cat->name }}</h3>
                        </div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('cats.update', $cat->id) }}">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label class="form-label">Имя *</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                           name="name" value="{{ old('name', $cat->name) }}" required>
                                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Пол *</label>
                                    <select class="form-select @error('gender') is-invalid @enderror" name="gender" required>
                                        <option value="Male" {{ $cat->gender == 'Male' ? 'selected' : '' }}>Самец</option>
                                        <option value="Female" {{ $cat->gender == 'Female' ? 'selected' : '' }}>Самка</option>
                                    </select>
                                    @error('gender')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Возраст *</label>
                                    <input type="number" class="form-control @error('age') is-invalid @enderror"
                                           name="age" min="0" value="{{ old('age', $cat->age) }}" required>
                                    @error('age')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Мать</label>
                                    <select class="form-select" name="mother_id">
                                        <option value="">Не указана</option>
                                        @foreach($mothers as $mother)
                                            @if($mother->id != $cat->id)
                                                <option value="{{ $mother->id }}"
                                                @isset($cat->parentsRelation)
                                                    {{ $cat->parentsRelation->mother_id == $mother->id ? 'selected' : '' }}
                                                    @endisset>
                                                    {{ $mother->name }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Отец</label>
                                    <select class="form-select" name="father_id">
                                        <option value="">Не указан</option>
                                        @foreach($fathers as $father)
                                            @if($father->id != $cat->id)
                                                <option value="{{ $father->id }}"
                                                @isset($cat->parentsRelation)
                                                    {{ $cat->parentsRelation->father_id == $father->id ? 'selected' : '' }}
                                                    @endisset>
                                                    {{ $father->name }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary">Обновить</button>
                                    <a href="{{ route('cats.show', $cat->id) }}" class="btn btn-secondary">Отмена</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

