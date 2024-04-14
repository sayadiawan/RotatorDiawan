<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('users.setting');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'current_password' => ['required', new MatchOldPassword],
                'new_password' => 'required',
                'confirm_password' => 'required|same:new_password'
            ],
            [],
            [
                'current_password' => 'password saat ini',
                'new_password' => 'password baru',
                'confirm_password' => 'konfirmasi password'
            ]
        );

        $simpan = User::find(Auth::id())->update([
            'password' => Hash::make($request->new_password)
        ]);

        //jika data berhasil diupdate, akan kembali ke halaman utama
        if (!is_null($simpan)) {
            return redirect()->route('usersetting')
                ->with('success', 'Password user berhasil diubah!');
        } else {
            return redirect()->route('usersetting')
                ->with('failed', 'Password user tidak berhasil diubah!');
        }
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
