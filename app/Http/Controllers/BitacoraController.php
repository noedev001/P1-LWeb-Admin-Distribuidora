<?php

namespace Proyecto\Http\Controllers;

use Illuminate\Http\Request;
use Proyecto\Asignar;
use Proyecto\Bitacora;
use Proyecto\Perfil;
use Proyecto\User;

use DB;

class BitacoraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $aux = Asignar::where('user_id','=',$request->user()->id)->get();
        foreach($aux as $row)
        {
          $rol= $row->rol_asignacion;
        }

        if($rol=="SuperAdmin" )
        {
          if($request ->ajax()){

              $bitacora = Bitacora::join('users','users.id','=','bitacoras.users_id')
              ->select('users.name', 'users.email', 'bitacoras.fecha_inicio', 'bitacoras.hora_inicio', 'bitacoras.fecha_salida', 'bitacoras.hora_salida', 'bitacoras.created_at')
              ->orderby('bitacoras.id','desc')->paginate(20);
             
              $conjunto_variables = compact('bitacora');

            return response()->json($conjunto_variables,200);
          }
          $asignasiones  = Asignar::all();

          $perfiles = Perfil::all();
          $usuarios = User::all();
            return view('bitacora.index',compact('usuarios','perfiles','asignasiones'));
        }
        else {
            $asignasiones  = Asignar::all();

            $perfiles = Perfil::all();
            $usuarios = User::all();
            return view('common.401',compact('usuarios','perfiles','asignasiones'));
        }
    }

    public function search(){

        if ($search = \Request::get('q')) {
            $users = DB::table('bitacoras')->join('users','users.id','=','bitacoras.users_id')
            ->select('users.name', 'users.email', 'bitacoras.fecha_inicio', 'bitacoras.hora_inicio', 'bitacoras.fecha_salida', 'bitacoras.hora_salida', 'bitacoras.created_at')
            ->orderby('bitacoras.id','desc')
            ->where(function($query) use ($search){
                $query->orwhere('users.name','LIKE',"%$search%");
                $query->orwhere('users.email','LIKE',"%$search%");
                $query->orwhereDate('bitacoras.fecha_inicio','LIKE',"%$search%");
                $query->orwhereDate('bitacoras.fecha_salida','LIKE',"%$search%");
                $query->orwhereYear('bitacoras.fecha_inicio','LIKE',"%$search%");
                $query->orwhereYear('bitacoras.fecha_salida','LIKE',"%$search%");
                $query->orwhereMonth('bitacoras.fecha_inicio','LIKE',"%$search%");
                $query->orwhereMonth('bitacoras.fecha_salida','LIKE',"%$search%");
                $query->orwhereDay('bitacoras.fecha_inicio','LIKE',"%$search%");
                $query->orwhereDay('bitacoras.fecha_salida','LIKE',"%$search%");
            })->paginate(20);
    
            return $users;
        }else{
          
          return Bitacora::join('users','users.id','=','bitacoras.users_id')
          ->select('users.name', 'users.email', 'bitacoras.fecha_inicio', 'bitacoras.hora_inicio', 'bitacoras.fecha_salida', 'bitacoras.hora_salida', 'bitacoras.created_at')
          ->orderby('bitacoras.id','desc')->paginate(20);
        
        }
    }


    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
