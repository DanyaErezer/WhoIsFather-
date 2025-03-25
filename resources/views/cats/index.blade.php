@extends('layouts.app')

@section('title', 'Главная')

@section('main_content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Cat Registry</h1>
        <a href="{{ route('cats.create') }}" class="btn btn-primary">Add New Cat</a>
    </div>

    <div class="card mb-4">
        <div class="card-header">Filters</div>
        <div class="card-body">
            <form method="GET" action="{{ route('cats.index') }}">
                <div class="row">
                    <div class="col-md-3">
                        <label for="gender" class="form-label">Gender</label>
                        <select name="gender" id="gender" class="form-select">
                            <option value="">All</option>
                            <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="age_min" class="form-label">Min Age</label>
                        <input type="number" name="age_min" id="age_min" class="form-control" value="{{ request('age_min') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="age_max" class="form-label">Max Age</label>
                        <input type="number" name="age_max" id="age_max" class="form-control" value="{{ request('age_max') }}">
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">Filter</button>
                        <a href="{{ route('cats.index') }}" class="btn btn-secondary">Reset</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Name</th>
                <th>Gender</th>
                <th>Age</th>
                <th>Mother</th>
                <th>Father</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($cats as $cat)
                <tr>
                    <td>{{ $cat->name }}</td>
                    <td>{{ ucfirst($cat->gender) }}</td>
                    <td>{{ $cat->age }} year(s)</td>
                    <td>
                        @if($cat->mother)
                            {{ $cat->mother->name }}
                        @else
                            Unknown
                        @endif
                    </td>
                    <td>
                        @if($cat->father)
                            {{ $cat->father->name }}
                        @else
                            Unknown
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('cats.show', $cat->id) }}" class="btn btn-sm btn-info">View</a>
                        <a href="{{ route('cats.edit', $cat->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('cats.destroy', $cat->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
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
