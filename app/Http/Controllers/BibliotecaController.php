<?php

namespace Proyecto\Http\Controllers;

use Illuminate\Http\Request;

use Proyecto\Producto;
use Proyecto\Asignar;
use Proyecto\Biblioteca;
use Proyecto\Categoria;
use Proyecto\Perfil;
use Proyecto\User;
use DB;

class BibliotecaController extends Controller
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

      if($rol=="SuperAdmin"  || $rol=="Admin" || $rol=="Dist" )
      {

        if($request ->ajax()){


          $productos = Producto::orderby('nombre', 'asc')->get();
          $categorias =  Categoria::orderby('nombre', 'asc')->paginate(12);

          $biblioteca = Biblioteca::orderby('id', 'desc')->get();

          $conjunto_variables = compact('biblioteca','productos','categorias');

          return response()->json($conjunto_variables,200);

        }
          $asignasiones  = Asignar::all();

          $perfiles = Perfil::all();
          $usuarios = User::all();
          return view('biblioteca.index' ,compact('usuarios','perfiles','asignasiones'));

        }
        else {
            return view('common.401');
        }
    }


    public function search(){

      if ($search = \Request::get('q')) {


          $users = DB::table('productos')->join('bibliotecas', 'productos.id', '=', 'bibliotecas.productos_id')
          ->select('bibliotecas.id','bibliotecas.avatar', 'bibliotecas.productos_id')->where(function($query) use ($search){
              $query->where('nombre','LIKE',"%$search%");
          })->paginate(20);
      }else{
          $users = Biblioteca::latest()->paginate(20);
      }

      return $users;

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
      $biblio = new Biblioteca();
      if($request->hasFile('file')){
        $file=$request->file('file');
        $name=time().$file->getClientOriginalName();
        $file->move(public_path().'/images/product/biblio/',$name);
      }
      $biblio->avatar=$name;
      $biblio->avatarurl='http://192.168.100.127/proyectofinal/PROYECTO/public/images/product/biblio/'.$name;
      $biblio->productos_id=$request->id_producto;
      $biblio->save();

      //dd($perfil);
      return $biblio;
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
      $biblio = Biblioteca::findOrFail($id);

      $file_path = public_path().'/images/product/biblio/'.$biblio->avatar;
      \File::delete($file_path);
      $biblio->delete();



      return ['message' => 'Usuarios Eliminados'];
    }
}
