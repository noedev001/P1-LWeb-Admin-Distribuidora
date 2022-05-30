<?php

namespace Proyecto\Http\Controllers;

use Illuminate\Http\Request;
use Proyecto\Categoria;
use Proyecto\Asignar;
use Proyecto\Producto;
use Proyecto\Http\Requests\StoreCategoriaRequest;
use Proyecto\Perfil;
use Proyecto\User;

class CategoriasController extends Controller
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
              $categorias = Categoria::orderby('nombre', 'asc')->get();
            return response()->json($categorias,200);
          }
          $asignasiones  = Asignar::all();

          $perfiles = Perfil::all();
          $usuarios = User::all();
            return view('categorias.index',compact('usuarios','perfiles','asignasiones'));
        }
        else {
          $asignasiones  = Asignar::all();

          $perfiles = Perfil::all();
          $usuarios = User::all();
            return view('common.401', compact('usuarios','perfiles','asignasiones'));
        }



    }


    public function search(){

      if ($search = \Request::get('q')) {
          $categoria = Categoria::where(function($query) use ($search){
              $query->where('nombre','LIKE',"%$search%")
                      ->orWhere('descripcion','LIKE',"%$search%");
          })->get();
      }else{
          $categoria = Categoria::latest()->get();
      }

      return $categoria;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
          'nombre' => 'required|string|max:40',
          'descripcion' => 'required|string|max:220'
        ]);
        $categoria = new Categoria();
        $categoria->nombre=$request->nombre;
        $categoria->descripcion=$request->descripcion;
        $categoria->save();
        return $categoria;
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
      $categoria = Categoria::find($id);
      $categoria->nombre=$request->nombre;
      $categoria->descripcion=$request->descripcion;
      $categoria->save();
      return $categoria;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $aux = Categoria::where('id','=',$id)->get();
      foreach($aux as $row)
      {
        $idaux= $row->id;
      }



      $categoria = Categoria::find($id);
      $categoria->delete();

      $producto =  Producto::where('categoria_id','=',$idaux)->get();
      $producto->delete();

      return ['message' => 'Categoria Eliminada'];
    }
}
