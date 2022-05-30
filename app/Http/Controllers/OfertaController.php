<?php

namespace Proyecto\Http\Controllers;

use Illuminate\Http\Request;

use Proyecto\Inventario;
use Proyecto\Producto;
use Proyecto\Asignar;
use Proyecto\Oferta;
use Proyecto\Perfil;
use Proyecto\User;
use Proyecto\Cliente;
use Proyecto\Mensaje;
use DB;

class OfertaController extends Controller
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

          $productos  = Producto::all();
          $inventarios =  Inventario::All();
          $ofertas = Oferta::join('inventarios','inventarios.id','=','ofertas.inventario_id')
                            ->join('productos','productos.id','=','inventarios.producto_id')
                            ->select("ofertas.id as oferta_id","productos.nombre", "productos.marca", "productos.modelo", "productos.medida", "productos.avatar", "ofertas.precio_venta_nuevo", "ofertas.cantidad_unidadxcaja",
                            "ofertas.unidad_almacen", "ofertas.caja_almacen", "ofertas.unidad_disponible", "ofertas.caja_disponible", "ofertas.oferta",
                            "ofertas.status","ofertas.fecha", "inventarios.id as inventario_id")
                            ->orwhere("ofertas.status",'=','Disponible')
                            ->orderby('ofertas.id', 'desc')
                            ->paginate(6);


          $asignar  = Asignar::all();

          $iduser = $request->user()->id;

          $conjunto_variables = compact('ofertas','inventarios','productos', 'asignar','iduser');

          return response()->json($conjunto_variables,200);

        }
        $ofertas = Oferta::all();
        $asignasiones  = Asignar::all();

          $perfiles = Perfil::all();
          $usuarios = User::all();
          return view('ofertas.index',compact('usuarios','perfiles','asignasiones'));
        }
        else {
            return view('common.401');
        }
    }


    public function search(){

      if ($search = \Request::get('q')) {


          $users = DB::table('inventarios')->join('productos', 'productos.id', '=', 'inventarios.producto_id')
          ->join('categorias', 'categorias.id', '=', 'productos.categoria_id')
          ->select('inventarios.id','inventarios.producto_id','inventarios.cantidad_unidad_caja','inventarios.cantidad_unidad_almacen',
          'inventarios.cantidad_caja_almacen','inventarios.cantidad_unidad_almacen_dis','inventarios.cantidad_caja_almacen_dis',
          'inventarios.precio_compra_unidad','inventarios.precio_venta_unidad','inventarios.fecha_vencimiento')
          ->where(function($query) use ($search){
              $query->where('productos.nombre','LIKE',"%$search%")
              ->orwhere('productos.marca','LIKE',"%$search%")
              ->orwhere('categorias.nombre','LIKE',"%$search%")
              ->orwhere('inventarios.fecha_vencimiento','LIKE',"%$search%");
          })->paginate(20);
      }else{
          $users = inventario::latest()->paginate(20);
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
      
    }

 
    
    public function show($id)
    {
        //
    }

   
    
    public function edit($id)
    {
        //
    }

   
    
    public function update(Request $request, $id)
    {
      //dd($request);
      $regInventario = Oferta::findOrFail($id);
      $regInventario->status='NoDisponible';
      $regInventario->save();
    }



    public function destroy($id)
    {
      $aux = Oferta::where('id','=',$id)->get();

      foreach($aux as $row)
      {
        $id_inventario = $row->inventario_id;
        $cua = $row->unidad_disponible;
        $cca = $row->caja_disponible;
      }


      $auxInv = Inventario::where('id','=',$id_inventario)->get();

      foreach($auxInv as $row)
      {
        $cua1 = $row->cantidad_unidad_almacen_dis;
        $cca1 = $row->cantidad_caja_almacen_dis;
      }

      $aux1=$cua + $cua1;
      $aux2=$cca + $cca1;

      $inventario = Inventario::findOrFail($id_inventario);
      $inventario->cantidad_unidad_almacen_dis=$aux1;
      $inventario->cantidad_caja_almacen_dis=$aux2;
      $inventario->status='Disponible';
      $inventario->save();


      $oferta = Oferta::findOrFail($id);
      $oferta->delete();

      return ['message' => 'Oferta Eliminada'];
    }

    public  function notificarClienteOfe(Request $request){
          
      $send =  Cliente::join('tokes','tokes.cliente_id','=','clientes.id')
      ->select('clientes.id','clientes.cli_usuario','tokes.tokens')
      ->orderby('clientes.id', 'asc')->get();

      

      $titulo=$request->titulo.' - '.$request->fecha;

      $inv=Inventario::findOrFail($request->id);

      $productos = Producto::findOrFail($inv->producto_id);
     
      $descripcion = $productos->nombre.' - '.$productos->marca;

      
      $imagen=$productos->avatarurl;
      
      $tipo='Productos';
   
      $data=array(
        'title'  => ''.$titulo.'',
        'body'   => ''.$descripcion.'',
        'image'   => ''.$imagen.'',
      );
      
      
      foreach($send as $w)
      {

        $extra=array(
          'tipo'  => ''.$tipo.'',
          'email'   => ''.$w->cli_usuario.'',
          'imagen'   => ''.$imagen.'',
        );
        

        
        $this->sendNotyfication1($data, $w->tokens, $extra);


        $noti = new Mensaje();
        $noti->tipo=$tipo;
        $noti->titulo=$titulo;
        $noti->mensaje=$descripcion;
        $noti->imagen=$imagen;
        $noti->cliente_id=$w->id;
        $noti->save();


      }

    }

    public static function sendNotyfication1($data,$tokens, $extra){

      $api_key="AAAAHrS3BTE:APA91bGABkoznJoYau5UU8jetELfybVkoxiN8iR0ChIEsUXxXX8TyIo4xGDcUvlxdoSOuGDc1FNwkx9ybKiSmmAuwfMtaaNR2oZRv-6L5KAqyuxzuOzFYBex1gbqI8zkp4aOUBpQ4-xu";
      $url="https://fcm.googleapis.com/fcm/send";
      $field=json_encode(array('to'=>$tokens, 'notification'=>$data, 'data'=>$extra));
  
      $ch = curl_init();
  
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, ($field));
  
      $headers = array();
      $headers[] = 'Authorization: key='.$api_key;
      $headers[] = 'Content-Type: application/json';
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  
      $result = curl_exec($ch);
      if (curl_errno($ch)) {
          echo 'Error:' . curl_error($ch);
      }
      curl_close($ch);
  
    }
  
}
