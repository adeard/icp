<?php

namespace App\Http\Controllers;

use App\User;
use App\Helpers\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth, Auth;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller
{
    public function __construct()
    {
        $this->status   = "true";
        $this->data     = [];
        $this->errorMsg = null;
    }    

    public function login(Request $request){
        try {
            $credentials = $request->only(['username', 'password']);
            $token = JWTAuth::attempt($credentials);
            if(!$token) {
                return response()->json(Api::format("false", $this->data, 'Email atau Password anda salah.'), 200);
            }

        } catch (JWTException $e) {
            return response()->json(Api::format("false", $this->data, $e->getMessage()), 200);
        }

        $user =  Auth::user();
        $name = $user->fullname;
        $id = $user->id;

        return response()->json(Api::format($this->status, compact('token', 'name', 'id'), $this->errorMsg), 200);
    }

    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'fullname' => 'required|string|max:255',
                'username' => 'required|string|max:255|unique:users',
                'password' => 'required|string|min:6',
            ]);
    
            if($validator->fails()){
                return response()->json($validator->errors(), 400);
            }
    
            $this->data = User::create([
                'fullname' => $request->get('fullname'),
                'username' => $request->get('username'),
                'password' => Hash::make($request->get('password')),
            ]);
            
        } catch (\Exception $e) {
            $this->status   = "false";
            $this->errorMsg = $e->getMessage();
        }

        return response()->json(Api::format($this->status, $this->data, $this->errorMsg), 201);
    }

    public function getAuthenticatedUser()
    {
        try {

            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());

        }

        return response()->json(compact('user'));
    }
}