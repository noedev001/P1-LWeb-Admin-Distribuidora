<?php

namespace Proyecto\Http\Controllers;

use Illuminate\Http\Request;
use Proyecto\Asignar;
use Proyecto\Producto;
use Proyecto\Inventario;
use Proyecto\SalidaInventario;
use Proyecto\Bitacora;
use Proyecto\Cliente;
use Proyecto\Mensaje;
use Proyecto\Sugerencia;
use Proyecto\Deposito;
use Proyecto\Oferta;
use Proyecto\Perfil;
use Proyecto\User;
use Proyecto\Pedido;
use Proyecto\Aviso;

use DB;

class HomeController extends Controller
{
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
   * Show the application dashboard.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function index(Request $request)
  {

    $aux = Asignar::where('user_id', '=', $request->user()->id)->get();
    foreach ($aux as $row) {
      $rol = $row->rol_asignacion;
    }

    if ($rol == "SuperAdmin"  || $rol == "Admin"  || $rol == "Dist") {
      if ($request->ajax()) {

        $venta = SalidaInventario::join('inventarios', 'inventarios.id', '=', 'salida_inventarios.inventario_id')
          ->join('productos', 'productos.id', '=', 'inventarios.producto_id')
          ->select('productos.nombre', 'productos.marca', 'productos.avatar', 'salida_inventarios.cantidad_unidad', 'salida_inventarios.precio_venta_unidad')
          ->orderby('salida_inventarios.id', 'desc')->take(1)->get();



        $equipo = Bitacora::join('users', 'users.id', '=', 'bitacoras.users_id')
          ->join('perfils', 'perfils.user_id', '=', 'users.id')
          ->where('bitacoras.fecha_salida', '=', '0000-00-00')->where('bitacoras.hora_salida', '=', '00:00:00')->where('users.id', '<>', $request->user()->id)
          ->select('users.name', 'users.email', 'perfils.avatar', 'bitacoras.created_at')
          ->distinct('users.id')
          ->orderby('bitacoras.fecha_inicio', 'desc')->orderby('bitacoras.hora_inicio', 'desc')->get();
        //->take(3)

        $cliente = Cliente::select(DB::raw('count(*) as clientes'))
          ->get();

        $datos = Cliente::join('dato_clientes', 'dato_clientes.cliente_id', '=', 'clientes.id')
          ->join('pedidos', 'pedidos.cliente_id', '=', 'clientes.id')
          ->where('pedidos.estatus', '=', 'Entregado')
          ->orwhere('pedidos.estatus', '=', 'Cancelado')
          ->select('clientes.cli_usuario', 'clientes.cli_nombres', 'clientes.cli_apellidos', 'clientes.cli_celular', 'dato_clientes.foto')
          ->orderby('pedidos.id', 'desc')->take(1)->get();




        //------------------WEB NOTIFICACION-------------

        $sugerencia = Sugerencia::join('clientes', 'clientes.id', '=', 'sugerencias.cliente_id')
          ->join('dato_clientes', 'dato_clientes.cliente_id', '=', 'clientes.id')
          ->where('sugerencias.status', '=', 'No')
          ->select('sugerencias.id', 'clientes.cli_nombres', 'clientes.cli_apellidos', 'sugerencias.created_at', 'dato_clientes.foto')
          ->get();


        $depositos = Deposito::join('clientes', 'clientes.id', '=', 'depositos.cliente_id')
          ->join('dato_clientes', 'dato_clientes.cliente_id', '=', 'clientes.id')
          ->where('depositos.estado', '=', 'NoVerificado')
          ->select('clientes.cli_nombres', 'clientes.cli_apellidos', 'depositos.fecha', 'dato_clientes.foto', 'depositos.monto', 'dato_clientes.user_id')
          ->orderby('depositos.fecha', 'desc')
          ->get();


        $oferta = Oferta::join('inventarios', 'inventarios.id', '=', 'ofertas.inventario_id')
          ->join('productos', 'productos.id', '=', 'inventarios.producto_id')
          ->select('productos.nombre', 'productos.marca', 'ofertas.oferta', 'ofertas.fecha')
          ->where('ofertas.status', '=', 'Disponible')
          ->get();


        $productos = Inventario::join('productos', 'productos.id', '=', 'inventarios.producto_id')
          ->join('saldo_inventarios', 'saldo_inventarios.inventario_id', '=', 'inventarios.id')
          ->select(DB::raw('productos.nombre, productos.marca, round(((inventarios.cantidad_unidad_almacen_dis/saldo_inventarios.cantidad_total)*100),2) as promedio'))
          ->where('saldo_inventarios.status', '=', 'Inicio')
          ->whereRaw('((inventarios.cantidad_unidad_almacen_dis/saldo_inventarios.cantidad_total)*100) <100')
          ->get();

        $pedido = Pedido::join('clientes', 'clientes.id', '=', 'pedidos.cliente_id')
          ->join('dato_clientes', 'dato_clientes.cliente_id', '=', 'clientes.id')
          ->where('pedidos.estatus', '=', 'PedidoHecho')
          ->groupBy('pedidos.fecha_compra', 'pedidos.cliente_id', 'pedidos.estatus')
          ->orderby('pedidos.fecha_compra', 'desc')
          ->select(DB::raw('count(*) as cantidadproductos, clientes.cli_nombres,clientes.cli_apellidos, dato_clientes.foto , pedidos.fecha_compra'))
          ->get();

        $asignar  = Asignar::all();
        $usuarios = User::all();
        $iduser = $request->user()->id;

        $roles = Asignar::where('user_id', '=', $request->user()->id)->select('rol_asignacion')->get();

        foreach ($roles as $aux) {
          $rol = $aux->rol_asignacion;
        }



        $clientes = Cliente::orderby('cli_nombres', 'asc')->paginate(6);


        $conjunto_variables = compact('venta', 'equipo', 'cliente', 'datos', 'sugerencia', 'depositos', 'oferta', 'productos', 'pedido', 'usuarios', 'asignar', 'iduser', 'rol', 'clientes');


        return response()->json($conjunto_variables, 200);
      }
      $asignasiones  = Asignar::all();
      $perfiles = Perfil::all();
      $usuarios = User::all();
      $iduser = $request->user()->id;
      return view('home', compact('usuarios', 'perfiles', 'asignasiones', 'iduser'));
      //return view('home')->with('usuarios', $usuarios)->with('perfiles', $perfiles)->with('asignasiones', $asignasiones);
    } else {
      return view('common.401');
    }
  }



  public function mensajes(Request $request)
  {

    if ($request->aviso != '') {
      if ($request->cliente == '4') {
        $aviso = new Aviso();
        $aviso->aviso = $request->aviso;
        $aviso->fecha = $request->fecha;
        $aviso->cliente_id = $request->cliente_id;
        $aviso->user_id = $request->user()->id;
        $aviso->save();

        $send =  Cliente::join('tokes', 'tokes.cliente_id', '=', 'clientes.id')
          ->select('clientes.id', 'clientes.cli_usuario', 'tokes.tokens')
          ->where('clientes.id', '=', $request->cliente_id)
          ->orderby('clientes.id', 'asc')->get();


        $titulo = 'Distribuidora E&E';



        $descripcion = $request->aviso;


        $tipo = 'Notificacion';

        $data = array(
          'title'  => '' . $titulo . '',
          'body'   => '' . $descripcion . '',

        );


        foreach ($send as $w) {

          $extra = array(
            'tipo'  => '' . $tipo . '',
            'email'   => '' . $w->cli_usuario . '',
          );



          $this->sendNotyfication($data, $w->tokens, $extra);
        }
      }

      if ($request->cliente == '1') {

        $send =  Cliente::join('tokes', 'tokes.cliente_id', '=', 'clientes.id')
          ->select('clientes.id', 'clientes.cli_usuario', 'tokes.tokens')
          ->orderby('clientes.id', 'asc')->get();


        $titulo = 'Distribuidora E&E';



        $descripcion = $request->aviso;


        $tipo = 'Notificacion';

        $data = array(
          'title'  => '' . $titulo . '',
          'body'   => '' . $descripcion . '',

        );


        foreach ($send as $w) {

          $extra = array(
            'tipo'  => '' . $tipo . '',
            'email'   => '' . $w->cli_usuario . '',
          );



          $this->sendNotyfication($data, $w->tokens, $extra);



          $aviso = new Aviso();
          $aviso->aviso = $request->aviso;
          $aviso->fecha = $request->fecha;
          $aviso->cliente_id = $w->id;
          $aviso->user_id = $request->user()->id;
          $aviso->save();
        }
      }
    }



    return 'Aviso enviado correctamente';
  }


  public static function sendNotyfication($data, $tokens, $extra)
  {

    $api_key = "AAAAHrS3BTE:APA91bGABkoznJoYau5UU8jetELfybVkoxiN8iR0ChIEsUXxXX8TyIo4xGDcUvlxdoSOuGDc1FNwkx9ybKiSmmAuwfMtaaNR2oZRv-6L5KAqyuxzuOzFYBex1gbqI8zkp4aOUBpQ4-xu";
    $url = "https://fcm.googleapis.com/fcm/send";
    $field = json_encode(array('to' => $tokens, 'notification' => $data, 'data' => $extra));

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, ($field));

    $headers = array();
    $headers[] = 'Authorization: key=' . $api_key;
    $headers[] = 'Content-Type: application/json';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
    if (curl_errno($ch)) {
      echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);
  }
}
