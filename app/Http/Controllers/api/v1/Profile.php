<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Profile extends Controller
{
    public function login(Request $request): \Illuminate\Http\JsonResponse
    {
        $validData =  $request->validate([
            'number' => ['required','regex:/(09)[0-9]{9}/','digits:11','numeric'],
            'password' => ['required'],
            'device_name' => 'required',
        ]);

//        if ($validator->fails()){
//            return response()->json([
//                'errors' => $validator->errors(),
//                'status' => 'error'
//            ],400);
//        }
        if (Auth::attempt(['number' => $validData['number'],'password' => $validData['password']])){
            $user = Auth::user();
            $token = $user->createToken($request->device_name)->plainTextToken;

            return response()->json([
                'data' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'token' => $token,
                ],
                'status' => 'success'
            ]);
        }else{
            return response()->json([
                'errors' => [
                    'massage' => 'رمز عبور یا نام کاربری درست نیست'
                ],
                'status' => 'error'
            ],400);
        }

    }

    public function register(Request $request): \Illuminate\Http\JsonResponse
    {
        $validData =  $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'number' => ['required','regex:/(09)[0-9]{9}/','digits:11','numeric','unique:'.User::class],
            'password' => ['required', 'confirmed'],
            'device_name' => 'required',
        ]);

//        if ($validator->fails()){
//            return response()->json([
//                'errors' => $validator->errors(),
//                'status' => 'error'
//            ],400);
//        }

        $validData['password'] = bcrypt($validData['password']);
        $user = User::query()->create($validData);
        $token = $user->createToken($request->device_name)->plainTextToken;

        return response()->json([
            'data' => [
                'full_name' => $user->full_name,
                'number' => $user->number,
                'token' => $token,
            ],
            'status' => 'success'
        ]);
    }

    public function getUserData(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'data' => \auth()->user()
        ]);
    }

    public function update()
    {

    }
}
