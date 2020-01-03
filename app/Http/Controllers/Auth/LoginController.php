<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\User; 
use Illuminate\Support\Facades\Auth; 
use Validator;

class LoginController extends Controller 
{

    public $successStatus = 200;
    public $failStatus = 401;

    /** 
     * login api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function login(Request $request)
    {    
        $content = json_decode($request->getContent());
        
        if(Auth::guard('web')->attempt(['name' => $content->username, 'password' => $content->password])){ 
            $user = Auth::user(); 
            $token =  $user->createToken('TerraFinance')->accessToken; 

            return response()->json(
                [
                    'success' => true,
                    'token' => $token
                ],
                $this->successStatus
            ); 
        }

        return response()->json(
            [
                'success' => false,
                'error'=>'Unauthorised'
            ],
            $this->failStatus
        );  
    }

    /** 
     * Register api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function register(Request $request) 
    { 
        $content = json_decode($request->getContent());

        $content = [];
        $content['name'] = 'Terra';
        $content['email'] = 'josericardojunior@gmail.com';
        $content['password'] = bcrypt('!Gaia1225');

        try{
            $user = User::create($content); 
            $success['token'] =  $user->createToken('TerraFinance')->accessToken; 
            $success['name'] =  $user->name;
        } catch(\Exception $e){
            return response()->json(
            [
                'message'=> 'User already exists',
                'success' => false
            ],
            $this->failStatus
        ); 
        }

        return response()->json(
            [
                'success'=> $success
            ],
            $this->successStatus
        ); 
    }

    /** 
     * details api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function details() 
    { 
        $user = Auth::user(); 
        return response()->json(['success' => $user], $this-> successStatus); 
    } 

    /** 
     * 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function index() 
    { 
        return response()->json(
            [
                'data' => 'Please login',
                'success' => false
            ]
        ); 
    }

    public function store(){
        return false;
    }
}