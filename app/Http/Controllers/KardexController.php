<?php

namespace Proyecto\Http\Controllers;

use Illuminate\Http\Request;
use Proyecto\Asignar;
use Proyecto\Producto;
use Proyecto\Inventario;
use Proyecto\SalidaInventario;
use Proyecto\Perfil;
use Proyecto\User;
use Proyecto\KadexGeneral;


use DB;


class KardexController extends Controller
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

            $inventariocantidad = Inventario::join('productos','productos.id','=','inventarios.producto_id')
            ->join('kadex_generals','kadex_generals.inventario_id','=','inventarios.id')
            ->select(DB::raw("DISTINCT inventarios.id, productos.nombre, productos.marca, productos.modelo"))
            ->orderby('productos.nombre','desc')
            ->whereMonth('kadex_generals.created_at','=',$mes)
            ->get();  

            $kardex=KadexGeneral::orderby('created_at','asc')->get();

              

              //->paginate(20);

             
              $conjunto_variables = compact('inventariocantidad','kardex','fecha');

            return response()->json($conjunto_variables,200);
          }
          $asignasiones  = Asignar::all();

          $perfiles = Perfil::all();
          $usuarios = User::all();
            return view('reportes.indexkardex',compact('usuarios','perfiles','asignasiones'));
        }
        else {
            return view('common.401');
        }
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
        if($request->consulta==1){
            return Inventario::join('productos','productos.id','=','inventarios.producto_id')
            ->join('kadex_generals','kadex_generals.inventario_id','=','inventarios.id')
            ->select(DB::raw("DISTINCT inventarios.id, productos.nombre, productos.marca, productos.modelo"))
            ->orderby('productos.nombre','desc')
            ->whereMonth('kadex_generals.created_at','=',$request->mesconsulta)
            ->get();      
        }
        if($request->consulta==2){
            return Inventario::join('productos','productos.id','=','inventarios.producto_id')
            ->join('kadex_generals','kadex_generals.inventario_id','=','inventarios.id')
            ->select(DB::raw("DISTINCT inventarios.id, productos.nombre, productos.marca, productos.modelo"))
            ->orderby('productos.nombre','desc')
            ->whereDate('kadex_generals.created_at','>=',$request->fechainicio)
            ->whereDate('kadex_generals.created_at','<=',$request->fechafinal)
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

    public function pdfKardex(Request $request)
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
        $inventario=$request->inventario;
        $todo=$request->detalle;


        //dd($todo['data']);
        
        $pdf = \PDF::loadView('pdfs.pdfkardex', compact('fecha','todo','inventario'));

        $name=time();
        $pdf->setPaper('later', 'portrait')->save(public_path().'/reporteventas/kardex_'.$name.'.pdf');
        //return '<a href="reporteventas/reporte_'.$name.'.pdf" target="_black" class="btn btn-success btn-xs"><i class="fa fa-file-text-o"></i></a>';

       
        return "/reporteventas/kardex_$name.pdf";
  

    }
}
