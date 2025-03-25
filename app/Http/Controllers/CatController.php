<?php

namespace App\Http\Controllers;

use App\Http\Requests\CatStoreRequest;
use App\Models\Cat;
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
