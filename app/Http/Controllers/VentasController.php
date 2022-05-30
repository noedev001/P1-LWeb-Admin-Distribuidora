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
use Proyecto\Factura;
use Proyecto\DatoCliente;
use Proyecto\Perfil;
use Proyecto\User;


use DB;

//use Barryvdh\DomPDF\Facade as PDFs;

use PDFs;

class VentasController extends Controller
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

    if($rol=="SuperAdmin"  || $rol=="Admin" || $rol=="Dist"  )
    {

      if($request ->ajax())
      {
 
          $clientesPago = Cliente::join('pedidos','pedidos.cliente_id','=','clientes.id')
                                    ->join('dato_clientes','dato_clientes.cliente_id','=','clientes.id')
                                    ->orwhere('pedidos.estatus','=','Entregado')
                                    ->orwhere('pedidos.estatus','=','Cancelado')
                                    ->groupBy('pedidos.fecha_entrega')
                                    ->orderby('pedidos.fecha_entrega','desc')
                                    ->select('clientes.id','clientes.cli_usuario','clientes.cli_nombres', 'clientes.cli_usuario','clientes.cli_apellidos','pedidos.fecha_entrega', 'clientes.cli_celular' , 'dato_clientes.user_id')
                                    ->paginate(12);

          $idpagocliente = Pedido::where('estatus','=',"Entregado")
                                    ->orwhere('pedidos.estatus','=','Cancelado')
                                    ->select('cliente_id', 'fecha_entrega')
                                    ->orderby('id', 'desc')->take(1)
                                    ->get();

        

          $detallepedido = Pedido::where('estatus','=',"Entregado")->orwhere('pedidos.estatus','=','Cancelado')->with("inventarios")->orderby('id', 'desc')->get();

          $inventarios =  Inventario::All();

          $productos = Producto::All();

          $clientes = Cliente::join('dato_clientes','dato_clientes.cliente_id','=','clientes.id')->orderby('clientes.cli_nombres', 'asc')
          ->select('clientes.id','clientes.cli_usuario','clientes.cli_nombres','clientes.cli_apellidos', 'clientes.cli_celular', 'dato_clientes.ci')
          ->get();

         


          $precioTotal = Pedido::where('estatus','=',"Entregado")->orwhere('pedidos.estatus','=','Cancelado')
          ->groupBy('fecha_entrega','cliente_id','estatus')
          ->orderby('fecha_entrega', 'desc')
          ->select(DB::raw('count(*) as CantidadProductos,round( IFNULL( SUM(precio_total),0),2) as PrecioTotal, cliente_id,estatus,fecha_entrega'))
          ->get();

          $pagos = Pago::All();

          $saldos = Pago::groupBy('fecha_entrega')
          ->select(DB::raw(' IFNULL( SUM(monto),0) as SaldoPagados, cliente_id,fecha_entrega'))
          ->get();

          $facturas = Factura::orderby('id', 'desc')->get();

          $asignar  = Asignar::all();
            $usuarios = User::all();
            $iduser = $request->user()->id;

            $roles = Asignar::where('user_id','=',$request->user()->id)->select('rol_asignacion')->get();

            foreach($roles as $aux){
                $rol=$aux->rol_asignacion;
            }

          $conjunto_variables = compact('clientesPago', 'detallepedido', 'inventarios', 'productos', 'clientes', 'precioTotal', 'pagos', 'saldos',
                                    'idpagocliente', 'facturas', 'usuarios','asignar','iduser','rol');

          return response()->json($conjunto_variables,200);

      }
      $asignasiones  = Asignar::all();

          $perfiles = Perfil::all();
          $usuarios = User::all();
        return view('ventas.index',compact('usuarios','perfiles','asignasiones'));
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
  
  
             return  DB::table('clientes')->join('pedidos','pedidos.cliente_id','=','clientes.id')
             ->join('dato_clientes','dato_clientes.cliente_id','=','clientes.id')
             ->orwhere('pedidos.estatus','=','Entregado')
             ->orwhere('pedidos.estatus','=','Cancelado')
             ->groupBy('pedidos.fecha_entrega')
             ->orderby('pedidos.fecha_entrega','desc')
             ->select('clientes.id','clientes.cli_usuario','clientes.cli_nombres', 'clientes.cli_usuario','clientes.cli_apellidos','pedidos.fecha_entrega', 'clientes.cli_celular' , 'dato_clientes.user_id')->where(function($query) use ($search){
                $query->orwhere('clientes.cli_usuario','LIKE',"%$search%");
                $query->orwhere('clientes.cli_apellidos','LIKE',"%$search%");
                $query->orwhereDate('pedidos.fecha_entrega','LIKE',"%$search%");
                $query->orwhereYear('pedidos.fecha_entrega','LIKE',"%$search%");
                $query->orwhereMonth('pedidos.fecha_entrega','LIKE',"%$search%");
                $query->orwhereDay('pedidos.fecha_entrega','LIKE',"%$search%");
            })->paginate(12);
        }else{
           return  Cliente::join('pedidos','pedidos.cliente_id','=','clientes.id')
            ->join('dato_clientes','dato_clientes.cliente_id','=','clientes.id')
            ->orwhere('pedidos.estatus','=','Entregado')
            ->orwhere('pedidos.estatus','=','Cancelado')
            ->groupBy('pedidos.fecha_entrega')
            ->orderby('pedidos.fecha_entrega','desc')
            ->select('clientes.id','clientes.cli_usuario','clientes.cli_nombres', 'clientes.cli_usuario','clientes.cli_apellidos','pedidos.fecha_entrega', 'clientes.cli_celular' , 'dato_clientes.user_id')
            ->paginate(12);
        }
  

  
    }


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
        //
    }



    /*public function pdf(Request $request)
    {
       /* $clienteFac = Cliente::join('dato_clientes','dato_clientes.cliente_id','=','clientes.id')->where('clientes.id','=',$request->id)->orderby('clientes.cli_nombres', 'asc')
        ->select('clientes.id','clientes.cli_usuario','clientes.cli_nombres','clientes.cli_apellidos', 'clientes.cli_celular', 'dato_clientes.ci')
        ->get();
       
        
       $facturas = Factura::where('fecha','=',$request->fecha)->where('cliente_id','=',$request->id)->select(DB::raw("factura, DATE_FORMAT(fecha, '%d-%M-%Y %h:%i %p') as fechafac"))->get();


        $detallepedido = Pedido::join('inventario_pedido','inventario_pedido.pedido_id','=','pedidos.id')
                                ->join('inventarios','inventarios.id','=','inventario_pedido.inventario_id')
                                ->join('productos','productos.id','=','inventarios.producto_id')
                                ->where('pedidos.cliente_id','=',$request->id)
                                ->where('pedidos.fecha_entrega','=',$request->fecha)
                                ->select('productos.nombre','productos.marca','inventarios.cantidad_unidad_caja','pedidos.cantidad_unidad','pedidos.cantidad_caja','pedidos.precio_unidad','pedidos.precio_total', 'pedidos.fecha_entrega')
                                ->orderby('pedidos.id', 'desc')
                                ->get();

        $precioTotal = Pedido::where('cliente_id','=',$request->id)
                                ->where('fecha_entrega','=',$request->fecha)
                                ->groupBy('fecha_entrega','cliente_id','estatus')
                                ->orderby('fecha_entrega', 'desc')
                                ->select(DB::raw(' IFNULL( SUM(precio_total),0) as PrecioTotal'))
                                ->get();
        
      
        
        $pdf = \PDF::loadView('facturas.pdf', compact('clienteFac','facturas','detallepedido','precioTotal'));

        $name=time();
        $pdf->setPaper('later', 'portrait')->save(public_path().'/facturas/factura_'.$name.'.pdf');
        return "Factura Creada";


        
  

    }*/
 
}
