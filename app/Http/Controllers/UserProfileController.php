<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('users.profile');
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
        //
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
        $request->validate(
            [
                'name' => 'required|max:50',
                'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ],
            [],
            [
                'name' => 'user name',
                'avatar' => 'user avatar',
            ]
        );

        if ($request->avatar) {
            Storage::delete($request->avatar_old);
            $image_path = $request->file('avatar')->store('user_avatars');
        } else {
            $image_path = $request->avatar_old;
        }

        //fungsi eloquent untuk mengupdate data inputan kita
        $simpan = User::where('id', $user->id)
            ->update([
                'name' => $request->name,
                'avatar' => $image_path,
            ]);

        //jika data berhasil diupdate, akan kembali ke halaman utama
        if (!is_null($simpan)) {
            return redirect()->route('userprofile')
                ->with('success', 'User berhasil diubah!');
        } else {
            return redirect()->route('userprofile')
                ->with('failed', 'User tidak berhasil diubah!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, User $user)
    {
        if ($user->avatar) {
            Storage::delete($user->avatar);
        }

        $simpan = User::where('id', $user->id)
            ->update([
                'avatar' => null,
            ]);

        //jika data berhasil dihapus, akan kembali ke halaman utama
        if (!is_null($simpan)) {
            return redirect()->route('userprofile')
                ->with('success', 'User berhasil diubah!');
        } else {
            return redirect()->route('userprofile')
                ->with('failed', 'User tidak berhasil diubah!');
        }
    }
}
