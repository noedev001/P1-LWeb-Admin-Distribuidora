<?php

namespace Proyecto\Http\Controllers;

use Illuminate\Http\Request;
use Proyecto\Cliente;
use Proyecto\Sugerencia;
use Proyecto\Asignar;
use Proyecto\Perfil;
use Proyecto\User;

use DB;

class SugerenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $aux = Asignar::where('user_id','=',$request->user()->id)->get();
        foreach($aux as $row)
        {
          $rol= $row->rol_asignacion;
        }

        if($rol=="SuperAdmin"  || $rol=="Admin" )
        {
          if($request ->ajax()){

              $sugerencias = Sugerencia::join('clientes','clientes.id','=','sugerencias.cliente_id')
              ->select('sugerencias.id','clientes.cli_nombres','clientes.cli_apellidos','clientes.cli_usuario','sugerencias.sugerencias','sugerencias.created_at')
              ->orderby('sugerencias.id','desc')->paginate(20);

              $conjunto_variables = compact('sugerencias');

            return response()->json($conjunto_variables,200);
          }
          $asignasiones  = Asignar::all();

          $perfiles = Perfil::all();
          $usuarios = User::all();
            return view('sugerencias.index',compact('usuarios','perfiles','asignasiones'));
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
            $users = DB::table('sugerencias')->join('clientes','clientes.id','=','sugerencias.cliente_id')
            ->select('sugerencias.id','clientes.cli_nombres','clientes.cli_apellidos','clientes.cli_usuario','sugerencias.sugerencias','sugerencias.created_at')
            ->orderby('sugerencias.id','desc')->where(function($query) use ($search){
                $query->orwhere('clientes.cli_nombres','LIKE',"%$search%");
                $query->orwhere('clientes.cli_usuario','LIKE',"%$search%");
                $query->orwhere('clientes.cli_apellidos','LIKE',"%$search%");
                $query->orwhere('sugerencias.sugerencias','LIKE',"%$search%");
                $query->orwhere('sugerencias.created_at','LIKE',"%$search%");
            })->paginate(20);
    
            return $users;
        }else{
          
          return Sugerencia::join('clientes','clientes.id','=','sugerencias.cliente_id')
          ->select('sugerencias.id','clientes.cli_nombres','clientes.cli_apellidos','clientes.cli_usuario','sugerencias.sugerencias','sugerencias.created_at')
          ->orderby('sugerencias.id','desc')->paginate(20);
        
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        $sugerencias = Sugerencia::findOrFail($id);
        $sugerencias->delete();

        return ['message' => 'Sugerencia Eliminada'];
    }
}
