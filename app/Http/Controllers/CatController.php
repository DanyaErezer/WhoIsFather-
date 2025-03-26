<?php

namespace App\Http\Controllers;

use App\Http\Requests\CatIndexRequest;
use App\Http\Requests\CatStoreRequest;
use App\Http\Requests\CatUpdateRequest;
use App\Models\Cat;
use App\Models\CatsParent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CatIndexRequest $request)
    {
        // Получаем только провалидированные данные без повторной валидации
        $filters = $request->safe()->only(['gender', 'age_min', 'age_max']);

        $query = Cat::with(['parentsRelation.mother', 'parentsRelation.father'])
            ->when($filters['gender'] ?? false, fn($q, $gender) => $q->where('gender', $gender))
            ->when($filters['age_min'] ?? false, fn($q, $age) => $q->where('age', '>=', $age))
            ->when($filters['age_max'] ?? false, fn($q, $age) => $q->where('age', '<=', $age))
            ->orderBy('name')
            ->paginate(50);

        return view('cats.index', [
            'cats' => $query,
            'filters' => $filters
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mothers = Cat::where('gender', 'Female')->get();
        $fathers = Cat::where('gender', 'Male')->get();

        return view('cats.create', compact('mothers', 'fathers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CatStoreRequest $request)
    {
        try {
            DB::beginTransaction();

            $cat = Cat::create([
                'name' => $request->name,
                'gender' => $request->gender,
                'age' => $request->age
            ]);

            if ($request->mother_id || $request->father_id) {
                CatsParent::create([
                    'kitten_id' => $cat->id,
                    'mother_id' => $request->mother_id,
                    'father_id' => $request->father_id
                ]);
            }

            DB::commit();

            return redirect()->route('cats.index')
                ->with('success', 'Кот '.$cat->name.' успешно добавлен!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Ошибка при добавлении кота: '.$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Cat $cat)
    {
        $cat->load(['parentsRelation.mother', 'parentsRelation.father']);

        return view('cats.show', compact('cat'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cat $cat)
    {
        $cat->load(['parentsRelation']);
        $mothers = Cat::where('gender', 'Female')->get();
        $fathers = Cat::where('gender', 'Male')->get();

        return view('cats.edit', compact('cat', 'mothers', 'fathers'));
    }

    public function update(CatUpdateRequest $request, Cat $cat)
    {
        $cat->update($request->validated());

        if ($request->mother_id || $request->father_id) {
            $cat->parentsRelation()->delete();

            CatsParent::create([
                'kitten_id' => $cat->id,
                'mother_id' => $request->mother_id,
                'father_id' => $request->father_id
            ]);
        } else {
            $cat->parentsRelation()->delete();
        }

        return redirect()->route('cats.show', $cat->id)
            ->with('success', 'Данные кота успешно обновлены!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cat $cat)
    {
        $cat->parentsRelation()->delete();
        $cat->delete();

        return redirect()->route('cats.index')->with('success', 'Кот успешно удален!');
    }
}
