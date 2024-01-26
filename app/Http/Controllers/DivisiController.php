<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use Illuminate\Http\Request;

class DivisiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $divisis = Divisi::where('name', '!=', 'Manager')->get();
        return view('divisi.index', compact('divisis'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('divisi.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $divisi = Divisi::create($validatedData);
        $divisi->save();
        return redirect(route('div.index'))->with('success', 'Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $divisi = Divisi::findOrFail($id);

        return view('divisi.edit', compact('divisi'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $divisi = Divisi::findOrFail($id);
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        if ($divisi->update($validatedData)) {
            return redirect(route('div.index'))->with('success', 'Updated Successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $divisi = Divisi::findOrFail($id);
        if ($divisi->users->isNotEmpty()) {
            return redirect(route('div.index'))->with('error', 'Sorry, unable to delete this. Department already has staffs.');
        }
        
        if ($divisi->delete()){
            return redirect(route('div.index'))->with('success', 'Deleted Successfully');
        }

        return redirect(route('div.index'))->with('error', 'Sorry, unable to delete this');
    }
}