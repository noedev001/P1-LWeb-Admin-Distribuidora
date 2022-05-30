<?php

namespace Proyecto\Http\Controllers\Auth;

use Proyecto\User;
use Proyecto\Asignar;
use Proyecto\Perfil;
use Proyecto\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;



class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    //protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \Proyecto\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $us = User::where('email','=',$data['email'])->get();
        foreach($us as $row)
        {
          $perfil = new Perfil();
          $perfil->user_id=$row->id;
          $perfil->save();

          $asignar = new Asignar();
          $asignar->user_id=$row->id;
          $asignar->save();
        }


        return $user;


    }

    public function guardar(Request $request)
    {
        //dd($request->input('roles'));

        //$this->validator($request->all())->validate();
       $user = new User;
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt( $request->input('password') );
        $user->save();

        $us = User::where('email','=',$request['email'])->get();
        foreach($us as $row)
        {
          $perfil = new Perfil();
          $perfil->user_id=$row->id;
          $perfil->save();

          $asignar = new Asignar();
          $asignar->user_id=$row->id;
          $asignar->rol_asignacion=$request->input('roles');
          $asignar->save();
        }

        $asignasiones  = Asignar::all();
        $perfiles = Perfil::all();
        $usuarios = User::all();
        
        return view('home',compact('usuarios','perfiles','asignasiones'));
    }
}
