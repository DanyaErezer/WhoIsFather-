@extends('layouts.app')

@section('title', 'Подробная информация')

@section('main_content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="mb-0">Детали: {{ $cat->name }}</h3>
                            <div>
                                <a href="{{ route('cats.edit', $cat->id) }}" class="btn btn-sm btn-light me-2">
                                    <i class="bi bi-pencil"></i> Редактировать
                                </a>
                                <form action="{{ route('cats.destroy', $cat->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this cat?')">
                                        <i class="bi bi-trash"></i> Удалить
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-4 text-center">
                                <div class="cat-avatar bg-light p-4 rounded-circle d-inline-flex align-items-center justify-content-center"
                                     style="width: 150px; height: 150px;">
                                    <i class="bi bi-heart-fill text-muted" style="font-size: 3rem;"></i>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="table-responsive">
                                    <table class="table table-borderless">
                                        <tbody>
                                        <tr>
                                            <th width="30%">Имя:</th>
                                            <td>{{ $cat->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Пол:</th>
                                            <td>
                                                <span class="badge bg-{{ $cat->gender == 'Male' ? 'primary' : 'danger' }}">
                                                    {{ $cat->gender }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Возраст:</th>
                                            <td>{{ $cat->age }} годиков</td>
                                        </tr>
                                        @if($cat->parentsRelation)
                                            <tr>
                                                <th>Мать:</th>
                                                <td>
                                                    <a href="{{ route('cats.show', $cat->parentsRelation->mother_id) }}">
                                                        {{ $cat->parentsRelation->mother->name }}
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Отец:</th>
                                                <td>
                                                    <a href="{{ route('cats.show', $cat->parentsRelation->father_id) }}">
                                                        {{ $cat->parentsRelation->father->name }}
                                                    </a>
                                                </td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        @if($cat->kittens->count() > 0)
                            <div class="mt-4">
                                <h5 class="border-bottom pb-2">Котята</h5>
                                <div class="row row-cols-1 row-cols-md-3 g-4">
                                    @foreach($cat->kittens as $kitten)
                                        <div class="col">
                                            <div class="card h-100">
                                                <div class="card-body">
                                                    <h6 class="card-title">
                                                        <a href="{{ route('cats.show', $kitten->kitten_id) }}">
                                                            {{ $kitten->kitten->name }}
                                                        </a>
                                                    </h6>
                                                    <p class="card-text mb-1">
                                                        <small class="text-muted">
                                                            Возраст: {{ $kitten->kitten->age }} годиков
                                                        </small>
                                                    </p>
                                                    <span class="badge bg-{{ $kitten->kitten->gender == 'Male' ? 'primary' : 'danger' }}">
                                            {{ $kitten->kitten->gender }}
                                        </span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="card-footer text-muted text-center">
                        <small>Created {{ $cat->created_at->diffForHumans() }} | Updated {{ $cat->updated_at->diffForHumans() }}</small>
                    </div>
                </div>

                <div class="mt-3">
                    <a href="{{ route('cats.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> На Главную
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
