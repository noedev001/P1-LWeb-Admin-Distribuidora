<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/', function () {
    return view('welcome');
});

Route::resource('users', 'UsersController');
Route::get('findUser', 'UsersController@search');
Route::post('imagenPerfil', 'UsersController@imagenPerfil')->name('users.imagenPerfil');


Route::resource('categorias', 'CategoriasController');
Route::get('findBusqueda', 'CategoriasController@search');



Route::resource('productos', 'ProductoController');
Route::get('findBusquedaProd', 'ProductoController@search');
Route::post('updateProducto', 'ProductoController@updateProducto')->name('productos.updateProducto');

Route::resource('biblioteca', 'BibliotecaController');
Route::get('findBusquedaBib', 'BibliotecaController@search');

Route::resource('inventarios', 'InventarioController');
Route::get('findUser', 'InventarioController@search');
Route::post('ofertasCreate', 'InventarioController@ofertasCreate')->name('inventarios.ofertasCreate');
Route::post('salidaProducto', 'InventarioController@salidaProducto')->name('inventarios.salidaProducto');
Route::post('consultaFiltros', 'InventarioController@consultaFiltros')->name('inventarios.consultaFiltros');
Route::post('notificarCliente', 'InventarioController@notificarCliente')->name('inventarios.notificarCliente');
Route::post('pdfResumido', 'InventarioController@pdfResumido')->name('pdfResumido');
Route::get('inventarios/estado/{id}', 'InventarioController@estado')->name('inventarios.estado');



Route::resource('ofertas', 'OfertaController');
Route::get('findUser', 'OfertaController@search');
Route::post('cambiarStado', 'OfertaController@cambiarStado')->name('inventarios.cambiarStado');
Route::post('notificarClienteOfe', 'OfertaController@notificarClienteOfe')->name('inventarios.notificarClienteOfe');

Route::resource('pedidos', 'PedidoController');
Route::post('update', 'PedidoController@update')->name('pedidos.update');
Route::post('createArticulo', 'PedidoController@createArticulo')->name('pedidos.createArticulo');
Route::get('pedidos/eliminarArticulo/{id}', 'PedidoController@eliminarArticulo')->name('pedidos.eliminarArticulo');
Route::post('updateArticulo', 'PedidoController@updateArticulo')->name('pedidos.updateArticulo');
Route::post('eliminarPedido', 'PedidoController@eliminarPedido')->name('pedidos.eliminarPedido');
//Route::post('pdf','VentasController@pdf')->name('pdf');


Route::resource('cuentas', 'CuentaController');
Route::get('busquedaPagos', 'CuentaController@search');
Route::post('pagonotificacion', 'CuentaController@pagonotificacion');


Route::resource('ventas', 'VentasController');
Route::post('pdf', 'VentasController@pdf')->name('pdf');
Route::get('busquedaVentas', 'VentasController@search');


Route::resource('sugerencias', 'SugerenciaController');
Route::get('busquedaSugerencias', 'SugerenciaController@search');

Route::resource('clientes', 'ClientesController');
Route::get('busquedaClientes', 'ClientesController@search');




Route::resource('pagos', 'PagosController');
Route::get('busquedalistaPagos', 'PagosController@search');


Route::resource('reportes', 'ReportesController');
Route::get('busquedareportes', 'ReportesController@search');
Route::post('pdfReportes', 'ReportesController@pdfReportes')->name('pdfReportes');


Route::resource('mercaderias', 'MercaderiaController');
Route::get('busquedamercaderia', 'MercaderiaController@search');
Route::post('pdfReportesentrada', 'MercaderiaController@pdfReportesentrada')->name('pdfReportesentrada');


Route::resource('bitacoras', 'BitacoraController');
Route::get('busquedabitacora', 'BitacoraController@search');


Route::resource('kardex', 'KardexController');
Route::post('pdfKardex', 'KardexController@pdfKardex')->name('pdfKardex');


Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::post('guardar', 'Auth\RegisterController@guardar')->name('guardar');

Auth::routes();


Route::get('/home', 'HomeController@index')->name('home');
Route::post('mensajes', 'HomeController@mensajes')->name('mensajes');


Route::resource('notificaciones', 'NotificacionController');


Route::resource('pagecliente', 'PageController');
Route::post('entrarlogin', 'PageController@entrarlogin')->name('entrarlogin');
Route::get('salircuenta', 'PageController@salircuenta');
