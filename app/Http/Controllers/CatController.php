<?php

namespace App\Http\Controllers;

use App\Http\Requests\CatStoreRequest;
use App\Http\Requests\CatUpdateRequest;
use App\Models\Cat;
use App\Models\CatsParent;
use Illuminate\Http\Request;

class CatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Cat::query();

        if ($request->has('gender') && in_array($request->gender, ['Male', 'Female'])){
            $query->where('gender', $request->gender);
        }
        if ($request->has('age_min')){
            $query->where('age', '>=', $request->age_min);
        }
        if ($request->has('age_max')){
            $query->where('age', '<=', $request->age_max);
        }
        $cats = $query->paginate(20);

        return view('cats.index', compact('cats'));
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
        $cat = Cat::create($request->validated());

        if ($request->mother_id && $request->father_ids) {
            foreach ($request->father_ids as $father_id) {
                CatsParent::create([
                    'kitten_id' => $cat->id,
                    'mother_id' => $request->mother_id,
                    'father_id' => $father_id,
                ]);
            }
        }

        return redirect()->route('cats.index')->with('message', 'Кот успешно добавлен!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cat $cat)
    {
        return view('cats.show', compact('cat'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cat $cat)
    {
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

        return redirect('cats.index')->with('success', 'Кот успешно обновлен');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cat $cat)
    {
        $cat->delete();

        return redirect('cats.index')->with('success', 'Кот успешно удален!');
    }
}
