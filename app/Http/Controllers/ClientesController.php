<?php

namespace Proyecto\Http\Controllers;

use Illuminate\Http\Request;
use Proyecto\Cliente;
use Proyecto\Asignar;
use Proyecto\DatoCliente;
use Proyecto\Perfil;
use Proyecto\User;

use DB;

class ClientesController extends Controller
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

        if($rol=="SuperAdmin"  || $rol=="Admin" || $rol=="Dist" )
        {
          if($request ->ajax()){

              $clientes = Cliente::join('dato_clientes','dato_clientes.cliente_id','=','clientes.id')
              ->select('clientes.id','clientes.cli_nombres','clientes.cli_apellidos','clientes.cli_usuario','dato_clientes.ci','clientes.cli_celular','dato_clientes.direccion', 'dato_clientes.user_id', 'dato_clientes.id as iddato')   
              ->orderby('dato_clientes.user_id','asc')
              ->orderby('clientes.cli_nombres','desc')->paginate(20);

            $asignar  = Asignar::all();
            $usuarios = User::all();
            $iduser = $request->user()->id;

            $roles = Asignar::where('user_id','=',$request->user()->id)->select('rol_asignacion')->get();

            foreach($roles as $aux){
                $rol=$aux->rol_asignacion;
            }

            $conjunto_variables = compact('clientes', 'usuarios','asignar','iduser','rol');



            return response()->json($conjunto_variables,200);
          }
          $asignasiones  = Asignar::all();

          $perfiles = Perfil::all();
          $usuarios = User::all();
            return view('clientes.index',compact('usuarios','perfiles','asignasiones'));
        }
        else {
            return view('common.401');
        }
    }


    
    public function search(){

        if ($search = \Request::get('q')) {
            $users = DB::table('clientes')->join('dato_clientes','dato_clientes.cliente_id','=','clientes.id')
            ->select('clientes.id','clientes.cli_nombres','clientes.cli_apellidos','clientes.cli_usuario','dato_clientes.ci','clientes.cli_celular','dato_clientes.direccion')
            ->orderby('clientes.cli_nombres','desc')->where(function($query) use ($search){
                $query->orwhere('clientes.cli_nombres','LIKE',"%$search%");
                $query->orwhere('clientes.cli_usuario','LIKE',"%$search%");
                $query->orwhere('clientes.cli_apellidos','LIKE',"%$search%");
                $query->orwhere('clientes.cli_celular','LIKE',"%$search%");
                $query->orwhere('dato_clientes.ci','LIKE',"%$search%");
            })->paginate(20);
    
            return $users;
        }else{
          
          return Cliente::join('dato_clientes','dato_clientes.cliente_id','=','clientes.id')
          ->select('clientes.id','clientes.cli_nombres','clientes.cli_apellidos','clientes.cli_usuario','dato_clientes.ci','clientes.cli_celular','dato_clientes.direccion')
          ->orderby('clientes.cli_nombres','desc')->paginate(20);
        
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
        $dato = DatoCliente::findOrFail($request->dato_id);

        $dato->user_id=$request->user_id;
        $dato->save();
        return $dato;

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
