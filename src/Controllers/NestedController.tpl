<?php

namespace DummyNamespace;

use DummyFullModelClass;
use ParentDummyFullModelClass;
use Illuminate\Http\Request;
use DummyApiNamespace\DummyApiName;

class DummyClass extends DummyApiName
{
    /**
     * Display a listing of the resource.
     *
     * @param  \ParentDummyFullModelClass  $ParentDummyModelVariable
     * @return \Illuminate\Http\Response
     */
    public function index(ParentDummyModelClass $ParentDummyModelVariable)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \ParentDummyFullModelClass  $ParentDummyModelVariable
     * @return \Illuminate\Http\Response
     */
    public function create(ParentDummyModelClass $ParentDummyModelVariable)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \ParentDummyFullModelClass  $ParentDummyModelVariable
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, ParentDummyModelClass $ParentDummyModelVariable)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \ParentDummyFullModelClass  $ParentDummyModelVariable
     * @param  \DummyFullModelClass  $DummyModelVariable
     * @return \Illuminate\Http\Response
     */
    public function show(ParentDummyModelClass $ParentDummyModelVariable, DummyModelClass $DummyModelVariable)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \ParentDummyFullModelClass  $ParentDummyModelVariable
     * @param  \DummyFullModelClass  $DummyModelVariable
     * @return \Illuminate\Http\Response
     */
    public function edit(ParentDummyModelClass $ParentDummyModelVariable, DummyModelClass $DummyModelVariable)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \ParentDummyFullModelClass  $ParentDummyModelVariable
     * @param  \DummyFullModelClass  $DummyModelVariable
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ParentDummyModelClass $ParentDummyModelVariable, DummyModelClass $DummyModelVariable)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \ParentDummyFullModelClass  $ParentDummyModelVariable
     * @param  \DummyFullModelClass  $DummyModelVariable
     * @return \Illuminate\Http\Response
     */
    public function destroy(ParentDummyModelClass $ParentDummyModelVariable, DummyModelClass $DummyModelVariable)
    {
        //
    }
}
