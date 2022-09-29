<?php

namespace App\Repositories;

use App\Models\User;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Token;
use App\Helpers\UploadHelper;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthRepository
{
    public function getData($page_num, $page_size)
    {
        $page_num = isset($page_num) ? ($page_num+1) : 0;
        $page_size = isset($page_size) ? $page_size : 10;
        $users = User::paginate($page_size, ['*'], "Users", $page_num)->where('type', '');
        // $users = User::paginate($page_size, ['*'], "Users", $page_num);
        return $users;
    }

    public function register($request)
    {
        // $data = $request->all();

        $validator = Validator::make($request->all(), [
                'name' => 'required|max:255|regex:/^[\pL\s\-]+$/u',
                'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|max:10',
                'email' => 'email|required|unique:users,email,' . $request->email,
                'password' => 'required',
            ],
        );

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }


        $input = $request->all();

        $uploadFolder = 'users';
        $image = $request->file('photo');
        $image_uploaded_path = $image->store($uploadFolder, 'public');
        $input['photo'] = basename($image_uploaded_path);
        $input['password'] = bcrypt($input['password']);
        $User = User::create($input);
        return $User;
    }

    public function userupdate($request, $id){
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|max:255|regex:/^[\pL\s\-]+$/u',
                'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|max:10',
                'email' => 'email|required|unique:users,email,' . $request->email
            ],
        );

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $input = $request->all();

        $uploadFolder = 'users';
        $image = $request->file('photo');
        $image_uploaded_path = $image->store($uploadFolder, 'public');
        $input['photo'] = basename($image_uploaded_path);

        $User = User::find($id);
        $User->update($input);
        $User->save();
        return $User;
    }


}
