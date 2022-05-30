<?php

namespace Proyecto\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Void_;
use Proyecto\Categoria;
use Proyecto\Cliente;
use Proyecto\DatoCliente;
use Proyecto\Inventario;
use Proyecto\Producto;
use DB;
use Proyecto\Pedido;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {

            $categorias  = Categoria::orderby('nombre', 'asc')->get();;
            $productos  = Producto::orderby('nombre', 'asc')->get();
            $inventarios = Inventario::where('publicado', 'Si')->orderby('id', 'desc')->get();

            $can = (sizeof($inventarios)) / 2;


            $invmas = Inventario::where('publicado', 'Si')->orderby('id', 'desc')->take($can)->get();

            $invmen = Inventario::where('publicado', 'Si')->orderby('id', 'asc')->take($can)->get();
            $identificador = $request->session()->get('identificador');
            $comprobar = $request->session()->get('comprobar');

            $preuni = '';
            $pedidoHecho = '';
            if ($request->session()->has('comprobar')) {
                if ($comprobar == true) {
                    foreach ($identificador as $row) {
                        $id = $row->id;
                    }

                    $preuni = Pedido::join('clientes', 'clientes.id', '=', 'pedidos.cliente_id')
                        ->join('dato_clientes', 'dato_clientes.cliente_id', '=', 'clientes.id')
                        ->where('pedidos.estatus', '=', "En Espera")
                        ->groupBy('pedidos.fecha_compra', 'pedidos.cliente_id', 'pedidos.estatus', 'dato_clientes.user_id')
                        ->orderby('pedidos.fecha_compra', 'desc')
                        ->select(DB::raw('count(*) as CantidadProductos, round( IFNULL( SUM(pedidos.precio_total),0),2) as PrecioTotal, pedidos.cliente_id, pedidos.estatus, pedidos.fecha_compra, dato_clientes.user_id'))
                        ->get();

                    $pedidoHecho = Pedido::join('clientes', 'clientes.id', '=', 'pedidos.cliente_id')
                        ->join('dato_clientes', 'dato_clientes.cliente_id', '=', 'clientes.id')
                        ->where('pedidos.estatus', '=', "PedidoHecho")
                        ->groupBy('pedidos.fecha_compra', 'pedidos.cliente_id', 'pedidos.estatus', 'dato_clientes.user_id')
                        ->orderby('pedidos.fecha_compra', 'desc')
                        ->select("pedidos.cliente_id", "pedidos.estatus", "pedidos.fecha_compra", 'dato_clientes.user_id')
                        ->paginate(20);
                }
            }




            $conjunto_variables = compact('inventarios', 'productos', 'categorias', 'invmas', 'invmen', 'can', 'identificador', 'comprobar', 'preuni', 'pedidoHecho');


            return response()->json($conjunto_variables, 200);
        }

        return view('pages.index');
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
        $cliente = new Cliente();
        $cliente->cli_nombres = $request->nombre;
        $cliente->cli_apellidos = $request->apellido;
        $cliente->cli_celular = $request->celular;
        $cliente->cli_usuario = $request->email;
        $cliente->cli_password = $request->password;
        $cliente->save();

        $dato = new DatoCliente();
        $dato->direccion = $request->direccion;
        $dato->ci = $request->ci;
        $dato->cliente_id = $cliente->id;
        $dato->save();

        return $cliente->id;
    }


    public function entrarlogin(Request $request)
    {
        if ($request->email != "") {
            if ($request->password != "") {
                $datos = Cliente::where('cli_usuario', '=', $request->email)->where('cli_password', '=', $request->password)->get();
                if (sizeof($datos) <= 0) {
                    session(['comprobar' => false]);
                    return ['comprobar' => false, 'falla' => "Comprobar email o password"];
                } else {
                    session(['identificador' => $datos]);
                    session(['comprobar' => true]);
                    return ['comprobar' => true, 'datos' => $datos];
                }
            } else {
                session(['comprobar' => false]);
                return ['comprobar' => false, 'falla' => "Comprobar email o password"];
            }
        } else {
            session(['comprobar' => false]);
            return ['comprobar' => false, 'falla' => "Comprobar email o password"];
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
    }

    public function salircuenta(Request $request)
    {
        $request->session()->forget('dentificador');
        $request->session()->forget('comprobar');
    }
}
