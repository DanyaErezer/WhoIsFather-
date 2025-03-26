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
            ->paginate(20);

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

            $cat = Cat::create($request->only(['name', 'gender', 'age']));

            if ($request->mother_id && $request->father_ids) {
                foreach ($request->father_ids as $father_id) {
                    CatsParent::create([
                        'kitten_id' => $cat->id,
                        'mother_id' => $request->mother_id,
                        'father_id' => $father_id,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('cats.index')
                ->with('success', 'Cat '.$cat->name.' successfully added!');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withInput()
                ->with('error', 'Error creating cat: '.$e->getMessage());
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

    /**
     * Update the specified resource in storage.
     */
    public function update(CatUpdateRequest $request, Cat $cat)
    {
        $cat->update($request->validated());

        if ($request->has('mother_id') && $request->has('father_ids')) {
            $cat->parentsRelation()->delete();

            // Создаем новые связи
            foreach ($request->father_ids as $father_id) {
                CatsParent::create([
                    'kitten_id' => $cat->id,
                    'mother_id' => $request->mother_id,
                    'father_id' => $father_id,
                ]);
            }
        }

        return redirect()->route('cats.index')->with('success', 'Кот успешно обновлен');
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
