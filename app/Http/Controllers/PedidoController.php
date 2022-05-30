<?php

namespace Proyecto\Http\Controllers;

use Illuminate\Http\Request;

use Proyecto\Inventario;
use Proyecto\Producto;
use Proyecto\Asignar;
use Proyecto\Oferta;
use Proyecto\Pedido;
use Proyecto\Cliente;
use Proyecto\Detalle_Pedido;
use Proyecto\Categoria;
use Proyecto\Factura;
use Proyecto\DatoCliente;
use Proyecto\Cuota;
use Proyecto\Deposito;
use Proyecto\Pago;

use Proyecto\EntradaInventario;
use Proyecto\SaldoInventario;
use Proyecto\SalidaInventario;
use Proyecto\Mensaje;
use Proyecto\Perfil;
use Proyecto\User;

use Proyecto\KadexGeneral;

use DB;


class PedidoController extends Controller
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


                      $inventarios =  Inventario::All();
                      $productos  = Producto::orderby('nombre', 'asc')->get();
                      $clientes =  Cliente::orderby('cli_nombres', 'asc')->get();

                      $articulos = Producto::join('inventarios','inventarios.producto_id','=','productos.id')
                                            ->select('productos.*')
                                            ->orwhere('inventarios.status','=','Disponible')
                                            ->get();

                      $ofertas = Oferta::where('status','=','Disponible')->get();

                      $categorias = Categoria::join('productos','productos.categoria_id','=','categorias.id')
                                                ->join('inventarios','inventarios.producto_id','=','productos.id')
                                                ->select('categorias.id','categorias.nombre')
                                                ->orwhere('inventarios.status','=','Disponible')
                                                ->groupBy('categorias.id')
                                                ->orderby('categorias.nombre','ASC')
                                                ->get();

                      $categoriaOfertas = Categoria::join('productos','productos.categoria_id','=','categorias.id')
                                                                          ->join('inventarios','inventarios.producto_id','=','productos.id')
                                                                          ->join('ofertas','ofertas.inventario_id','=','inventarios.id')
                                                                          ->select('categorias.id','categorias.nombre')
                                                                          ->orwhere('ofertas.status','=','Disponible')
                                                                          ->groupBy('categorias.id')
                                                                          ->orderby('categorias.nombre','ASC')
                                                                          ->get();

                      $productoOfertas = Producto::join('categorias','categorias.id','=','productos.categoria_id')
                                                ->join('inventarios','inventarios.producto_id','=','productos.id')
                                                ->join('ofertas','ofertas.inventario_id','=','inventarios.id')
                                                ->select('productos.*')
                                                ->orwhere('ofertas.status','=','Disponible')
                                                ->get();


                      $pedidos =  Pedido::join('clientes','clientes.id','=','pedidos.cliente_id')
                      ->join('dato_clientes','dato_clientes.cliente_id','=','clientes.id')
                      ->where('pedidos.estatus','=',"PedidoHecho")
                      ->select('pedidos.cantidad_caja','pedidos.cantidad_unidad','pedidos.cliente_id','pedidos.estatus','pedidos.fecha_compra','pedidos.fecha_entrega','pedidos.id','pedidos.oferta','pedidos.precio_total','pedidos.precio_unidad','dato_clientes.user_id',)
                      ->orderby('pedidos.id', 'desc')->get();

                      $pedidoHecho = Pedido::join('clientes','clientes.id','=','pedidos.cliente_id')
                      ->join('dato_clientes','dato_clientes.cliente_id','=','clientes.id')
                      ->where('pedidos.estatus','=',"PedidoHecho")
                      ->groupBy('pedidos.fecha_compra','pedidos.cliente_id','pedidos.estatus','dato_clientes.user_id')
                      ->orderby('pedidos.fecha_compra', 'desc')
                      ->select("pedidos.cliente_id","pedidos.estatus", "pedidos.fecha_compra",'dato_clientes.user_id')
                      ->paginate(20);

                      $detallepedido = Pedido::where('estatus','=',"PedidoHecho")->with("inventarios")->orderby('id', 'desc')->get();

                      $preuni = Pedido::join('clientes','clientes.id','=','pedidos.cliente_id')
                      ->join('dato_clientes','dato_clientes.cliente_id','=','clientes.id')
                      ->where('pedidos.estatus','=',"PedidoHecho")
                      ->groupBy('pedidos.fecha_compra','pedidos.cliente_id','pedidos.estatus','dato_clientes.user_id')
                      ->orderby('pedidos.fecha_compra', 'desc')
                      ->select(DB::raw('count(*) as CantidadProductos, round( IFNULL( SUM(pedidos.precio_total),0),2) as PrecioTotal, pedidos.cliente_id, pedidos.estatus, pedidos.fecha_compra, dato_clientes.user_id'))
                      ->get();


                      $idpedido = Pedido::where('estatus','=',"PedidoHecho")
                      ->select('cliente_id', 'fecha_compra')
                      ->orderby('id', 'desc')->take(1)
                      ->get();

                      $asignar  = Asignar::all();
                      $iduser = $request->user()->id;
     
                      $usuarios = User::all();
  

                      $roles = Asignar::where('user_id','=',$request->user()->id)->select('rol_asignacion')->get();

                      foreach($roles as $aux){
                          $rol=$aux->rol_asignacion;
                      }

                      $conjunto_variables = compact('pedidos','pedidoHecho','inventarios','clientes','productos',
                                                    'detallepedido','preuni','categorias', 'idpedido', 'articulos',
                                                  'ofertas', 'categoriaOfertas','productoOfertas', 'asignar','iduser' , 'usuarios','rol');


                      return response()->json($conjunto_variables,200);


         }
         $pedidos =  Pedido::all();
         $asignasiones  = Asignar::all();

          $perfiles = Perfil::all();
          $usuarios = User::all();
           return view('pedidos.index',compact('usuarios','perfiles','asignasiones'));
         }
         else {
          $asignasiones  = Asignar::all();

          $perfiles = Perfil::all();
          $usuarios = User::all();
             return view('common.401',compact('usuarios','perfiles','asignasiones'));
         }
     }



    public function createArticulo(Request $request){

        $pedido = new Pedido();



        if($request->cantidad_unidad!=null){
          $pedido->cantidad_unidad=$request->cantidad_unidad;
          $unidad=$request->cantidad_unidad;
        }else {
          $pedido->cantidad_unidad=0;
          $unidad=0;
        }

        if($request->cantidad_caja!=null){
          $pedido->cantidad_caja=$request->cantidad_caja;
          $caja=$request->cantidad_caja;
        }else {
          $pedido->cantidad_caja=0;
          $caja=0;
        }

        $pedido->precio_unidad=$request->precio_unidad;
        $pedido->precio_total=$request->precio_total;
        $pedido->fecha_entrega=$request->fecha_compra;
        $pedido->estatus="PedidoHecho";
        $pedido->fecha_compra=$request->fecha_compra;
        $pedido->precio_unidad=$request->precio_unidad;

        if($request->tipo=="1"){
          $pedido->oferta=0;
        }
        if($request->tipo=="2"){
          $pedido->oferta=$request->oferta_id;
        }
        $pedido->cliente_id=$request->cliente_id;
        $pedido->user_id=$request->user()->id;

        $pedido->save();


        $aux = Pedido::where('fecha_compra','=',$request->fecha_compra,'AND','cliente_id','=',$request->cliente_id)
                        ->orderby('id', 'desc')->take(1)
                        ->get();

        foreach($aux as $row)
        {
          $idpedido = $row->id;

        }

        $inventario = Inventario::find($request->inventario_id);

        $inventario->pedidos()->attach($idpedido, ['fecha_pedido' => $request->fecha_compra, 'precio_venta_unidad' => $request->precio_unidad, 'precio_total_pedido' => $request->precio_total, 'cantidad_unidad' => $unidad, 'cantidad_caja' => $caja ]);

        return $pedido;

    }



    public function store(Request $request)
    {
          $fecha = date('Y-m-d H:i:s');

          $pedido = new Pedido();



          if($request->cantidad_unidad!=null){
            $pedido->cantidad_unidad=$request->cantidad_unidad;
            $unidad=$request->cantidad_unidad;
          }else {
            $pedido->cantidad_unidad=0;
            $unidad=0;
          }

          if($request->cantidad_caja!=null){
            $pedido->cantidad_caja=$request->cantidad_caja;
            $caja=$request->cantidad_caja;
          }else {
            $pedido->cantidad_caja=0;
            $caja=0;
          }

          $pedido->precio_unidad=$request->precio_unidad;
          $pedido->precio_total=$request->precio_total;
          $pedido->fecha_entrega=$fecha;
          $pedido->estatus="PedidoHecho";
          $pedido->fecha_compra=$fecha;
          $pedido->precio_unidad=$request->precio_unidad;

          if($request->tipo=="1"){
            $pedido->oferta=0;
          }
          if($request->tipo=="2"){
            $pedido->oferta=$request->oferta_id;
          }
          $pedido->cliente_id=$request->cliente_id;
          $pedido->user_id=$request->user()->id;

          $pedido->save();


          $aux = Pedido::where('fecha_compra','=',$fecha,'AND','cliente_id','=',$request->cliente_id)
                          ->orderby('id', 'desc')->take(1)
                          ->get();

          foreach($aux as $row)
          {
            $idpedido = $row->id;

          }

          $inventario = Inventario::find($request->inventario_id);

          $inventario->pedidos()->attach($idpedido, ['fecha_pedido' => $fecha, 'precio_venta_unidad' => $request->precio_unidad, 'precio_total_pedido' => $request->precio_total, 'cantidad_unidad' => $unidad, 'cantidad_caja' => $caja ]);

          return $pedido;

    }

    public function updateArticulo(Request $request)
    {

      $articulo = Pedido::findOrFail($request->pedido_id);

      $articulo->cantidad_unidad=$request->cantidad_unidad;
      $articulo->cantidad_caja=$request->cantidad_caja;
      $articulo->precio_unidad=$request->precio_unidad;
      $articulo->precio_total=$request->precio_total;

      $articulo->save();

      return $articulo;
    }



    public function update(Request $request)
    {
        //dd($fecha);
        $pedido = Pedido::where("fecha_compra","=",$request->fecha,'AND',"cliente_id","=",$request->cliente)->get();

        $fecha = date('Y-m-d H:i:s');

        // facturaa 

        $factura = new Factura();
        $factura->factura=rand(10000000,99999999);
        $factura->fecha=$fecha;
        $factura->cliente_id=$request->cliente;
        $factura->save();

        $auxfac = Factura::where('fecha','=',$fecha,'AND','cliente_id','=',$request->cliente)
        ->orderby('id', 'desc')->take(1)
        ->get();

        foreach($auxfac as $row)
        {
        $idfactura = $row->id;
        }

        foreach($pedido as $p)
        {
              $p->estatus='Entregado';
              $p->fecha_entrega=$fecha;
              $p->user_id=$request->user()->id;

              // para modificar inventario
              $of=$p->oferta;
              if($of!=0){
                //-------------------------------------------------Oferta  inventario
                $oferta = Oferta::where('id','=',$of)->get();

                $ped = Pedido::join('inventario_pedido','inventario_pedido.pedido_id','=','pedidos.id')
                              ->select('inventario_pedido.inventario_id')
                              ->orwhere('pedidos.id','=',$p->id)->get();

                foreach($ped as $aa){
                  $idinventario=$aa->inventario_id;
                }

                foreach($oferta as $o)
                {
                    //dd($idinventario);

                  $inventario = Inventario::findOrFail($idinventario);

                  //--------------------------------------Saldos
                  $aux = SaldoInventario::where('inventario_id','=',$inventario->id)
                  ->orderby('id', 'desc')->take(1)
                  ->get();

                  

                  foreach($aux as $row)
                  {
                  $idsaldo = $row->id;
                  $ca=$row->cantidad_total;
                  $saluax= $row->saldototal;
                  $saluax1= $row->saldototalventa;
                  }

                  $saldo = new SaldoInventario();

                  if($p->cantidad_unidad>0){
                    $saldo->cantidad_total = ($ca-$p->cantidad_unidad);
                    $saldo->saldototal= $saluax-($p->cantidad_unidad*$inventario->precio_compra_unidad);
                    $saldo->saldototalventa=$saluax1-($p->cantidad_unidad*$inventario->precio_venta_unidad);
                  }

                  if($p->cantidad_caja>0){
                    $saldo->cantidad_total = ($ca-($p->cantidad_caja*$inventario->cantidad_unidad_caja));
                    $saldo->saldototal= $saluax-(($p->cantidad_caja*$inventario->cantidad_unidad_caja)*$inventario->precio_compra_unidad);
                    $saldo->saldototalventa=$saluax1-(($p->cantidad_caja*$inventario->cantidad_unidad_caja)*$inventario->precio_venta_unidad);
                  }
                  
                  $saldo->status='SalidaOferta';
                  $saldo->precioanterior=$o->precio_venta_nuevo;
                  $saldo->inventario_id= $inventario->id;

                  //dd($saldo);

                  $saldo->save();
                  //-------------------------------------Salidas

                  $salida = new SalidaInventario();
                  

                  if($p->cantidad_unidad>0){
                    $salida->cantidad_unidad=($p->cantidad_unidad);
                    $salida->cantidad_caja=(($p->cantidad_unidad/$inventario->cantidad_unidad_caja));
                    
                  }

                  if($p->cantidad_caja>0){
                    $salida->cantidad_unidad=(($p->cantidad_caja*$inventario->cantidad_unidad_caja));
                    $salida->cantidad_caja=($p->cantidad_caja);
                  
                  }

                  $salida->precio_venta_unidad=$o->precio_venta_nuevo;
                  $salida->detalle='Oferta';
                  $salida->status='PositivoOferta';
                  $salida->inventario_id= $inventario->id;
                  //dd($salida);
                  $salida->save();


                  $kardex=new KadexGeneral();
                  $kardex->inventario_id= $inventario->id;
                  if($p->cantidad_unidad>0){
                    $kardex->cantidad_unidad_salida=($p->cantidad_unidad);
                    $kardex->cantidad_caja_salida=(($p->cantidad_unidad/$inventario->cantidad_unidad_caja));
                    
                  }

                  if($p->cantidad_caja>0){
                    $kardex->cantidad_unidad_salida=(($p->cantidad_caja*$inventario->cantidad_unidad_caja));
                    $kardex->cantidad_caja_salida=($p->cantidad_caja);
                  
                  }

                  $kardex->precio_venta_unidad_salida=$o->precio_venta_nuevo;
                  $kardex->detalle_salida='Oferta';
                  $kardex->status_salida='PositivoOferta';

                  if($p->cantidad_unidad>0){
                    $kardex->cantidad_total = ($ca-$p->cantidad_unidad);
                    $kardex->saldototal= $saluax-($p->cantidad_unidad*$inventario->precio_compra_unidad);
                    $kardex->saldototalventa=$saluax1-($p->cantidad_unidad*$inventario->precio_venta_unidad);
                  }

                  if($p->cantidad_caja>0){
                    $kardex->cantidad_total = ($ca-($p->cantidad_caja*$inventario->cantidad_unidad_caja));
                    $kardex->saldototal= $saluax-(($p->cantidad_caja*$inventario->cantidad_unidad_caja)*$inventario->precio_compra_unidad);
                    $kardex->saldototalventa=$saluax1-(($p->cantidad_caja*$inventario->cantidad_unidad_caja)*$inventario->precio_venta_unidad);
                  }
                  
                  $kardex->status='SalidaOferta';
                  $kardex->precioanterior=$o->precio_venta_nuevo;
                  
                  $kardex->save();

                  //-----------------------Inventario
                  $aux10=$inventario->cantidad_unidad_almacen_dis;
                  $aux100=$inventario->cantidad_caja_almacen_dis;

                  if($p->cantidad_unidad>0){
                    $inventario->cantidad_unidad_almacen_dis=($aux10-$p->cantidad_unidad);
                    $inventario->cantidad_caja_almacen_dis=($aux100-($p->cantidad_unidad/$inventario->cantidad_unidad_caja));
                    if(($inventario->cantidad_unidad_almacen_dis<=0) && $inventario->cantidad_caja_almacen_dis<=0){
                      $inventario->status='Agotado';
                    }
                  }

                  if($p->cantidad_caja>0){
                    $inventario->cantidad_unidad_almacen_dis=($aux10-($p->cantidad_caja*$inventario->cantidad_unidad_caja));
                    $inventario->cantidad_caja_almacen_dis=($aux100-$p->cantidad_caja);
                    if(($inventario->cantidad_unidad_almacen_dis<=0) && $inventario->cantidad_caja_almacen_dis<=0){
                      $inventario->status='Agotado';
                    }
                  }
                  $inventario->save();


                }

              }else{
                  //----------------------------------------------------------Inventario

                $ped = Pedido::join('inventario_pedido','inventario_pedido.pedido_id','=','pedidos.id')
                              ->select('inventario_pedido.inventario_id')
                              ->orwhere('pedidos.id','=',$p->id)->get();

                foreach($ped as $w)
                {
                  $inventario = Inventario::findOrFail($w->inventario_id);

                  

                  //--------------------------------------Saldos
                  $aux = SaldoInventario::where('inventario_id','=',$w->inventario_id)
                  ->orderby('id', 'desc')->take(1)
                  ->get();

                  foreach($aux as $row)
                  {
                  $idsaldo = $row->id;
                  $ca=$row->cantidad_total;
                  $saluax= $row->saldototal;
                  $saluax1= $row->saldototalventa;
                  }

                  $saldo = new SaldoInventario();

                  if($p->cantidad_unidad>0){
                    $saldo->cantidad_total = ($ca-$p->cantidad_unidad);
                    $saldo->saldototal= $saluax-($p->cantidad_unidad*$inventario->precio_compra_unidad);
                    $saldo->saldototalventa=$saluax1-($p->cantidad_unidad*$inventario->precio_venta_unidad);
                  }

                  if($p->cantidad_caja>0){
                    $saldo->cantidad_total = ($ca-($p->cantidad_caja*$inventario->cantidad_unidad_caja));
                    $saldo->saldototal= $saluax-(($p->cantidad_caja*$inventario->cantidad_unidad_caja)*$inventario->precio_compra_unidad);
                    $saldo->saldototalventa=$saluax1-(($p->cantidad_caja*$inventario->cantidad_unidad_caja)*$inventario->precio_venta_unidad);
                  }

                  
                  
                  $saldo->status='Salida';
                  $saldo->precioanterior=$inventario->precio_venta_unidad;
                  $saldo->inventario_id= $w->inventario_id;
                  $saldo->save();

                  //-------------------------------------Salidas
                  $salida = new SalidaInventario();
                  $salida->cantidad_unidad=$p->cantidad_unidad;
                  $salida->cantidad_caja=$p->cantidad_caja;

                  if($p->cantidad_unidad>0){
                    $salida->cantidad_unidad=($p->cantidad_unidad);
                    $salida->cantidad_caja=(($p->cantidad_unidad/$inventario->cantidad_unidad_caja));
                  
                  }

                  if($p->cantidad_caja>0){
                    $salida->cantidad_unidad=(($p->cantidad_caja*$inventario->cantidad_unidad_caja));
                    $salida->cantidad_caja=($p->cantidad_caja);
                   
                  }


                  $salida->precio_venta_unidad=$inventario->precio_venta_unidad;
                  $salida->detalle='Venta';
                  $salida->status='Positivo';
                  $salida->inventario_id= $w->inventario_id;
                  $salida->save();


                  $kardex=new KadexGeneral();
                  $kardex->inventario_id= $w->inventario_id;

                  $kardex->cantidad_unidad_salida=$p->cantidad_unidad;
                  $kardex->cantidad_caja_salida=$p->cantidad_caja;

                  if($p->cantidad_unidad>0){
                    $kardex->cantidad_unidad_salida=($p->cantidad_unidad);
                    $kardex->cantidad_caja_salida=(($p->cantidad_unidad/$inventario->cantidad_unidad_caja));
                  
                  }
                  if($p->cantidad_caja>0){
                    $kardex->cantidad_unidad_salida=(($p->cantidad_caja*$inventario->cantidad_unidad_caja));
                    $kardex->cantidad_caja_salida=($p->cantidad_caja);
                   
                  }
                  $kardex->precio_venta_unidad_salida=$inventario->precio_venta_unidad;
                  $kardex->detalle_salida='Venta';
                  $kardex->status_salida='Positivo';


                  if($p->cantidad_unidad>0){
                    $kardex->cantidad_total = ($ca-$p->cantidad_unidad);
                    $kardex->saldototal= $saluax-($p->cantidad_unidad*$inventario->precio_compra_unidad);
                    $kardex->saldototalventa=$saluax1-($p->cantidad_unidad*$inventario->precio_venta_unidad);
                  }

                  if($p->cantidad_caja>0){
                    $kardex->cantidad_total = ($ca-($p->cantidad_caja*$inventario->cantidad_unidad_caja));
                    $kardex->saldototal= $saluax-(($p->cantidad_caja*$inventario->cantidad_unidad_caja)*$inventario->precio_compra_unidad);
                    $kardex->saldototalventa=$saluax1-(($p->cantidad_caja*$inventario->cantidad_unidad_caja)*$inventario->precio_venta_unidad);
                  }

                  
                  
                  $kardex->status='Salida';
                  $kardex->precioanterior=$inventario->precio_venta_unidad;
                  
                  $kardex->save();


                  //-------------------------Inventario

                  //$inventario = Inventario::findOrFail($w->inventario_id);

                  $aux=$inventario->cantidad_unidad_almacen_dis;
                  $aux1=$inventario->cantidad_caja_almacen_dis;

                  if($p->cantidad_unidad>0){
                    $inventario->cantidad_unidad_almacen_dis=($aux-$p->cantidad_unidad);
                    $inventario->cantidad_caja_almacen_dis=($aux1-($p->cantidad_unidad/$inventario->cantidad_unidad_caja));
                    if(($inventario->cantidad_unidad_almacen_dis<=0) && $inventario->cantidad_caja_almacen_dis<=0){
                      $inventario->status='Agotado';
                    }
                  }

                  if($p->cantidad_caja>0){
                    $inventario->cantidad_unidad_almacen_dis=($aux-($p->cantidad_caja*$inventario->cantidad_unidad_caja));
                    $inventario->cantidad_caja_almacen_dis=($aux1-$p->cantidad_caja);
                    if(($inventario->cantidad_unidad_almacen_dis<=0) && $inventario->cantidad_caja_almacen_dis<=0){
                      $inventario->status='Agotado';
                    }
                  }
                  $inventario->save();

                  //return $inventario;
                }
              }

              // para la factura
              $fact = Factura::find($idfactura);
              $fact->pedidos()->attach($p->id);

              //guardar pedidos compras

              $p->save();  
        }

        //facturas crear

        $clienteFac = Cliente::join('dato_clientes','dato_clientes.cliente_id','=','clientes.id')->where('clientes.id','=',$request->cliente)->orderby('clientes.cli_nombres', 'asc')
        ->select('clientes.id','clientes.cli_usuario','clientes.cli_nombres','clientes.cli_apellidos', 'clientes.cli_celular', 'dato_clientes.ci')
        ->get();
       
        
       $facturas = Factura::where('fecha','=',$fecha)->where('cliente_id','=',$request->cliente)->select(DB::raw("factura, DATE_FORMAT(fecha, '%d-%M-%Y %h:%i %p') as fechafac"))->get();


        $detallepedido = Pedido::join('inventario_pedido','inventario_pedido.pedido_id','=','pedidos.id')
                                ->join('inventarios','inventarios.id','=','inventario_pedido.inventario_id')
                                ->join('productos','productos.id','=','inventarios.producto_id')
                                ->where('pedidos.cliente_id','=',$request->cliente)
                                ->where('pedidos.fecha_entrega','=',$fecha)
                                ->select('productos.nombre','productos.marca','inventarios.cantidad_unidad_caja','pedidos.cantidad_unidad','pedidos.cantidad_caja','pedidos.precio_unidad','pedidos.precio_total', 'pedidos.fecha_entrega')
                                ->orderby('pedidos.id', 'desc')
                                ->get();

        $precioTotal = Pedido::where('cliente_id','=',$request->cliente)
                                ->where('fecha_entrega','=',$fecha)
                                ->groupBy('fecha_entrega','cliente_id','estatus')
                                ->orderby('fecha_entrega', 'desc')
                                ->select(DB::raw(' IFNULL( SUM(precio_total),0) as PrecioTotal'))
                                ->get();
        
      
        
        $pdf = \PDF::loadView('facturas.pdf', compact('clienteFac','facturas','detallepedido','precioTotal'));

        $name=time();
        $pdf->setPaper('later', 'portrait')->save(public_path().'/facturas/factura_'.$name.'.pdf');


        $fa = Factura::find($idfactura);
        $fa->facturapdf='factura_'.$name.'.pdf';
        $fa->facturaurl='http://192.168.100.127/proyectofinal/PROYECTO/public/facturas/factura_'.$name.'.pdf';
        $fa->save();



        //----------------NOTIFICACIONES---------------------------------------

        $send =  Cliente::join('tokes','tokes.cliente_id','=','clientes.id')
        ->where('clientes.id','=',$request->cliente)
        ->select('clientes.id','clientes.cli_usuario','tokes.tokens')
        ->orderby('clientes.id', 'asc')->get();
          
        $fe = date('d-m-Y H:i');

          
                $titulo='Factura';
                         
                $descripcion = 'Factura Añadida '.$fe;
          
                
                $tipo='Factura';
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
                  
                  $this->sendNotyfication($data, $w->tokens, $extra);
          
                  $noti = new Mensaje();
                  $noti->tipo=$tipo;
                  $noti->titulo=$titulo;
                  $noti->mensaje=$descripcion;
                  $noti->cliente_id=$w->id;
                  $noti->save();
                }

        return $pedido;

    }


    public function eliminarPedido(Request $request)
    {
        Pedido::where('fecha_compra','=',$request->fecha_compra,'AND','cliente_id','=',$request->cliente_id, 'AND', 'estatus','=','PedidoHecho')->delete();

        return ['message' => 'Pedido Eliminado'];
    }

    public function eliminarArticulo($id)
    {
      $pedido = Pedido::findOrFail($id);
      $pedido->delete();

      return ['message' => 'Articulo Eliminados'];

    }

    public static function sendNotyfication($data,$tokens, $extra){

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
