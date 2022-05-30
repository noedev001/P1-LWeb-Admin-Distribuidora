<?php

namespace Proyecto\Http\Controllers;

use Illuminate\Http\Request;

use Proyecto\Asignar;
use Proyecto\Deposito;
use Proyecto\Cliente;
use Proyecto\Pedido;
use Proyecto\Inventario;
use Proyecto\Producto;
use Proyecto\Pago;
use Proyecto\Cuota;
use Proyecto\Mensaje;
use Proyecto\Perfil;
use Proyecto\User;


use DB;



class CuentaController extends Controller
{
  public function index(Request $request)
  {
    $aux = Asignar::where('user_id','=',$request->user()->id)->get();
    foreach($aux as $row)
    {
      $rol= $row->rol_asignacion;
    }

    if($rol=="SuperAdmin"  || $rol=="Admin" || $rol=="Dist" )
    {

      if($request ->ajax())
      {
          $clientesDeposito = Cliente::join('depositos','depositos.cliente_id','=','clientes.id')
                                      ->join('dato_clientes','dato_clientes.cliente_id','=','clientes.id')
                                      ->orwhere('depositos.estado','=','NoVerificado')
                                      ->groupBy('clientes.id')
                                      ->select('clientes.id','clientes.cli_nombres','clientes.cli_apellidos', 'clientes.cli_usuario','depositos.estado' , 'dato_clientes.user_id')
                                      ->get();
          $clientesDepositoVerificado = Cliente::join('depositos','depositos.cliente_id','=','clientes.id')
                                      ->join('dato_clientes','dato_clientes.cliente_id','=','clientes.id')
                                      ->orwhere('depositos.estado','=','Verificado')
                                      ->groupBy('clientes.id')
                                      ->select('clientes.id','clientes.cli_nombres','clientes.cli_apellidos','clientes.cli_usuario','depositos.estado', 'dato_clientes.user_id')
                                      ->paginate(12);

          $depositos = Deposito::orderby('estado','asc')->get();

          $clientesPago = Cliente::join('pedidos','pedidos.cliente_id','=','clientes.id')
                                    ->join('dato_clientes','dato_clientes.cliente_id','=','clientes.id')
                                    ->orwhere('pedidos.estatus','=','Entregado')
                                    ->groupBy('pedidos.fecha_entrega')
                                    ->orderby('pedidos.fecha_entrega','desc')
                                    ->select('clientes.id','clientes.cli_usuario','clientes.cli_nombres','clientes.cli_apellidos','pedidos.fecha_entrega' , 'dato_clientes.user_id')
                                    ->paginate(12);

          $idpagocliente = Pedido::where('estatus','=',"Entregado")
                                    ->select('cliente_id', 'fecha_entrega')
                                    ->orderby('id', 'desc')->take(1)
                                    ->get();

          $iddepositocliente = Deposito::where('estado','=',"Verificado")
                                    ->select('cliente_id')
                                    ->orderby('id', 'desc')->take(1)
                                    ->get();                          

          $pedidos =  Pedido::where('estatus','=',"Entregado")->orderby('id', 'desc')->get();

          $detallepedido = Pedido::where('estatus','=',"Entregado")->with("inventarios")->orderby('id', 'desc')->get();

          $inventarios =  Inventario::All();

          $productos = Producto::All();

          $clientes = Cliente::orderby('cli_nombres', 'asc')->get();

          $clientesDepo = Cliente::orderby('cli_nombres', 'asc')->paginate(6);

          $cuotas = Cuota::All();

          $precioTotal = Pedido::where('estatus','=',"Entregado")
          ->groupBy('fecha_entrega','cliente_id','estatus')
          ->orderby('fecha_entrega', 'desc')
          ->select(DB::raw('count(*) as CantidadProductos, round(IFNULL( SUM(precio_total),0),2) as PrecioTotal, cliente_id,estatus,fecha_entrega'))
          ->get();

          $pagos = Pago::All();

          $saldos = Pago::where('status','=','deuda')
          ->groupBy('fecha_entrega')
          ->select(DB::raw(' round(IFNULL( SUM(monto),0),2) as SaldoPagados, cliente_id,fecha_entrega'))
          ->get();

          $fecha = date('Y-m-d H:i:s');
          $fechaproximo = Cuota::where('fecha_entrega','>=',$fecha)->orderby('fecha_entrega','desc')->get();

          $asignar  = Asignar::all();
            $usuarios = User::all();
            $iduser = $request->user()->id;

            $roles = Asignar::where('user_id','=',$request->user()->id)->select('rol_asignacion')->get();

            foreach($roles as $aux){
                $rol=$aux->rol_asignacion;
            }

          $conjunto_variables = compact('clientesDeposito','depositos', 'clientesPago', 'pedidos', 'detallepedido', 'inventarios', 'productos', 'clientes', 'precioTotal', 'pagos', 'saldos',
                                    'idpagocliente', 'clientesDepo', 'clientesDepositoVerificado','iddepositocliente','cuotas','fechaproximo' , 'usuarios','asignar','iduser','rol');

          return response()->json($conjunto_variables,200);

      }
          $asignasiones  = Asignar::all();
          $perfiles = Perfil::all();
          $usuarios = User::all();
        return view('cuentas.index',compact('usuarios','perfiles','asignasiones'));
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
        $users = DB::table('clientes')->join('pedidos','pedidos.cliente_id','=','clientes.id')
        ->orwhere('pedidos.estatus','=','Entregado')
        ->groupBy('pedidos.fecha_entrega')
        ->orderby('pedidos.fecha_entrega','desc')
        ->select('clientes.id','clientes.cli_usuario','clientes.cli_nombres','clientes.cli_apellidos','pedidos.fecha_entrega')->where(function($query) use ($search){
            $query->orwhere('clientes.cli_nombres','LIKE',"%$search%");
            $query->orwhere('clientes.cli_usuario','LIKE',"%$search%");
            $query->orwhere('clientes.cli_apellidos','LIKE',"%$search%");
            $query->orwhere('pedidos.fecha_entrega','LIKE',"%$search%");
        })->paginate(20);

        return $users;
    }else{
      
      return Cliente::join('pedidos','pedidos.cliente_id','=','clientes.id')
      ->orwhere('pedidos.estatus','=','Entregado')
      ->groupBy('pedidos.fecha_entrega')
      ->orderby('pedidos.fecha_entrega','desc')
      ->select('clientes.id','clientes.cli_usuario','clientes.cli_nombres','clientes.cli_apellidos','pedidos.fecha_entrega')
      ->paginate(6);
    
    }
}


  public function store(Request $request)
  {
 
    if(0 < ($request->faltante - $request->monto)){
      if($request->forma_pago=="Deposito"){
          $deposito = Deposito::findOrFail($request->deposito_id);
          $deposito->estado='Verificado';
          $deposito->save();

          $fecha_pedosito=$deposito->fecha;

      }


        $pagos = new Pago();
        $fecha = date('Y-m-d H:i:s');
        $pagos->forma_pago=$request->forma_pago;
        $pagos->fecha_pago=$fecha;
        $pagos->monto=$request->monto;
        $pagos->foto_pago=$request->foto;
        if($request->forma_pago=="Deposito"){
            $pagos->foto_url='http://192.168.100.127/proyectofinal/PROYECTO/public/images/pagos/'.$request->foto;
        }else {
          $pagos->foto_url;
        }

        $pagos->fecha_entrega=$request->fecha_entrega;
        $pagos->fecha_deposito=$request->fecha_deposito;
        $pagos->status='deuda';
        $pagos->cliente_id=$request->cliente_id;
        $pagos->save();


        //---------NOTIFICACIONES ---------------------------------------------

        $send =  Cliente::join('tokes','tokes.cliente_id','=','clientes.id')
        ->where('clientes.id','=',$request->cliente_id)
        ->select('clientes.id','clientes.cli_usuario','tokes.tokens')
        ->orderby('clientes.id', 'asc')->get();
  
        $fe = date('d-m-Y H:i');
        $titulo='Se Añadio Nuevo Pago';
  

       
        $descripcion = 'Se añadio un nuevo pago de '.$request->monto.'bs. fecha '.$fe;
  

        
        $tipo='Pago';

        $data=array(
          'title'  => ''.$titulo.'',
          'body'   => ''.$descripcion.'',
        );
        
        
        foreach($send as $w)
        {
  
          $extra=array(
            'tipo'  => ''.$tipo.'',
            'email'   => ''.$w->cli_usuario.'',

          );
          
  
          
          $this->sendNotyfication1($data, $w->tokens, $extra);
  
  
          $noti = new Mensaje();
          $noti->tipo=$tipo;
          $noti->titulo=$titulo;
          $noti->mensaje=$descripcion;
          $noti->cliente_id=$w->id;
          $noti->save();
  
  
        }



        return $pagos;
        
    }

    if(0 == ($request->faltante - $request->monto)){
      if($request->forma_pago=="Deposito"){
          $deposito = Deposito::findOrFail($request->deposito_id);
          $deposito->estado='Verificado';
          $deposito->save();

          $fecha_pedosito=$deposito->fecha;

      }


        $pagos = new Pago();
        $fecha = date('Y-m-d H:i:s');
        $pagos->forma_pago=$request->forma_pago;
        $pagos->fecha_pago=$fecha;
        $pagos->monto=$request->monto;
        $pagos->foto_pago=$request->foto;
        if($request->forma_pago=="Deposito"){
            $pagos->foto_url='http://192.168.100.127/proyectofinal/PROYECTO/public/images/pagos/'.$request->foto;
        }else {
          $pagos->foto_url;
        }

        $pagos->fecha_entrega=$request->fecha_entrega;
        $pagos->fecha_deposito=$request->fecha_deposito;
        $pagos->cliente_id=$request->cliente_id;
        $pagos->save();




        $pedido = Pedido::where('fecha_entrega','=',$request->fecha_entrega,'And', 'cliente_id','=',$request->cliente_id)->get();

        foreach ($pedido as $a) {
          $a->estatus='Cancelado';
          $a->save();
        
        }

        $pa = Pago::where('fecha_entrega','=',$request->fecha_entrega,'And','cliente_id','=',$request->cliente_id)->get();

        foreach ($pa as $p) {
          $p->status='Cancelado';
          $p->save();
       
        }

         //---------NOTIFICACIONES ---------------------------------------------

         $send =  Cliente::join('tokes','tokes.cliente_id','=','clientes.id')
         ->where('clientes.id','=',$request->cliente_id)
         ->select('clientes.id','clientes.cli_usuario','tokes.tokens')
         ->orderby('clientes.id', 'asc')->get();
        
         $fe = date('d-m-Y H:i');
   
         $titulo='Se Añadio Nuevo Pago';
   
 
        
         $descripcion = 'Se añadio un nuevo pago de '.$request->monto.'bs. fecha '.$fe;
   
 
         
         $tipo='Pago';
 
         $data=array(
           'title'  => ''.$titulo.'',
           'body'   => ''.$descripcion.'',
         );
         
         
         foreach($send as $w)
         {
   
           $extra=array(
             'tipo'  => ''.$tipo.'',
             'email'   => ''.$w->cli_usuario.'',
 
           );
           
   
           
           $this->sendNotyfication1($data, $w->tokens, $extra);
   
   
           $noti = new Mensaje();
           $noti->tipo=$tipo;
           $noti->titulo=$titulo;
           $noti->mensaje=$descripcion;
           $noti->cliente_id=$w->id;
           $noti->save();
   
   
         }


        return $pagos;
    }else{
      return ['message' => 'Total Cancelado Fallo'];
    }
 
  }


  public function destroy($id){
    $pago = Pago::findOrFail($id);

    if($pago->forma_pago=='Efectivo') {
      
     $pago->delete();

    }else {
      if($pago->forma_pago=='Deposito'){
        $aux = Deposito::where('fecha','=',$pago->fecha_deposito)->get();
        foreach($aux as $row)
        {
          $idaux= $row->id;
        }

        $deposito = Deposito::find($idaux);
        $deposito->estado='NoVerificado';
        $deposito->save();

        $pago->delete();

      }
    }

    return ['message' => 'Pago Eliminado'];
    
  }

  public function pagonotificacion(Request $request){
      
      $cuota = new Cuota();
      $cuota->nombre=$request->evento;
      $cuota->fecha_entrega=$request->fecha.' '.$request->hora;
      $cuota->hora=$request->hora;
      $cuota->cliente_id=$request->id;
      $cuota->user_id=$request->user()->id;
      $cuota->save();

      //--------------Notificacion

      $send =  Cliente::join('tokes','tokes.cliente_id','=','clientes.id')
         ->where('clientes.id','=',$request->id)
         ->select('clientes.id','clientes.cli_usuario','tokes.tokens')
         ->orderby('clientes.id', 'asc')->get();
        
         $fe = date('d-m-Y H:i');
   
         $titulo='Fecha de Proximo Pago';
   
 
        
         $descripcion = 'Pago '.$request->evento.' '.$request->fecha.' a horas '.$request->hora;
   
 
         
         $tipo='PagoFecha';
 
         $data=array(
           'title'  => ''.$titulo.'',
           'body'   => ''.$descripcion.'',
         );
         
         
         foreach($send as $w)
         {
   
           $extra=array(
             'tipo'  => ''.$tipo.'',
             'email'   => ''.$w->cli_usuario.'',
 
           );
           
   
           
           $this->sendNotyfication1($data, $w->tokens, $extra);
   
   
           $noti = new Mensaje();
           $noti->tipo=$tipo;
           $noti->titulo=$titulo;
           $noti->mensaje=$descripcion;
           $noti->cliente_id=$w->id;
           $noti->save();
   
   
         }
         return $cuota;
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
