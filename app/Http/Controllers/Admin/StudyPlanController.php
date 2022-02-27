<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStudyPlanRequest;
use App\Http\Requests\UpdateStudyPlanRequest;
use App\Models\StudyPlan;

class StudyPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $studyPlans = studyPlan::get();

        return view('admin.study-plans.index', ['studyPlans' => $studyPlans]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.study-plans.edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreStudyPlanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStudyPlanRequest $request)
    {
        $studyPlan = StudyPlan::create($request->validated());
        $studyPlan->save();

        return redirect()->route('admin.study-plans.show', $studyPlan);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StudyPlan  $studyPlan
     * @return \Illuminate\Http\Response
     */
    public function show(StudyPlan $studyPlan)
    {
        return view('admin.study-plans.show', ['studyPlan' => $studyPlan]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StudyPlan  $studyPlan
     * @return \Illuminate\Http\Response
     */
    public function edit(StudyPlan $studyPlan)
    {
        return view('admin.study-plans.edit', ['studyPlan' => $studyPlan]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateStudyPlanRequest  $request
     * @param  \App\Models\StudyPlan  $studyPlan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStudyPlanRequest $request, StudyPlan $studyPlan)
    {
        $studyPlan->fill($request->validated());
        $studyPlan->save();

        return redirect()->route('admin.study-plans.show', $studyPlan);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StudyPlan  $studyPlan
     * @return \Illuminate\Http\Response
     */
    public function destroy(StudyPlan $studyPlan)
    {
        $studyPlan->delete();

        return redirect()->route('admin.study-plans.index');
    }
}
