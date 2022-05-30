<?php

namespace Proyecto\Http\Controllers;

use Illuminate\Http\Request;
use Proyecto\User;
use Proyecto\Asignar;
use Proyecto\Sucursal;
use Proyecto\Categoria;
use Proyecto\Perfil;





class UsersController extends Controller
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

            $asignasiones  = Asignar::all();


            $perfiles = Perfil::all();

            $usuarios = User::orderby('id', 'desc')->paginate(6);

            $conjunto_variables = compact('usuarios','perfiles','asignasiones');

            return response()->json($conjunto_variables,200);

          }
            $asignasiones  = Asignar::all();

            $perfiles = Perfil::all();
            $usuarios = User::all();
            return view('users.index',compact('usuarios','perfiles','asignasiones'));
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
          $users = User::where(function($query) use ($search){
              $query->where('name','LIKE',"%$search%")
                      ->orWhere('email','LIKE',"%$search%");
          })->paginate(6);
      }else{
          $users = User::latest()->paginate(6);
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

      $asignar = Asignar::find($request->asignar_id);
      $asignar->rol_asignacion=$request->role;
      $asignar->save();
      return $asignar;



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
      $user = User::find($id);
      $user->name=$request->name;

      $user->save();
      //return $user;

      $aux = Perfil::where('user_id','=',$id)->get();

      foreach($aux as $row)
      {
        $id1 = $row->id;
      }

      //dd($id1);
      $perfil = Perfil::find($id1);
      $perfil->apellido=$request->apellido;
      $perfil->direccion=$request->direccion;
      $perfil->celular=$request->celular;
      $perfil->save();

      return $user;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $user = User::findOrFail($id);
      $user->delete();

      $asignar = Asignar::where('user_id','=',$id);
      $asignar->delete();

      $perfil = Perfil::where('user_id','=',$id);
      $file_path = public_path().'/images/profile/'.$perfil->avatar;
      \File::delete($file_path);
      $perfil->delete();
      return ['message' => 'Usuarios Eliminados'];
    }


    public function imagenPerfil(Request $request)
    {
      $perfil = Perfil::find($request->id);


       if($request->hasFile('file')){
         $file=$request->file('file');
         $name=time().$file->getClientOriginalName();
         $file->move(public_path().'/images/profile/',$name);

       }

         $file_path = public_path().'/images/profile/'.$request->avatar;
         \File::delete($file_path);


       $perfil->avatar=$name;
       $perfil->save();

       //dd($perfil);
       return $perfil;

    }




}
