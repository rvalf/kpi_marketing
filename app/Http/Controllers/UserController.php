<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\Divisi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $staffs = User::where('divisi_id', '!=', '1')->where('status', 'aktif')->get();
        return view('staff.index', compact('staffs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $divisis = Divisi::where('name', '!=', 'Manager')->orderBy('name', 'asc')->get()->pluck('name', 'id');
        return view('staff.create', compact('divisis'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $params = $request->validated();
        $params['password'] = bcrypt($params['npk']);
        $params['status'] = 'aktif';
        if ($user = User::create($params)){
            return redirect(route('staff.index'))->with('success', 'Created Successfully');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showProfile()
    {
        $user = Auth::user();
        return view ('staff.showprofile', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        // dd($request->all());
        
        $user = User::findOrFail($id);
        
        $validatedData = $request->validate([
            'password' => 'required|string|min:8',
            'confirmPassword' => 'required|string',
        ]);

        if ($validatedData['password'] != $validatedData['confirmPassword']) {
            return redirect(route('staff.showprofile'))->with('error', 'Re-type the same password on Confirmation!');
        }

        $validatedData['password'] = bcrypt($validatedData['password']);

        if ($user->update($validatedData)) {
            return redirect(route('staff.showprofile'))->with('success', 'Change password success!');
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
        $user = User::findOrFail($id);
        $data['status'] = 'nonaktif';
        if ($user->update($data)) {
            return redirect(route('staff.index'))->with('success', 'Deleted Successfully');
        }

        return redirect(route('staff.index'))->with('error', 'Sorry, unable to delete this');
    }
}
