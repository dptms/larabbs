<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Http\Requests\UserRequest;
use App\Models\User;
use QrCode;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'show']);
    }

    public function show(User $user)
    {
        $qrcode = $user->qrcode();

        return view('users.show', compact('user', 'qrcode'));
    }

    public function downloadQrcode(User $user)
    {
        return response()->stream(function () use ($user) {
            echo $user->qrcode();
        }, 200, [
            "Content-type"=>"image/png",
            "Content-Disposition"=>"attachment; filename=user-{$user->id}-qrcode.png"
        ]);
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    public function update(UserRequest $request, ImageUploadHandler $uploader, User $user)
    {
        $this->authorize('update', $user);
        $data = $request->all();
        if ($request->avatar) {
            $avatar = $uploader->save($request->avatar, 'avatar', $user->id, 362);
            if ($avatar) {
                $data['avatar'] = $avatar['path'];
            }
        }
        $user->update($data);

        return redirect()->route('users.show', $user)->with('success', '个人资料更新成功！');
    }
}
