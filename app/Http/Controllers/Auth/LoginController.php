<?php

namespace Proyecto\Http\Controllers\Auth;

use Illuminate\Http\Request;

use Proyecto\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Proyecto\Bitacora;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

   
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            $this->bitacorainicio($request);
            return $this->sendLoginResponse($request);
        }


        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }


    public function logout(Request $request)
    {
        $this->bitacorafinalizar($request);
        $this->guard()->logout();

        $request->session()->invalidate();

        

        return $this->loggedOut($request) ?: redirect('/');
    }


    public static function bitacorainicio(Request $request){

        $bita= new bitacora();
        //$fecha = date('Y-m-d H:i:s');
        $fechai=date('Y-m-d');
        $horai=date('H:i:s');
        $fechas='0000-00-00';
        $horas='00:00:00';
        $bita->fecha_inicio=$fechai;
        $bita->hora_inicio=$horai;
        $bita->fecha_salida=$fechas;
        $bita->hora_salida=$horas;
        $bita->users_id=$request->user()->id;
        $bita->save();
        return $bita;
    }

    public static function bitacorafinalizar(Request $request){


        $aux = Bitacora::where('users_id','=',$request->user()->id)->where('fecha_salida','=','0000-00-00')->where('hora_salida','=','00:00:00')->orderby('id', 'desc')->take(1)->get();
        foreach($aux as $row)
        {
            $idaux= $row->id;
        }
        $bita= Bitacora::find($idaux);

        //$fecha = date('Y-m-d H:i:s');
        $fechas=date('Y-m-d');
        $horas=date('H:i:s');

        $bita->fecha_salida=$fechas;
        $bita->hora_salida=$horas;

        $bita->save();
        return $bita;
    }
}
