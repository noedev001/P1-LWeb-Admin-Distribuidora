<?php

namespace Proyecto\Http\Controllers;

use Illuminate\Http\Request;
use Proyecto\Asignar;
use Proyecto\Producto;
use Proyecto\Inventario;
use Proyecto\SalidaInventario;
use Proyecto\Perfil;
use Proyecto\User;

use DB;

class ReportesController extends Controller
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

            $mes = date('m');
            $fecha = date('Y-m-d');

              $ventas = SalidaInventario::join('inventarios','inventarios.id','=','salida_inventarios.inventario_id')
              ->join('productos','productos.id','=','inventarios.producto_id')
              ->select('productos.nombre', 'productos.marca', 'productos.modelo', 'productos.medida', 'salida_inventarios.cantidad_unidad', 'salida_inventarios.cantidad_caja', 'salida_inventarios.precio_venta_unidad', 'salida_inventarios.detalle', 'salida_inventarios.status', 'salida_inventarios.created_at')
              ->orderby('salida_inventarios.id','desc')
              ->whereMonth('salida_inventarios.created_at','=',$mes)
              ->get();


              //->paginate(20);

             
              $conjunto_variables = compact('ventas', 'fecha');

            return response()->json($conjunto_variables,200);
          }
          $asignasiones  = Asignar::all();

          $perfiles = Perfil::all();
          $usuarios = User::all();
            return view('reportes.index',compact('usuarios','perfiles','asignasiones'));
        }
        else {
            return view('common.401');
        }
    }

    public function search(){

        if ($search = \Request::get('q')) {
            $users = DB::table('salida_inventarios')->join('inventarios','inventarios.id','=','salida_inventarios.inventario_id')
            ->join('productos','productos.id','=','inventarios.producto_id')
            ->select('productos.nombre', 'productos.marca', 'productos.modelo', 'productos.medida', 'salida_inventarios.cantidad_unidad', 'salida_inventarios.cantidad_caja', 'salida_inventarios.precio_venta_unidad', 'salida_inventarios.detalle', 'salida_inventarios.status', 'salida_inventarios.created_at')
            ->orderby('salida_inventarios.id','desc')
            ->where(function($query) use ($search){
                $query->orwhere('productos.nombre','LIKE',"%$search%");
                $query->orwhere('productos.marca','LIKE',"%$search%");
                $query->orwhere('salida_inventarios.detalle','LIKE',"%$search%");
                $query->orwhere('salida_inventarios.status','LIKE',"%$search%");
                $query->orwhereDate('salida_inventarios.created_at','LIKE',"%$search%");
                $query->orwhereYear('salida_inventarios.created_at','LIKE',"%$search%");
                $query->orwhereMonth('salida_inventarios.created_at','LIKE',"%$search%");
                $query->orwhereDay('salida_inventarios.created_at','LIKE',"%$search%");
            })->get();
    
            return $users;
        }else{
            $mes = date('m');
          return SalidaInventario::join('inventarios','inventarios.id','=','salida_inventarios.inventario_id')
          ->join('productos','productos.id','=','inventarios.producto_id')
          ->select('productos.nombre', 'productos.marca', 'productos.modelo', 'productos.medida', 'salida_inventarios.cantidad_unidad', 'salida_inventarios.cantidad_caja', 'salida_inventarios.precio_venta_unidad', 'salida_inventarios.detalle', 'salida_inventarios.status', 'salida_inventarios.created_at')
          ->orderby('salida_inventarios.id','desc')
          ->whereMonth('salida_inventarios.created_at','=',$mes)
          ->get();
        
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
        //dd($request->tipo);
    
            if($request->consulta==1){
                return SalidaInventario::join('inventarios','inventarios.id','=','salida_inventarios.inventario_id')
                ->join('productos','productos.id','=','inventarios.producto_id')
                ->select('productos.nombre', 'productos.marca', 'productos.modelo', 'productos.medida', 'salida_inventarios.cantidad_unidad', 'salida_inventarios.cantidad_caja', 'salida_inventarios.precio_venta_unidad', 'salida_inventarios.detalle', 'salida_inventarios.status', 'salida_inventarios.created_at')
                ->orderby('salida_inventarios.id','desc')
                ->whereMonth('salida_inventarios.created_at','=',$request->mesconsulta)
                ->get();
            }
            if($request->consulta==2){
                return SalidaInventario::join('inventarios','inventarios.id','=','salida_inventarios.inventario_id')
                ->join('productos','productos.id','=','inventarios.producto_id')
                ->select('productos.nombre', 'productos.marca', 'productos.modelo', 'productos.medida', 'salida_inventarios.cantidad_unidad', 'salida_inventarios.cantidad_caja', 'salida_inventarios.precio_venta_unidad', 'salida_inventarios.detalle', 'salida_inventarios.status', 'salida_inventarios.created_at')
                ->orderby('salida_inventarios.id','desc')
                ->whereDate('salida_inventarios.created_at','>=',$request->fechainicio)
                ->whereDate('salida_inventarios.created_at','<=',$request->fechafinal)
                ->get();
            }

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


    public function pdfReportes(Request $request)
    {
        //dd($request);

        $fecha = date('d-m-Y H:i');

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
                                ->get();*/
        
        $todo=$request->venta;

        //dd($todo['data']);
        
        $pdf = \PDF::loadView('pdfs.pdfreporte', compact('fecha','todo'));

        $name=time();
        $pdf->setPaper('later', 'portrait')->save(public_path().'/reporteventas/reporte_'.$name.'.pdf');
        //return '<a href="reporteventas/reporte_'.$name.'.pdf" target="_black" class="btn btn-success btn-xs"><i class="fa fa-file-text-o"></i></a>';

       
        return "/reporteventas/reporte_$name.pdf";
  

    }
}
