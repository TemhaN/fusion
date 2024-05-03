<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ActorRequest;
use App\Models\Actor;
use Illuminate\Http\Request;

class ActorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $actors = Actor::all();
        return view('admins.actors.index',compact('actors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ActorRequest $request)
    {
        $data = $request->validated();
        Actor::create($data);
        return redirect(route('actors.index'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $actors = Actor::findOrFail($id);

        return view('admins.actors.create' , compact('actors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ActorRequest $request, string $id)
    {
        $actor = Actor::findOrFail($id);
        $actor->update($request->validated());
        return redirect(route('actors.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Actor $actor)
    {
        $actor->delete();
        return redirect(route('actors.index'));
    }
}