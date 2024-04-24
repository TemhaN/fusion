<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CountriesRequest;
use App\Models\Country;
use Illuminate\Http\Request;


class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $countries = Country::all();
        return view('admins.countries.index',compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CountriesRequest $request)
    {
        $data = $request->validated();
        Country::create($data);
        return redirect(route('countries.index'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $country = Country::findOrFail($id);

        return view('admins.countries.create' , compact('country'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CountriesRequest $request, string $id)
    {
        $country = Country::findOrFail($id);
        $country->update($request->validated());
        return redirect(route('countries.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Country $country)
    {
        $country->delete();
        return redirect(route('countries.index'));
    }
}
