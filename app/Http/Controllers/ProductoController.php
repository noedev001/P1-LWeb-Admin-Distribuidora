<?php

namespace Proyecto\Http\Controllers;

use Illuminate\Http\Request;
use Proyecto\Producto;
use Proyecto\Categoria;
use Proyecto\Asignar;
use Proyecto\Perfil;
use Proyecto\User;

class ProductoController extends Controller
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
    $aux = Asignar::where('user_id', '=', $request->user()->id)->get();
    foreach ($aux as $row) {
      $rol = $row->rol_asignacion;
    }

    if ($rol == "SuperAdmin"  || $rol == "Admin") {

      if ($request->ajax()) {


        $categorias = Categoria::orderby('nombre', 'asc')->paginate(1000);

        $cat = Categoria::orderby('nombre', 'asc')->paginate(6);

        $productos = Producto::orderby('id', 'desc')->paginate(1000);

        $conjunto_variables = compact('categorias', 'productos', 'cat');

        return response()->json($conjunto_variables, 200);
      }
      $asignasiones  = Asignar::all();

      $perfiles = Perfil::all();
      $usuarios = User::all();
      return view('productos.index', compact('usuarios', 'perfiles', 'asignasiones'));
    } else {
      $asignasiones  = Asignar::all();

      $perfiles = Perfil::all();
      $usuarios = User::all();
      return view('common.401', compact('usuarios', 'perfiles', 'asignasiones'));
    }
  }


  public function search()
  {

    if ($search = \Request::get('q')) {
      $productos = Producto::where(function ($query) use ($search) {
        $query->where('nombre', 'LIKE', "%$search%")
          ->orWhere('marca', 'LIKE', "%$search%")
          ->orWhere('modelo', 'LIKE', "%$search%")
          ->orWhere('marca', 'LIKE', "%$search%")
          ->orWhere('descripcion', 'LIKE', "%$search%");
      })->paginate(1000);
    } else {
      $productos = Producto::latest()->paginate(1000);
    }

    return $productos;
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

    $this->validate($request, [
      'categoria_id' => 'required',
      'nombre' => 'required|string|max:40',
      'marca' => 'required|string',
    ]);

    $name = '';

    if ($request->hasFile('file')) {
      $file = $request->file('file');
      $name = time() . $file->getClientOriginalName();

      $file->move(public_path() . '/images/product/', $name);
      //$file->move(public_path().'/images/product/',$name);
    }

    $producto = new Producto();
    $producto->nombre = $request->nombre;
    $producto->marca = $request->marca;
    $producto->modelo = $request->modelo;
    $producto->medida = $request->medida;
    $producto->serie = $request->serie;
    $producto->descripcion = $request->descripcion;
    $producto->nota = $request->nota;
    $producto->avatar = $name;
    $producto->avatarurl = 'http://192.168.100.127/proyectofinal/PROYECTO/public/images/product/' . $name;
    $producto->categoria_id = $request->categoria_id;
    $producto->save();

    //dd($producto);
    return $producto;
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
  }


  public function updateProducto(Request $request)
  {
    $producto = Producto::find($request->id);

    if ($request->hasFile('file')) {
      $file = $request->file('file');
      $name = time() . $file->getClientOriginalName();
      $file->move(public_path() . '/images/product/', $name);

      $file_path = public_path() . '/images/product/' . $request->avatar;
      \File::delete($file_path);
      $producto->avatar = $name;
      $producto->avatarurl = 'http://192.168.100.127/proyectofinal/PROYECTO/public/images/product/' . $name;
    }

    $producto->nombre = $request->nombre;
    $producto->marca = $request->marca;
    $producto->modelo = $request->modelo;
    $producto->medida = $request->medida;
    $producto->serie = $request->serie;
    $producto->descripcion = $request->descripcion;
    $producto->nota = $request->nota;
    $producto->categoria_id = $request->categoria_id;
    $producto->save();
    return $producto;
    //dd($request->id);

    //return $request->id;
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $producto = Producto::findOrFail($id);

    $file_path = public_path() . '/images/product/' . $producto->avatar;
    \File::delete($file_path);

    $producto->delete();
    return ['message' => 'Usuarios Eliminados'];
  }
}
