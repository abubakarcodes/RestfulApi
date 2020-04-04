<?php

namespace App\Http\Controllers;

use App\Mail\UserCreated;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Mail;
class UserController extends ApiController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return $this->showAll($users);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password'  => 'required|min:8|confirmed',
        ];

        $validation = validator($request->all() , $rules);
        if($validation->fails()){
            return $this->errorResponse($validation->errors() , 400);
        }

        $data = $request->all();
        $data['password'] = bcrypt($request->password);
        $data['verified'] = User::UNVERIFIED_USER;
        $data['verification_token'] = User::generateVerficationCode();
        $data['admin'] = User::REGULAR_USER;
        $user = User::create($data);
       return $this->showOne($user , 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {

        return $this->showOne($user);

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
        $rules = [
            'email' => 'email|unique:users,email,' . $user->id,
            'password'  => 'min:8|confirmed',
            'admin' => 'in:'. User::ADMIN_USER . ',' . User::REGULAR_USER,
        ];


        $validation = validator($request->all() , $rules);
        if($validation->fails()){
            return $this->errorResponse($validation->errors() , 400);
        }



        if($request->has('name')){
            $user->name = $request->name;
        }
        if($request->has('email') && $user->email != $request->email){
            $user->verified = User::UNVERIFIED_USER;
            $user->verification_token = User::generateVerficationCode();
            $user->email = $request->email;
        }

        if($request->has('password')){
            $user->password = bcrypt($request->password);
        }

        if($request->has('admin')){
            if(!$user->isVerified()){
               return $this->errorResponse('only verified user can modify it' , 409);
            }

            $user->admin = $request->admin;
        }

        if(!$user->isDirty()){
            return $this->errorResponse('nothing is modified' , 422);

        }

        $user->save();
        return $this->showOne($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return $this->showOne($user);
    }

    public function verify($token){
        $user = User::where('verification_token' , $token)->firstOrFail();
        $user->verified = User::VERIFIED_USER;
        $user->save();
        return $this->showMessage('The user is successfully verified');
    }


    public function resend(User $user){
        if($user->isVerified()){
            return $this->errorResponse('User is already verified', 409);
        }

        retry(5 , function() use($user){
            Mail::to($user)->send(new UserCreated($user));
        }, 100);

        return $this->showMessage('A verification email is sent to your email address');
    }
}
