<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserDescriptionUpdateRequest;
use App\Http\Requests\UserInfoUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\ChecksIsDataSecure;
use App\Http\Traits\UploadsFiles;

class UserController extends Controller
{
    use UploadsFiles, ChecksIsDataSecure;

    public function editDescription(UserDescriptionUpdateRequest $request){
        $user = Auth::user();
        $user->description = $this->getSecureData($request->input('description'));
        $user->save();

        return redirect('/home')->with('description_success',__('messages.descrip_success'));
    }

    public function editUserInfo(UserInfoUpdateRequest $request){
        $data = array_map(array($this, 'getSecureData'), $request->all());
        Auth::user()->fill($data)
            ->save();

        return redirect('/home')->with('userinfo_success', __('messages.user_info_success'));
    }

    public function uploadProfileImage(Request $request){
        $img_path = $this->uploadFile('post', $request, 'profile_img', 'profiles');
        $user = Auth::user();
        $user->user_image = $img_path ?? '/img/profile_photo.png';
        $user->save();

        return redirect('/home');
    }
}
