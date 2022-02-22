<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQuestionnaireGroupRequest;
use App\Http\Requests\UpdateQuestionnaireGroupRequest;
use App\Models\Period;
use App\Models\QuestionnaireGroup;

class QuestionnaireGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questionnaireGroups = QuestionnaireGroup::get();

        return view('admin.questionnaire-groups.index', ['questionnaireGroups' => $questionnaireGroups]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $periods = Period::get();

        return view('admin.questionnaire-groups.edit', ['periods' => $periods]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreQuestionnaireGroupRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreQuestionnaireGroupRequest $request)
    {
        $questionnaireGroup = QuestionnaireGroup::create($request->validated());
        $questionnaireGroup->save();

        return redirect()->route('admin.questionnaire-groups.show', $questionnaireGroup);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\QuestionnaireGroup  $questionnaireGroup
     * @return \Illuminate\Http\Response
     */
    public function show(QuestionnaireGroup $questionnaireGroup)
    {
        return view('admin.questionnaire-groups.show', ['questionnaireGroup' => $questionnaireGroup]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\QuestionnaireGroup  $questionnaireGroup
     * @return \Illuminate\Http\Response
     */
    public function edit(QuestionnaireGroup $questionnaireGroup)
    {
        $periods = Period::get();

        return view('admin.questionnaire-groups.edit', ['questionnaireGroup' => $questionnaireGroup, 'periods' => $periods]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateQuestionnaireGroupRequest  $request
     * @param  \App\Models\QuestionnaireGroup  $questionnaireGroup
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateQuestionnaireGroupRequest $request, QuestionnaireGroup $questionnaireGroup)
    {
        $questionnaireGroup->fill($request->validated());
        $questionnaireGroup->save();

        return redirect()->route('admin.questionnaire-groups.show', $questionnaireGroup);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\QuestionnaireGroup  $questionnaireGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(QuestionnaireGroup $questionnaireGroup)
    {
        $questionnaireGroup->delete();

        return redirect()->route('admin.questionnaire-groups.index');
    }
}
