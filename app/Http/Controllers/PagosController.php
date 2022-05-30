<?php

namespace Proyecto\Http\Controllers;
use Proyecto\Asignar;
use Proyecto\Deposito;
use Proyecto\Cliente;
use Proyecto\Pedido;
use Proyecto\Inventario;
use Proyecto\Producto;
use Proyecto\Pago;
use Proyecto\Perfil;
use Proyecto\User;

use DB;

use Illuminate\Http\Request;

class PagosController extends Controller
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

        if($rol=="SuperAdmin"    || $rol=="Admin" || $rol=="Dist")
        {

                if($request ->ajax())
                {

                    $mes = date('m');
                    $fecha = date('Y-m-d');
            
                    $clientes = Cliente::join('pedidos','pedidos.cliente_id','=','clientes.id')
                                                 ->join('dato_clientes','dato_clientes.cliente_id','=','clientes.id')
                                                ->where('pedidos.estatus','=','Cancelado')
                                                ->whereMonth('pedidos.fecha_entrega','=',$mes)
                                                ->groupBy('pedidos.fecha_entrega')
                                                ->orderby('pedidos.fecha_entrega','desc')
                                                ->select('clientes.id','clientes.cli_usuario','clientes.cli_nombres','clientes.cli_apellidos','pedidos.fecha_entrega', 'clientes.cli_celular' , 'dato_clientes.user_id')
                                                ->get();                 

                    $detallepedido = Pedido::where('pedidos.estatus','=','Cancelado')->with("inventarios")->orderby('id', 'desc')->get();
                    
                    $productos = Producto::All();


                    $preciototal = Pedido::where('pedidos.estatus','=','Cancelado')
                    ->groupBy('fecha_entrega','cliente_id','estatus')
                    ->orderby('fecha_entrega', 'desc')
                    ->select(DB::raw('count(*) as CantidadProductos,round( IFNULL( SUM(precio_total),0),2) as PrecioTotal, cliente_id,estatus,fecha_entrega'))
                    ->get();

                    $pagos = Pago::where('pagos.status','=','Cancelado')->get();

                    $saldos = Pago::groupBy('fecha_entrega')
                    ->select(DB::raw(' IFNULL( SUM(monto),0) as SaldoPagados, cliente_id,fecha_entrega'))
                    ->get();

                    $asignar  = Asignar::all();
                    $usuarios = User::all();
                    $iduser = $request->user()->id;
        
                    $roles = Asignar::where('user_id','=',$request->user()->id)->select('rol_asignacion')->get();
        
                    foreach($roles as $aux){
                        $rol=$aux->rol_asignacion;
                    }

                    $conjunto_variables = compact('clientes', 'detallepedido', 'productos', 'preciototal', 'pagos', 'saldos' , 'usuarios','asignar','iduser','rol','fecha');

                    return response()->json($conjunto_variables,200);

                }
                $asignasiones  = Asignar::all();

          $perfiles = Perfil::all();
          $usuarios = User::all();
                    return view('cuentas.indexpagos',compact('usuarios','perfiles','asignasiones'));
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
            ->orwhere('pedidos.estatus','=','Cancelado')
            ->groupBy('pedidos.fecha_entrega')
            ->orderby('pedidos.fecha_entrega','desc')
            ->select('clientes.id','clientes.cli_usuario','clientes.cli_nombres','clientes.cli_apellidos','pedidos.fecha_entrega', 'clientes.cli_celular')
            ->where(function($query) use ($search){
                $query->orwhere('clientes.cli_nombres','LIKE',"%$search%");
                $query->orwhere('clientes.cli_usuario','LIKE',"%$search%");
                $query->orwhere('clientes.cli_apellidos','LIKE',"%$search%");
                $query->orwhereDate('pedidos.fecha_entrega','LIKE',"%$search%");
                $query->orwhereYear('pedidos.fecha_entrega','LIKE',"%$search%");
                $query->orwhereMonth('pedidos.fecha_entrega','LIKE',"%$search%");
                $query->orwhereDay('pedidos.fecha_entrega','LIKE',"%$search%");
            })->paginate(20);
    
            return $users;
        }else{
            $mes = date('m');
          
          return Cliente::join('pedidos','pedidos.cliente_id','=','clientes.id')
          ->join('dato_clientes','dato_clientes.cliente_id','=','clientes.id')
         ->where('pedidos.estatus','=','Cancelado')
         ->whereMonth('pedidos.fecha_entrega','=',$mes)
         ->groupBy('pedidos.fecha_entrega')
         ->orderby('pedidos.fecha_entrega','desc')
         ->select('clientes.id','clientes.cli_usuario','clientes.cli_nombres','clientes.cli_apellidos','pedidos.fecha_entrega', 'clientes.cli_celular' , 'dato_clientes.user_id')
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
        if($request->consulta==1){
            return  Cliente::join('pedidos','pedidos.cliente_id','=','clientes.id')
                                                 ->join('dato_clientes','dato_clientes.cliente_id','=','clientes.id')
                                                ->where('pedidos.estatus','=','Cancelado')
                                                ->whereMonth('pedidos.fecha_entrega','=',$request->mesconsulta)
                                                ->groupBy('pedidos.fecha_entrega')
                                                ->orderby('pedidos.fecha_entrega','desc')
                                                ->select('clientes.id','clientes.cli_usuario','clientes.cli_nombres','clientes.cli_apellidos','pedidos.fecha_entrega', 'clientes.cli_celular' , 'dato_clientes.user_id')
                                                ->get();   
        }
        if($request->consulta==2){
            return Cliente::join('pedidos','pedidos.cliente_id','=','clientes.id')
                                                 ->join('dato_clientes','dato_clientes.cliente_id','=','clientes.id')
                                                ->where('pedidos.estatus','=','Cancelado')
                                                ->whereDate('pedidos.fecha_entrega','>=',$request->fechainicio)
                                                ->whereDate('pedidos.fecha_entrega','<=',$request->fechafinal)
                                                ->groupBy('pedidos.fecha_entrega')
                                                ->orderby('pedidos.fecha_entrega','desc')
                                                ->select('clientes.id','clientes.cli_usuario','clientes.cli_nombres','clientes.cli_apellidos','pedidos.fecha_entrega', 'clientes.cli_celular' , 'dato_clientes.user_id')
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
}
