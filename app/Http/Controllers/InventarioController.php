<?php

namespace Proyecto\Http\Controllers;

use Illuminate\Http\Request;
use Proyecto\Inventario;
use Proyecto\RegistroInventario;
use Proyecto\Producto;
use Proyecto\Categoria;
use Proyecto\Asignar;
use Proyecto\Oferta;


use Proyecto\EntradaInventario;
use Proyecto\SalidaInventario;
use Proyecto\SaldoInventario;
use Proyecto\Cliente;
use Proyecto\Toke;
use Proyecto\Mensaje;
use Proyecto\Perfil;
use Proyecto\User;
use Proyecto\KadexGeneral;


use DB;


class InventarioController extends Controller
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

                $categorias  = Categoria::orderby('nombre', 'asc')->get();;
                $productos  = Producto::orderby('nombre', 'asc')->get();
                $inventarios = Inventario::orderby('id', 'desc')->paginate(6);
                $inventariosPdf = Inventario::orderby('id', 'desc')->get();

                $clientes = Cliente::orderby('cli_nombres', 'asc')->paginate(6);


                $asignar  = Asignar::all();

                $iduser = $request->user()->id;

                $conjunto_variables = compact('inventarios','productos','categorias','asignar','iduser', 'inventariosPdf', 'clientes');

                return response()->json($conjunto_variables,200);

              }

              $asignasiones  = Asignar::all();

              $perfiles = Perfil::all();
              $usuarios = User::all();
                return view('inventarios.index',compact('usuarios','perfiles','asignasiones'));
              }
              else {
                $asignasiones  = Asignar::all();

                $perfiles = Perfil::all();
                $usuarios = User::all();
                  return view('common.401' ,compact('usuarios','perfiles','asignasiones'));
              }
    }


    public function search(){

      if ($search = \Request::get('q')) {

          $users = Inventario::join('productos', 'productos.id', '=', 'inventarios.producto_id')
          ->join('categorias', 'categorias.id', '=', 'productos.categoria_id')
          ->select('inventarios.id','inventarios.producto_id','inventarios.cantidad_unidad_caja','inventarios.cantidad_unidad_almacen',
          'inventarios.cantidad_caja_almacen','inventarios.cantidad_unidad_almacen_dis','inventarios.cantidad_caja_almacen_dis', 'inventarios.precio_compra_unidad',
          'inventarios.precio_venta_unidad','inventarios.fecha_vencimiento' , 'inventarios.status', 'inventarios.publicado')
          ->where(function($query) use ($search){
              $query->where('productos.nombre','LIKE',"%$search%")
              ->orwhere('productos.marca','LIKE',"%$search%")
              ->orwhere('categorias.nombre','LIKE',"%$search%");
          })->paginate(6);
      }else{
          $users = inventario::orderby('id', 'desc')->paginate(6);
      }
      return $users;

  }


    public function store(Request $request)
    {
      $this->validate($request,[
        'producto_id' => 'required',
        'cantidad_unidad_caja' => 'required',
        'cantidad_unidad_almacen' => 'required',
        'cantidad_caja_almacen' => 'required',
        'precio_compra_unidad' => 'required',
        'precio_venta_unidad' => 'required',
        //'fecha_vencimiento' => 'required',
      ]);

      $inventario = new Inventario();
      $inventario->producto_id=$request->producto_id;
      $inventario->cantidad_unidad_caja=$request->cantidad_unidad_caja;
      
      $inventario->cantidad_unidad_almacen=$request->cantidad_unidad_almacen;
      $inventario->cantidad_caja_almacen=$request->cantidad_caja_almacen;

      $inventario->cantidad_unidad_almacen_dis=$request->cantidad_unidad_almacen;
      $inventario->cantidad_caja_almacen_dis=$request->cantidad_caja_almacen;

      $inventario->precio_compra_unidad=$request->precio_compra_unidad;
      $inventario->precio_venta_unidad=$request->precio_venta_unidad;
      $inventario->fecha_vencimiento=$request->fecha_vencimiento;

      $inventario->status='Disponible';
      $inventario->publicado='No';
      $inventario->save();

      $entrada = new EntradaInventario();
      $entrada->cantidad_unidad=$request->cantidad_unidad_almacen;
      $entrada->cantidad_caja=$request->cantidad_caja_almacen;
      $entrada->precio_compra_unidad=$request->precio_compra_unidad;
      $entrada->precio_venta_unidad=$request->precio_venta_unidad;
      $entrada->inventario_id= $inventario->id;
     $entrada->save();

      $saldo = new SaldoInventario();
      $saldo->cantidad_total=$request->cantidad_unidad_almacen;
      $saldo->saldototal=$request->cantidad_unidad_almacen*$request->precio_compra_unidad;
      $saldo->saldototalventa=$request->cantidad_unidad_almacen*$request->precio_venta_unidad;
      $saldo->status='Inicio';
      $saldo->precioanterior=$request->precio_venta_unidad;
      $saldo->inventario_id= $inventario->id;
      $saldo->save();

      
      $kardex=new KadexGeneral();
      $kardex->inventario_id= $inventario->id;
      $kardex->cantidad_unidad_entrada=$request->cantidad_unidad_almacen;
      $kardex->cantidad_caja_entrada=$request->cantidad_caja_almacen;
      $kardex->precio_compra_unidad_entrada=$request->precio_compra_unidad;
      $kardex->precio_venta_unidad_entrada=$request->precio_venta_unidad;
      $kardex->cantidad_total=$request->cantidad_unidad_almacen;
      $kardex->saldototal=$request->cantidad_unidad_almacen*$request->precio_compra_unidad;
      $kardex->saldototalventa=$request->cantidad_unidad_almacen*$request->precio_venta_unidad;
      $kardex->status='Inicio';
      $kardex->precioanterior=$request->precio_venta_unidad;
      $kardex->inventario_id= $inventario->id;
      $kardex->save();


      
///--------------Notificaciones

/*
      $send =  Cliente::join('tokes','tokes.cliente_id','=','clientes.id')
      ->select('clientes.id','clientes.cli_usuario','tokes.tokens')
      ->orderby('clientes.id', 'asc')->get();

      

      $titulo='Productos Nuevos';

      $productos = Producto::findOrFail($request->producto_id);
     
      $descripcion = $productos->nombre.' - '.$productos->marca;

      
      $imagen=$productos->avatarurl;
      
      $tipo='Productos';
      $ban=1;
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


      }*/

      return $inventario;
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
      $this->validate($request,[
        'producto_id' => 'required',
        'cantidad_unidad_caja' => 'required',
        'cantidad_unidad_almacen' => 'required',
        'cantidad_caja_almacen' => 'required',
        'precio_compra_unidad' => 'required',
        'precio_venta_unidad' => 'required',
        //'fecha_vencimiento' => 'required',
      ]);

      $aux1 = Inventario::where('id','=',$id)
        ->orderby('id', 'desc')->take(1)
        ->get();

        foreach($aux1 as $row1)
        {
          $un1=$row1->cantidad_unidad_almacen_dis;
          $caj1=$row1->cantidad_caja_almacen_dis;
          $preci1=$row1->precio_venta_unidad;
        }
      
      $aux = SaldoInventario::where('inventario_id','=',$id)
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
        $saldo->cantidad_total=$request->cantidad_unidad_almacen + $ca;
        $saldo->saldototal=($request->cantidad_unidad_almacen*$request->precio_compra_unidad)+$saluax;
        $saldo->saldototalventa=($request->cantidad_unidad_almacen*$request->precio_venta_unidad)+$saluax1;
        $saldo->status='Entrada';
        $saldo->precioanterior=$preci1;
        $saldo->inventario_id= $id;
        $saldo->save();


        $entrada = new EntradaInventario();
        $entrada->cantidad_unidad=$request->cantidad_unidad_almacen;
        $entrada->cantidad_caja=$request->cantidad_caja_almacen;
        $entrada->precio_compra_unidad=$request->precio_compra_unidad;
        $entrada->precio_venta_unidad=$request->precio_venta_unidad;
        $entrada->inventario_id= $id;
        $entrada->save();
        

        $kardex=new KadexGeneral();
        $kardex->inventario_id= $id;
        $kardex->cantidad_unidad_entrada=$request->cantidad_unidad_almacen;
        $kardex->cantidad_caja_entrada=$request->cantidad_caja_almacen;
        $kardex->precio_compra_unidad_entrada=$request->precio_compra_unidad;
        $kardex->precio_venta_unidad_entrada=$request->precio_venta_unidad;

        $kardex->cantidad_total=$request->cantidad_unidad_almacen + $ca;
        $kardex->saldototal=($request->cantidad_unidad_almacen*$request->precio_compra_unidad)+$saluax;
        $kardex->saldototalventa=($request->cantidad_unidad_almacen*$request->precio_venta_unidad)+$saluax1;
        $kardex->status='Entrada';
        $kardex->precioanterior=($saldo->saldototalventa/$saldo->cantidad_total);
        
        $kardex->save();

        


      $regInventario = Inventario::findOrFail($id);

//      $regInventario->cantidad_unidad_caja=$request->cantidad_unidad_caja;

      $regInventario->cantidad_unidad_almacen=$request->cantidad_unidad_almacen;
      $regInventario->cantidad_caja_almacen=$request->cantidad_caja_almacen;

      $regInventario->cantidad_unidad_almacen_dis=$request->cantidad_unidad_almacen+$un1;
      $regInventario->cantidad_caja_almacen_dis=$request->cantidad_caja_almacen+$caj1;

      $regInventario->precio_compra_unidad=$request->precio_compra_unidad;
      $regInventario->precio_venta_unidad=($saldo->saldototalventa/$saldo->cantidad_total);
      $regInventario->fecha_vencimiento=$request->fecha_vencimiento;
      $regInventario->save();

      

      /// NOTIFICACION -------------------------------------------------------------

/*
        
      $send =  Cliente::join('tokes','tokes.cliente_id','=','clientes.id')
      ->select('clientes.id','clientes.cli_usuario','tokes.tokens')
      ->orderby('clientes.id', 'asc')->get();

      

      $titulo='Llegaron Productos...!!!';

      $productos = Producto::findOrFail($regInventario->producto_id);
     
      $descripcion = $productos->nombre.' - '.$productos->marca;

      
      $imagen=$productos->avatarurl;
      
      $tipo='Productos';
      $ban=1;
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


      */


      return $regInventario;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

      $inventario = Inventario::findOrFail($id);
      $inventario->delete();

      return ['message' => 'Inventario Eliminados'];
    }

    public function ofertasCreate(Request $request){

      $this->validate($request,[
        'precio_venta_unidad' => 'required',
        'cantidad_unidadxcaja' => 'required',
   
        'inventario_id' => 'required',
      ]);

      //dd($request);

                $oferta = new Oferta();
                $oferta->precio_venta_nuevo=$request->precio_venta_unidad;
                $oferta->cantidad_unidadxcaja=$request->cantidad_unidadxcaja;
                $oferta->unidad_almacen="0";
                $oferta->caja_almacen="0";
                $oferta->unidad_disponible="0";
                $oferta->caja_disponible="0";
                $oferta->oferta=$request->oferta;
                $oferta->status='Disponible';
                $oferta->fecha=$request->fecha;
                $oferta->inventario_id=$request->inventario_id;
                $oferta->save();



                //-------------------------- Notificaciones-------------------
        
                $send =  Cliente::join('tokes','tokes.cliente_id','=','clientes.id')
                ->select('clientes.id','clientes.cli_usuario','tokes.tokens')
                ->orderby('clientes.id', 'asc')->get();
          
                $inventario=Inventario::findOrFail($request->inventario_id);
          
                $titulo='Productos Descuentos Ofertas - '.$request->oferta;
          
                $productos = Producto::findOrFail($inventario->producto_id);
               
                $descripcion = $productos->nombre.' - '.$productos->marca;
          
                
                $imagen=$productos->avatarurl;
                
                $tipo='Productos';
                $ban=1;
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
                return $oferta;

    }


    public function salidaProducto(Request $request){

      $this->validate($request,[
        'precio_venta_unidad' => 'required',
        'cantidad_unidadxcaja' => 'required',
        'cantidad_unidad_almacen' => 'required',
        'cantidad_caja_almacen' => 'required',
        'inventario_id' => 'required',
      ]);

      $aux1 = Inventario::where('id','=',$request->inventario_id)
      ->orderby('id', 'desc')->take(1)
      ->get();

      foreach($aux1 as $row1)
      {
        $un1=$row1->cantidad_unidad_almacen_dis;
        $caj1=$row1->cantidad_caja_almacen_dis;
        $preci1=$row1->precio_venta_unidad;
      }


        $aux = SaldoInventario::where('inventario_id','=',$request->inventario_id)
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
        $saldo->cantidad_total = ($ca-$request->cantidad_unidad_almacen);
        $saldo->saldototal= $saluax-($request->cantidad_unidad_almacen*$request->precio_compra_unidad);
        $saldo->saldototalventa=$saluax1-($request->cantidad_unidad_almacen*$request->precio_venta_unidad);
        $saldo->status='Salida';
        $saldo->precioanterior=$request->precio_venta_unidad;
        $saldo->inventario_id= $request->inventario_id;
        $saldo->save();


        $salida = new SalidaInventario();
        $salida->cantidad_unidad=$request->cantidad_unidad_almacen;
        $salida->cantidad_caja=$request->cantidad_caja_almacen;
        $salida->precio_venta_unidad=$request->precio_venta_unidad;
        $salida->detalle=$request->detalle;
        $salida->status='Negativo';
        $salida->inventario_id= $request->inventario_id;
        $salida->save();


        $kardex=new KadexGeneral();
        $kardex->inventario_id= $request->inventario_id;
        $kardex->cantidad_unidad_salida=$request->cantidad_unidad_almacen;
        $kardex->cantidad_caja_salida=$request->cantidad_caja_almacen;
        $kardex->precio_venta_unidad_salida=$request->precio_venta_unidad;
        $kardex->detalle_salida=$request->detalle;
        $kardex->status_salida='Negativo';

        $kardex->cantidad_total = ($ca-$request->cantidad_unidad_almacen);
        $kardex->saldototal= $saluax-($request->cantidad_unidad_almacen*$request->precio_compra_unidad);
        $kardex->saldototalventa=$saluax1-($request->cantidad_unidad_almacen*$request->precio_venta_unidad);
        $kardex->status='Salida';
        $kardex->precioanterior=$request->precio_venta_unidad;
        
        $kardex->save();
        
        

        $aux1 = Inventario::where('id','=',$request->inventario_id)
      ->orderby('id', 'desc')->take(1)
      ->get();

      foreach($aux1 as $row1)
      {
        $un1=$row1->cantidad_unidad_almacen_dis;
        $caj1=$row1->cantidad_caja_almacen_dis;
        $preci1=$row1->precio_venta_unidad;
      }


      $regInventario = Inventario::findOrFail($request->inventario_id);


      $regInventario->cantidad_unidad_almacen_dis= $un1-  $request->cantidad_unidad_almacen;
      $regInventario->cantidad_caja_almacen_dis= $caj1- $request->cantidad_caja_almacen;


      if($un1-  $request->cantidad_unidad_almacen==0){
        $regInventario->status='Agotado';
      }

      $regInventario->save();

      



      return $regInventario;

    }

    public  function consultaFiltros(Request $request){

      if( $request->publicar=="Si" || $request->publicar=="No" ){
        //dd('enhtroo');
        return Inventario::join('productos', 'productos.id', '=', 'inventarios.producto_id')
          ->select(DB::raw('inventarios.id,inventarios.producto_id,inventarios.cantidad_unidad_caja,inventarios.cantidad_unidad_almacen,
          inventarios.cantidad_caja_almacen,inventarios.cantidad_unidad_almacen_dis,inventarios.cantidad_caja_almacen_dis,inventarios.precio_compra_unidad,
          inventarios.precio_venta_unidad,inventarios.fecha_vencimiento, inventarios.publicado'))
          ->where('inventarios.publicado','=',$request->publicar)
          ->orderby('inventarios.id','desc')
          ->paginate(6);
      }

      //dd($request->publicar);
      if($request->mas=="mas"){
        if($request->val=="cantidad"){

          return Inventario::join('productos', 'productos.id', '=', 'inventarios.producto_id')
          ->join('salida_inventarios', 'salida_inventarios.inventario_id', '=', 'inventarios.id')
          ->select(DB::raw('inventarios.id,inventarios.producto_id,inventarios.cantidad_unidad_caja,inventarios.cantidad_unidad_almacen,
          inventarios.cantidad_caja_almacen,inventarios.cantidad_unidad_almacen_dis,inventarios.cantidad_caja_almacen_dis,inventarios.precio_compra_unidad,
          inventarios.precio_venta_unidad,inventarios.fecha_vencimiento, (sum(salida_inventarios.cantidad_unidad)) as cant , inventarios.publicado'))
          ->where('salida_inventarios.status','=','Positivo')
          ->groupby('inventarios.id')->orderby('cant','desc')
          ->paginate(6);
        }
        if($request->val=="precio"){

          return Inventario::join('productos', 'productos.id', '=', 'inventarios.producto_id')
          ->join('salida_inventarios', 'salida_inventarios.inventario_id', '=', 'inventarios.id')
          ->select(DB::raw('inventarios.id,inventarios.producto_id,inventarios.cantidad_unidad_caja,inventarios.cantidad_unidad_almacen,
          inventarios.cantidad_caja_almacen,inventarios.cantidad_unidad_almacen_dis,inventarios.cantidad_caja_almacen_dis,inventarios.precio_compra_unidad,
          inventarios.precio_venta_unidad,inventarios.fecha_vencimiento, (sum(salida_inventarios.precio_venta_unidad)*(sum(salida_inventarios.cantidad_unidad))) as cant , inventarios.publicado'))
          ->where('salida_inventarios.status','=','Positivo')
          ->groupby('inventarios.id')->orderby('cant','desc')
          ->paginate(6);
        }

      }

      if($request->mas=="menos"){
          
        if($request->val=="salida"){
          return Inventario::join('productos', 'productos.id', '=', 'inventarios.producto_id')
          ->join('salida_inventarios', 'salida_inventarios.inventario_id', '=', 'inventarios.id')
          ->select(DB::raw('inventarios.id,inventarios.producto_id,inventarios.cantidad_unidad_caja,inventarios.cantidad_unidad_almacen,
          inventarios.cantidad_caja_almacen,inventarios.cantidad_unidad_almacen_dis,inventarios.cantidad_caja_almacen_dis,inventarios.precio_compra_unidad,
          inventarios.precio_venta_unidad,inventarios.fecha_vencimiento, (sum(salida_inventarios.cantidad_unidad)) as cant, inventarios.publicado'))
          ->where('salida_inventarios.status','=','Positivo')
          ->groupby('inventarios.id')->orderby('cant','asc')
          ->paginate(6);
        }
        if($request->val=="sinsalida"){
          /*$datos = DB::select(DB::raw(("Select i.id,i.producto_id,i.cantidad_unidad_caja,i.cantidad_unidad_almacen,
          i.cantidad_caja_almacen,i.cantidad_unidad_almacen_dis,i.cantidad_caja_almacen_dis,i.precio_compra_unidad,
          i.precio_venta_unidad,i.fecha_vencimiento , i.publicado FROM inventarios as i INNER JOIN productos as p ON p.id=i.producto_id 
          LEFT JOIN (SELECT inventario_id FROM salida_inventarios where status='Positivo')  as sal ON i.id=sal.inventario_id  
          WHERE  sal.inventario_id is null Group By i.id")));
          return array('data'=>$datos);*/

          return Inventario::join('productos', 'productos.id', '=', 'inventarios.producto_id')
          ->leftJoin(DB::raw('(SELECT inventario_id FROM salida_inventarios where status="Positivo") as sal '), 'sal.inventario_id','=','inventarios.id')
          ->select(DB::raw('inventarios.id,inventarios.producto_id,inventarios.cantidad_unidad_caja,inventarios.cantidad_unidad_almacen,
          inventarios.cantidad_caja_almacen,inventarios.cantidad_unidad_almacen_dis,inventarios.cantidad_caja_almacen_dis,inventarios.precio_compra_unidad,
          inventarios.precio_venta_unidad,inventarios.fecha_vencimiento, inventarios.publicado'))
          ->whereRaw('sal.inventario_id is null')
          ->groupby('inventarios.id')
          ->paginate(6);

        }
      }

      if($request->min>=0 && $request->max==""){
        return Inventario::join('productos', 'productos.id', '=', 'inventarios.producto_id')
          ->select(DB::raw('inventarios.id,inventarios.producto_id,inventarios.cantidad_unidad_caja,inventarios.cantidad_unidad_almacen,
          inventarios.cantidad_caja_almacen,inventarios.cantidad_unidad_almacen_dis,inventarios.cantidad_caja_almacen_dis,inventarios.precio_compra_unidad,
          inventarios.precio_venta_unidad,inventarios.fecha_vencimiento, inventarios.publicado'))
          ->where('inventarios.precio_venta_unidad','>=',$request->min)
          ->orderby('inventarios.precio_venta_unidad','asc')
          ->paginate(6);
      }

      if($request->min=="" && $request->max<=10000){
        return Inventario::join('productos', 'productos.id', '=', 'inventarios.producto_id')
          ->select(DB::raw('inventarios.id,inventarios.producto_id,inventarios.cantidad_unidad_caja,inventarios.cantidad_unidad_almacen,
          inventarios.cantidad_caja_almacen,inventarios.cantidad_unidad_almacen_dis,inventarios.cantidad_caja_almacen_dis,inventarios.precio_compra_unidad,
          inventarios.precio_venta_unidad,inventarios.fecha_vencimiento, inventarios.publicado'))
          ->where('inventarios.precio_venta_unidad','<=',$request->max)
          ->orderby('inventarios.precio_venta_unidad','asc')
          ->paginate(6);
      }

      if($request->min>0 && $request->max<=10000){
        return Inventario::join('productos', 'productos.id', '=', 'inventarios.producto_id')
          ->select(DB::raw('inventarios.id,inventarios.producto_id,inventarios.cantidad_unidad_caja,inventarios.cantidad_unidad_almacen,
          inventarios.cantidad_caja_almacen,inventarios.cantidad_unidad_almacen_dis,inventarios.cantidad_caja_almacen_dis,inventarios.precio_compra_unidad,
          inventarios.precio_venta_unidad,inventarios.fecha_vencimiento, inventarios.publicado'))
          ->where('inventarios.precio_venta_unidad','>=',$request->min)
          ->where('inventarios.precio_venta_unidad','<=',$request->max)
          ->orderby('inventarios.precio_venta_unidad','asc')
          ->paginate(6);
      }



     
    }

    public  function notificarCliente(Request $request){

      if($request->cliente==1){
      
          $send =  Cliente::join('tokes','tokes.cliente_id','=','clientes.id')
          ->select('clientes.id','clientes.cli_usuario','tokes.tokens')
          ->orderby('clientes.id', 'asc')->get();

          $titulo=$request->titulo;
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
      if($request->cliente==2){

        $send = Inventario::join('inventario_pedido','inventario_pedido.inventario_id','=','inventarios.id')
          ->join('pedidos','pedidos.id','=','inventario_pedido.pedido_id')
          ->join('clientes','clientes.id','=','pedidos.cliente_id')
          ->join('tokes','tokes.cliente_id','=','clientes.id')
          ->select(DB::raw('Distinct tokes.id as tokens, clientes.id,clientes.cli_usuario, tokes.tokens'))
          ->where('inventarios.id','=',$request->id)
          ->get();

        
        $titulo=$request->titulo;
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
      if($request->cliente==3){
              $send = Clientes::join('tokes','tokes.cliente_id','=','clientes.id')
              ->leftJoin(DB::raw('(SELECT cliente_id FROM pedidos) as p '), 'p.cliente_id','=','clientes.id')
              ->select(DB::raw('Distinct tokes.id as tokens, clientes.id,clientes.cli_usuario, tokes.tokens'))
              ->whereRaw('p.cliente_id is null')
              ->get();

            
            $titulo=$request->titulo;
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
      if($request->cliente==4){ 
        $send =  Cliente::join('tokes','tokes.cliente_id','=','clientes.id')
        ->select('clientes.id','clientes.cli_usuario','tokes.tokens')
        ->where('clientes.id','=',$request->cliente_id)
        ->get();

        $titulo=$request->titulo;
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



  public function pdfResumido(Request $request)
 {
      $fecha = date('d-m-Y H:i');
      $inventario=$request->inventarios;
      $producto=$request->productos;

      
      $pdf = \PDF::loadView('pdfs.pdfresumido', compact('fecha','inventario','producto'));

      $name=time();
      $pdf->setPaper('later', 'portrait')->save(public_path().'/reporteventas/resumido_'.$name.'.pdf');

      return "/reporteventas/resumido_$name.pdf";


  }

  public function estado($id)
    {
      $inventario = Inventario::findOrFail($id);

      if($inventario->publicado=='Si'){
        $inventario->publicado='No';
      }else{
        $inventario->publicado='Si';
      }

      $inventario->save();

      return ['message' => 'Cambio Correcto'];

    }

}
