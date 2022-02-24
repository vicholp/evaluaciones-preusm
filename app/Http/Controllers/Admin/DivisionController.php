<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDivisionRequest;
use App\Http\Requests\UpdateDivisionRequest;
use App\Models\Division;
use App\Models\Period;
use App\Models\StudyPlan;
use App\Models\Subject;

class DivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $divisions = Division::get();

        return view('admin.divisions.index', ['divisions' => $divisions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $periods = Period::get();
        $subjects = Subject::get();
        $studyPlans = StudyPlan::get();

        return view('admin.divisions.edit', [
            'periods' => $periods,
            'subjects' => $subjects,
            'studyPlans' => $studyPlans,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDivisionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDivisionRequest $request)
    {
        $division = Division::create($request->validated());
        $division->save();

        return redirect()->route('admin.divisions.show', $division);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Division  $division
     * @return \Illuminate\Http\Response
     */
    public function show(Division $division)
    {
        return view('admin.divisions.show', ['division' => $division]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Division  $division
     * @return \Illuminate\Http\Response
     */
    public function edit(Division $division)
    {
        $periods = Period::get();
        $subjects = Subject::get();
        $studyPlans = StudyPlan::get();

        return view('admin.divisions.edit', [
            'division' => $division,
            'periods' => $periods,
            'subjects' => $subjects,
            'studyPlans' => $studyPlans,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDivisionRequest  $request
     * @param  \App\Models\Division  $division
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDivisionRequest $request, Division $division)
    {
        $division->fill($request->validated());
        $division->save();

        return redirect()->route('admin.divisions.show', $division);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Division  $division
     * @return \Illuminate\Http\Response
     */
    public function destroy(Division $division)
    {
        $division->delete();

        return redirect()->route('admin.divisions.index');
    }
}
