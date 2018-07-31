<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Hash; 
class AuthController extends Controller
{
    public function register(Request $request){
        $request->validate([
            'email'=>'required',
            'name'=>'required',
            'password'=>'required|min:6'
        ]);

        $user = User::firstOrNew(['email'=>$request->email]);
        $user->name = $request->name;
        $user->email= $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        $http = new Client;

        $response = $http->post(url('oauth/token'), [
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => '2',
                'client_secret' => 'sAJupvEFS991muKblv0xctaOePaIlFviCMZ3Uf1Z',
                'username' => $request->email,
                'password' => $request->password,
                'scope' => '',
            ],
        ]);
        return response(['data'=>json_decode((string) $response->getBody(), true)]);
    }
    public function login(Request $request){
        $request->validate([
            'email'=>'required',
            'email'=>'required'
        ]);

        $user = User::where('email', $request->email)->first();
        if(!$user){
            return response(['status'=>'error', 'message'=>'User not Found']);
        }
        if(Hash::check($user->password, $request->password));

        $http = new Client;

        $response = $http->post(url('oauth/token'), [
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => '2',
                'client_secret' => 'sAJupvEFS991muKblv0xctaOePaIlFviCMZ3Uf1Z',
                'username' => $request->email,
                'password' => $request->password,
                'scope' => '',
            ],
        ]);
        return response(['data'=>json_decode((string) $response->getBody(), true)]);
    }
}
