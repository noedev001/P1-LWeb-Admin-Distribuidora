<template>

<div>
    <div class="chat-room mt">
        <aside class="mid-side">
            <div class="chat-room-head">
                <h3>Pedidos: Support</h3>

            </div>

            <div class="room-desk">
                <h4 class="pull-left">Lista de Productos</h4>

                <div v-for="a in asignar" v-if="a.user_id==iduser">
                  <div v-if="a.rol_asignacion=='SuperAdmin' || a.rol_asignacion=='Admin'">

                    <a href="#" class="pull-right btn btn-theme02" data-toggle="modal" data-target="#myModalShowNuevoArticulo" v-show="Infopedido.cli_id!=''" >+ Añadir Nuevo Articulo</a>
                    </div>
                </div>
                <div v-for="a in asignar" v-if="a.user_id==iduser">
                <div v-if="a.rol_asignacion=='Dist' ">
                <div v-for="(pe, aux) in pedidos" v-if="pe.cliente_id==Infopedido.cli_id && pe.fecha_compra==Infopedido.fe_compra && pe.estatus=='PedidoHecho' && pe.user_id==iduser">
                    <a href="#" data-toggle="modal" data-target="#myModalShow" @click="updateShow(pe)">
                        <div class="room-box">

                            <h5 class="text-primary" v-for="ped in detalle[aux].inventarios">
                            <p v-for="inv in inventarios" v-if="inv.id==ped.id">
                                <label v-for="pro in productos" v-if="inv.producto_id==pro.id">{{pro.nombre}}</label>

                                <label class="label label-danger" v-if="pe.oferta!=0"> Producto en Oferta </label>

                               
                            </p>
                            </h5>
                            <div v-for="ped in detalle[aux].inventarios">
                                <p v-for="inv in inventarios" v-if="inv.id==ped.id">
                                    <label v-for="pro in productos" v-if="inv.producto_id==pro.id">
                                        <label class="label label-success">{{pro.marca}}</label>
                                        <label class="label label-primary">{{pro.modelo}}</label>
                                        <label class="label label-theme">{{pro.medida}}</label>
                                    </label>

                                    <label style="color:#000;"> Articulos Por caja: {{inv.cantidad_unidad_caja}}</label>
                                </p>

                            </div>
                            <p>
                                <span class="text-muted">Precio Unidad : </span> {{pe.precio_unidad}} Bs. |
                                <span class="text-muted">Precio Total : </span> {{pe.precio_total}} Bs. |
                                <span class="text-muted" v-show="pe.cantidad_caja>0">Cantidad Pedido Caja :  {{pe.cantidad_caja}} </span>
                                <span class="text-muted" v-show="pe.cantidad_unidad>0">Cantidad Pedido Unidad :  {{pe.cantidad_unidad}} </span>
                            </p>

                        </div>
                    </a>
                </div>
                  </div>
                </div>

                <div v-for="a in asignar" v-if="a.user_id==iduser">
                <div v-if="a.rol_asignacion=='SuperAdmin' || a.rol_asignacion=='Admin'">
                <div v-for="(pe, aux) in pedidos" v-if="pe.cliente_id==Infopedido.cli_id && pe.fecha_compra==Infopedido.fe_compra && pe.estatus=='PedidoHecho' ">
                    <a href="#" data-toggle="modal" data-target="#myModalShow" @click="updateShow(pe)">
                        <div class="room-box">

                            <h5 class="text-primary" v-for="ped in detalle[aux].inventarios">
                  <p v-for="inv in inventarios" v-if="inv.id==ped.id">
                    <label v-for="pro in productos" v-if="inv.producto_id==pro.id">{{pro.nombre}}</label>

                    <label class="label label-danger" v-if="pe.oferta!=0"> Producto en Oferta </label>

                    <label class="pull-right " style="font-size: 13px;" v-show="pe.cantidad_unidad>0">Unidades Disponibles: {{inv.cantidad_unidad_almacen_dis}}</label>
                    <label class="pull-right " style="font-size: 13px;" v-show="pe.cantidad_caja>0">Cajas Disponibles: {{inv.cantidad_caja_almacen_dis}}</label>
                  </p>
                </h5>
                            <div v-for="ped in detalle[aux].inventarios">
                                <p v-for="inv in inventarios" v-if="inv.id==ped.id">
                                    <label v-for="pro in productos" v-if="inv.producto_id==pro.id">
                                        <label class="label label-success">{{pro.marca}}</label>
                                        <label class="label label-primary">{{pro.modelo}}</label>
                                        <label class="label label-theme">{{pro.medida}}</label>
                                    </label>

                                    <label style="color:#000;"> Articulos Por caja: {{inv.cantidad_unidad_caja}}</label>
                                </p>

                            </div>
                            <p>
                                <span class="text-muted">Precio Unidad : </span> {{pe.precio_unidad}} Bs. |
                                <span class="text-muted">Precio Total : </span> {{pe.precio_total}} Bs. |
                                <span class="text-muted" v-show="pe.cantidad_caja>0">Cantidad Pedido Caja :  {{pe.cantidad_caja}} </span>
                                <span class="text-muted" v-show="pe.cantidad_unidad>0">Cantidad Pedido Unidad :  {{pe.cantidad_unidad}} </span>
                            </p>

                        </div>
                    </a>
                </div>
                  </div>
                </div>
                


            </div>


                <div class="room-desk" v-for="can in precantida" v-if="can.cliente_id==Infopedido.cli_id && Infopedido.fe_compra==can.fecha_compra ">
                    
                    <div v-for="a in asignar" v-if="a.user_id==iduser">
                        <div v-if="a.rol_asignacion=='SuperAdmin' || a.rol_asignacion=='Admin'">
                            <div class="group-rom">
                                <div class="first-part odd">Numero de Productos </div>
                                <div class="second-part">{{can.CantidadProductos}}</div>
                            </div>
                            <div class="group-rom last-group">
                                <div class="first-part odd">Precio Total</div>
                                <div class="second-part odd" style="color:#000;">
                                    <h3 style="margin-bottom: 15px;margin-top: 0px;">{{can.PrecioTotal}} bs.</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <footer class="fottt" style="width: 75%;" v-show="ocultar">
                    <div v-for="a in asignar" v-if="a.user_id==iduser">
                        <div v-if="a.rol_asignacion=='SuperAdmin' || a.rol_asignacion=='Admin'">
                            <button class="btn btn-theme" @click="entregarPedido()"><span class="fa fa-check"></span> Entregar Pedido</button>
                            <button class="btn btn-danger" @click="eliminarPedido()"><span class="fa fa-trash-o"></span> Eliminar Pedido</button>
                        </div>
                    </div>
                </footer>



            <!-- Show and Edith detalle producto -->
            <div class="modal fade" id="myModalShow" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel"> <i class="fa fa-stack-overflow"></i>&nbsp Detalle Producto</h4>
                        </div>
                        <div class="modal-body">

                            <div>
                                <div class="room-desk" v-for="(pe,index) in pedidos" v-if="pe.id==detalle_pedido.pedido_id  && pe.estatus=='PedidoHecho'">
                                    <div v-for="de in detalle[index].inventarios">
                                        <div class="group-rom" v-for="inv in inventarios" v-if="inv.id==de.id">
                                            <div class="first-part odd">Nombre del Producto</div>
                                            <div class="second-part" v-for="pro in productos" v-if="inv.producto_id==pro.id">{{pro.nombre}}</div>

                                            <input type="hidden" v-model="pe.id">
                                        </div>
                                        <div class="group-rom" v-for="inv in inventarios" v-if="inv.id==de.id">
                                            <div class="first-part odd">Marca</div>
                                            <div class="second-part" v-for="pro in productos" v-if="inv.producto_id==pro.id">{{pro.marca}}</div>
                                        </div>
                                        <div class="group-rom" v-for="inv in inventarios" v-if="inv.id==de.id">
                                            <div class="first-part odd">Medida</div>
                                            <div class="second-part" v-for="pro in productos" v-if="inv.producto_id==pro.id">
                                               <label v-if="pro.medida!=null">{{pro.medida}}</label>
                                               <label v-if="pro.medida==null">...</label>
                                            </div>
                                        </div>

                                        <div class="group-rom" v-for="inv in inventarios" v-if="inv.id==de.id">
                                            <div class="first-part odd">Cantidad Unidad por Caja</div>
                                            <div class="second-part">{{detalle_pedido.cantidad=inv.cantidad_unidad_caja}}</div>
                                        </div>

                                      <div class="group-rom" v-show="pe.cantidad_unidad>0">
                                            <div class="first-part odd">Unidades Pedidas : </div>
                                            <div class="second-part">
                                                <input type="text" v-model="detalle_pedido.cantidad_unidad" v-on:keyup="validarUnidad">
                                            </div>
                                            <div class="third-part lec" v-for="inv in inventarios" v-if="inv.id==de.id">

                                                <label > Unidades Disponible: {{disproduct.dis_unidad=inv.cantidad_unidad_almacen_dis}}</label>
                                               
                                            </div>
                                        </div>
                                        <div class="group-rom" v-show="pe.cantidad_caja>0">
                                            <div class="first-part odd">Cajas Pedidas : {{pe.cantidad_caja}}</div>
                                            <div class="second-part">
                                                <input type="text" v-model="detalle_pedido.cantidad_caja" v-on:keyup="validarCaja">
                                            </div>
                                            <div class="third-part lec" v-for="inv in inventarios" v-if="inv.id==de.id">
                                              <label > Caja Disponible: {{disproduct.dis_caja=inv.cantidad_caja_almacen_dis}}</label>
                                              
                                            </div>
                                        </div>

                                        <div class="group-rom">
                                            <div class="first-part odd">Producto</div>
                                            <div class="second-part" v-for="inv in inventarios" v-if="inv.id==de.id">
                                                <p v-for="pro in productos" v-if="inv.producto_id==pro.id"><img class="img-responsive" :src="`/images/product/${pro.avatar}`" alt=""></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="group-rom">
                                        <div class="first-part odd">Precio por Unidad</div>
                                        <div class="second-part">
                                            <input type="text" v-model="detalle_pedido.precio_unidad" v-on:keyup="validarPrecio"> bs.</div>
                                    </div>
                                    <div class="group-rom last-group">
                                        <div class="first-part odd">Precio Total</div>
                                        <div class="second-part odd" style="color:#000;">
                                            <h3>{{detalle_pedido.precio_total}} bs.</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">

                                    
                            <div v-for="a in asignar" v-if="a.user_id==iduser">
                                <div v-if="a.rol_asignacion=='SuperAdmin' || a.rol_asignacion=='Admin'">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                    <button type="button" class="btn btn-danger" @click="eliminarArticulo(detalle_pedido.pedido_id)">Eliminar Articulo</button>
                                    <button type="button" class="btn btn-theme" @click="editPedido()">Modificar Pedido</button>
                                </div>
                            </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!--Nuevo Pedido Producto-->
            <div class="modal fade" id="myModalShowNuevoArticulo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel"> <i class="fa fa-stack-overflow"></i>&nbsp Nuevo Articulo</h4>
                        </div>
                        <div class="modal-body">

                          <div class="form-group" >
                              <label>Seleccione Tipo de Producto:</label>
                              <select name="categoria" class="form-control" v-model="nuevoPedido.tipo">
                                  <option value="" selected>Seleccione un Tipo de Producto...</option>
                                  <option :value="1" >Productos Sin Oferta</option>
                                  <option :value="2" >Productos Con Oferta</option>
                              </select>
                          </div>

                          <div class="form-group" v-show="nuevoPedido.tipo==1">
                              <label>Seleccione La Categoria :</label>
                              <select name="categoria" class="form-control" v-model="categoria.categoria_id">
                                  <option value="" selected>Seleccione una de las Categorias...</option>
                                  <option v-for="cat in categorias"
                                  :value="cat.id" >{{cat.nombre}}</option>
                              </select>
                          </div>

                          <div class="form-group" v-show="nuevoPedido.tipo==2">
                              <label>Seleccione La Categoria :</label>
                              <select name="categoria" class="form-control" v-model="categoria.categoria_id">
                                  <option value="" selected>Seleccione una de las Categorias...</option>
                                  <option v-for="cat in categoriaOfertas"
                                  :value="cat.id" >{{cat.nombre}}</option>
                              </select>
                          </div>

                          <div class="form-group" v-if="categoria.categoria_id!=''" >
                              <label>Selecione el Producto :</label>
                              <select name="producto" class="form-control" v-model="nuevoPedido.producto_id">
                                  <option value="" selected>Seleccione uno de los Productos...</option>
                                  <option v-for="pro in articulos" v-if="pro.categoria_id==categoria.categoria_id  && nuevoPedido.tipo==1"
                                  :value="pro.id" >{{pro.nombre}}
                                  </option>

                                  <option v-for="pro in productoOfertas" v-if="pro.categoria_id==categoria.categoria_id  && nuevoPedido.tipo==2"
                                  :value="pro.id" >{{pro.nombre}}
                                  </option>

                              </select>
                          </div>

                          <div class="form-group" v-if="nuevoPedido.producto_id!='' && nuevoPedido.tipo==1" >
                            <div v-for="pro in articulos" v-if="pro.id==nuevoPedido.producto_id">
                              <label class="label label-success" >{{pro.marca}}</label>
                              <label class="label label-primary" >{{pro.modelo}}</label>
                              <label class="label label-theme" >{{pro.medida}}</label>
                              <label  v-for="inv in inventarios" v-if="pro.id==inv.producto_id && nuevoPedido.tipo==1">
                                    <input type="hidden" v-model="nuevoPedido.inventario_id=inv.id">
                              </label>

                            </div>
                          </div>

                          <div class="form-group" v-if="nuevoPedido.producto_id!='' && nuevoPedido.tipo==2" >
                            <div v-for="pro in productoOfertas" v-if="pro.id==nuevoPedido.producto_id">
                              <label class="label label-success" >{{pro.marca}}</label>
                              <label class="label label-primary" >{{pro.modelo}}</label>
                              <label class="label label-theme" >{{pro.medida}}</label>
                              <label  v-for="inv in inventarios" v-if="pro.id==inv.producto_id && nuevoPedido.tipo==2">
                                <label class="label label-danger"  v-for="o in ofertas" v-if="o.inventario_id==inv.id">Producto en Oferta
                                      <input type="hidden" v-model="nuevoPedido.oferta_id=o.id"/>
                                      <input type="hidden" v-model="nuevoPedido.inventario_id=o.inventario_id">
                                </label>
                              </label>

                            </div>
                          </div>

                          <div class="group-rom" v-show="nuevoPedido.producto_id!=''">
                              <div class="first-part odd">Producto</div>
                              <div class="second-part" >
                                  <p v-for="pro in productos" v-if="nuevoPedido.producto_id==pro.id"><img class="img-responsive" :src="`/images/product/${pro.avatar}`" alt=""></p>
                              </div>
                          </div>

                          <div class="group-rom" v-show="nuevoPedido.producto_id!=''">
                              <div class="first-part odd">Cantidad Unidad por Caja</div>
                              <div class="second-part" v-for="inv in inventarios" v-if="inv.producto_id==nuevoPedido.producto_id">{{nuevoPedido.cajasunidad=inv.cantidad_unidad_caja}}</div>
                              <div class="third-part lec red1"  v-for="pro in productos" v-if="nuevoPedido.producto_id==pro.id">
                                 <label style="color:red;">{{pro.nota}}</label>
                              </div>
                          </div>

                          <div  v-for="pro in productos" v-if="nuevoPedido.producto_id==pro.id">
                                  <div class="group-rom" v-show="(nuevoPedido.producto_id!='' && pro.nota=='Venta unicamente por Unidad') || (nuevoPedido.producto_id!='' && pro.nota=='Venta por Caja o Unidad')">
                                      <div class="first-part odd">Unidades Por Pedir</div>
                                      <div class="second-part">
                                          <input type="text" v-model="nuevoPedido.cantidad_unidad" required v-on:keyup="actualizarLista">
                                      </div>
                                      <div class="third-part lec" v-for="inv in inventarios" v-if="(inv.producto_id==nuevoPedido.producto_id) ">
                                          Unidades Disponible: {{disproduct.dis_unidad=inv.cantidad_unidad_almacen_dis}}
                                      </div>

                                  </div>

                                  <div class="group-rom" v-show="(nuevoPedido.producto_id!='' && pro.nota=='Venta unicamente por Caja') || (nuevoPedido.producto_id!='' && pro.nota=='Venta por Caja o Unidad')">
                                      <div class="first-part odd">Cajas Por Pedir</div>
                                      <div class="second-part">
                                          <input type="text" v-model="nuevoPedido.cantidad_caja" required  v-on:keyup="actualizarLista1">
                                      </div>
                                      <div class="third-part lec" v-for="inv in inventarios" v-if=" (inv.producto_id==nuevoPedido.producto_id) ">
                                          Cajas Disponible: {{disproduct.dis_caja=inv.cantidad_caja_almacen_dis}}
                                      </div>
                                     
                                  </div>
                          </div>

                        <div class="group-rom" v-show="nuevoPedido.producto_id!=''">
                              <div class="first-part odd">Precio por Unidad</div>
                              <div class="second-part" v-for="inv in inventarios" v-if="(nuevoPedido.tipo==1) && (inv.producto_id==nuevoPedido.producto_id)">
                                  <input type="text" v-model="nuevoPedido.precio_unidad=inv.precio_venta_unidad" v-on:keyup="precioArticulo"> bs.
                              </div>
                              <div v-for="inv in inventarios" v-if="(nuevoPedido.tipo==2) && (inv.producto_id==nuevoPedido.producto_id)">
                                <div class="second-part" v-for="o in ofertas" v-if="o.inventario_id== inv.id">
                                    <input type="number" v-model="nuevoPedido.precio_unidad=o.precio_venta_nuevo" v-on:keyup="precioArticulo"> bs.
                                </div>
                              </div>
                          </div>


                          <div class="group-rom last-group" v-show="nuevoPedido.producto_id!=''">
                              <div class="first-part odd">Precio Total</div>
                              <div class="second-part odd" style="color:#000;">
                                  <h3> {{(nuevoPedido.precio_total)}} bs.</h3>
                              </div>
                          </div>

                            <div class="modal-footer">
                                <br> <br> <br>
                                <div class="btn-group hidden-sm hidden-xs">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                    <button type="button" class="btn btn-theme" @click="agregarArticulo()">Agregar Articulo</button>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>



            <!-- Nuevo Pedido ---------------------------->
            <div class="modal fade" id="myModalNuevoPedido" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel"> <i class="fa fa-stack-overflow"></i>&nbsp Nuevo Articulo</h4>
                        </div>
                        <div class="modal-body">

                          <div class="form-group" >
                              <label>Seleccione Un Cliente</label>
                              <select name="categoria" class="form-control" v-model="nuevoPedido.cliente_id">
                                  <option value="" selected>Seleccione un Cliente...</option>
                                  <option v-for="cli in clientes" :value="cli.id" >{{cli.cli_nombres}} {{cli.cli_apellidos}}</option>

                              </select>
                          </div>

                          <div class="form-group" v-show="nuevoPedido.cliente_id!=''">
                              <label>Seleccione Tipo de Producto:</label>
                              <select name="categoria" class="form-control" v-model="nuevoPedido.tipo">
                                  <option value="" selected>Seleccione un Tipo de Producto...</option>
                                  <option :value="1" >Productos Sin Oferta</option>
                                  <option :value="2" >Productos Con Oferta</option>
                              </select>
                          </div>

                          <div class="form-group" v-show="nuevoPedido.tipo==1">
                              <label>Seleccione La Categoria :</label>
                              <select name="categoria" class="form-control" v-model="categoria.categoria_id">
                                  <option value="" selected>Seleccione una de las Categorias...</option>
                                  <option v-for="cat in categorias"
                                  :value="cat.id" >{{cat.nombre}}</option>
                              </select>
                          </div>

                          <div class="form-group" v-show="nuevoPedido.tipo==2">
                              <label>Seleccione La Categoria :</label>
                              <select name="categoria" class="form-control" v-model="categoria.categoria_id">
                                  <option value="" selected>Seleccione una de las Categorias...</option>
                                  <option v-for="cat in categoriaOfertas"
                                  :value="cat.id" >{{cat.nombre}}</option>
                              </select>
                          </div>

                          <div class="form-group" v-if="categoria.categoria_id!=''" >
                              <label>Selecione el Producto :</label>
                              <select name="producto" class="form-control" v-model="nuevoPedido.producto_id">
                                  <option value="" selected>Seleccione uno de los Productos...</option>
                                  <option v-for="pro in articulos" v-if="pro.categoria_id==categoria.categoria_id  && nuevoPedido.tipo==1"
                                  :value="pro.id" >{{pro.nombre}}
                                  </option>

                                  <option v-for="pro in productoOfertas" v-if="pro.categoria_id==categoria.categoria_id  && nuevoPedido.tipo==2"
                                  :value="pro.id" >{{pro.nombre}}
                                  </option>

                              </select>
                          </div>

                          <div class="form-group" v-if="nuevoPedido.producto_id!='' && nuevoPedido.tipo==1" >
                            <div v-for="pro in articulos" v-if="pro.id==nuevoPedido.producto_id">
                              <label class="label label-success" >{{pro.marca}}</label>
                              <label class="label label-primary" >{{pro.modelo}}</label>
                              <label class="label label-theme" >{{pro.medida}}</label>
                              <label  v-for="inv in inventarios" v-if="pro.id==inv.producto_id && nuevoPedido.tipo==1">
                                    <input type="hidden" v-model="nuevoPedido.inventario_id=inv.id">
                              </label>

                            </div>
                          </div>

                          <div class="form-group" v-if="nuevoPedido.producto_id!='' && nuevoPedido.tipo==2" >
                            <div v-for="pro in productoOfertas" v-if="pro.id==nuevoPedido.producto_id">
                              <label class="label label-success" >{{pro.marca}}</label>
                              <label class="label label-primary" >{{pro.modelo}}</label>
                              <label class="label label-theme" >{{pro.medida}}</label>
                              <label  v-for="inv in inventarios" v-if="pro.id==inv.producto_id && nuevoPedido.tipo==2">
                                <label class="label label-danger"  v-for="o in ofertas" v-if="o.inventario_id==inv.id">Producto en Oferta
                                      <input type="hidden" v-model="nuevoPedido.oferta_id=o.id"/>
                                      <input type="hidden" v-model="nuevoPedido.inventario_id=o.inventario_id">
                                </label>
                              </label>

                            </div>
                          </div>

                          <div class="group-rom" v-show="nuevoPedido.producto_id!=''">
                              <div class="first-part odd">Producto</div>
                              <div class="second-part" >
                                  <p v-for="pro in productos" v-if="nuevoPedido.producto_id==pro.id"><img class="img-responsive" :src="`/images/product/${pro.avatar}`" alt=""></p>
                              </div>
                          </div>

                          <div class="group-rom" v-show="nuevoPedido.producto_id!=''">
                              <div class="first-part odd">Cantidad Unidad por Caja</div>
                              <div class="second-part" v-for="inv in inventarios" v-if="inv.producto_id==nuevoPedido.producto_id">{{nuevoPedido.cajasunidad=inv.cantidad_unidad_caja}}</div>
                              <div class="third-part lec red1"  v-for="pro in productos" v-if="nuevoPedido.producto_id==pro.id">
                                 <label style="color:red;">{{pro.nota}}</label>
                              </div>
                          </div>

                          <div  v-for="pro in productos" v-if="nuevoPedido.producto_id==pro.id">
                                  <div class="group-rom" v-show="(nuevoPedido.producto_id!='' && pro.nota=='Venta unicamente por Unidad') || (nuevoPedido.producto_id!='' && pro.nota=='Venta por Caja o Unidad')">
                                      <div class="first-part odd">Unidades Por Pedir</div>
                                      <div class="second-part">
                                          <input type="number" v-model="nuevoPedido.cantidad_unidad" required v-on:keyup="actualizarLista">
                                      </div>
                                      <div class="third-part lec" v-for="inv in inventarios" v-if="(inv.producto_id==nuevoPedido.producto_id) ">
                                          Unidades Disponible: {{inv.cantidad_unidad_almacen_dis}}
                                      </div>

                                  </div>

                                  <div class="group-rom" v-show="(nuevoPedido.producto_id!='' && pro.nota=='Venta unicamente por Caja') || (nuevoPedido.producto_id!='' && pro.nota=='Venta por Caja o Unidad')">
                                      <div class="first-part odd">Cajas Por Pedir</div>
                                      <div class="second-part">
                                          <input type="number" v-model="nuevoPedido.cantidad_caja" required required v-on:keyup="actualizarLista1">
                                      </div>
                                      <div class="third-part lec" v-for="inv in inventarios" v-if="(inv.producto_id==nuevoPedido.producto_id) ">
                                          Cajas Disponible: {{inv.cantidad_caja_almacen_dis}}
                                      </div>

                                  </div>
                          </div>

                        <div class="group-rom" v-show="nuevoPedido.producto_id!=''">
                              <div class="first-part odd">Precio por Unidad</div>
                              <div class="second-part" v-for="inv in inventarios" v-if="(nuevoPedido.tipo==1) && (inv.producto_id==nuevoPedido.producto_id)">
                                  <input type="number" v-model="nuevoPedido.precio_unidad=inv.precio_venta_unidad"> bs.
                              </div>
                              <div v-for="inv in inventarios" v-if="(nuevoPedido.tipo==2) && (inv.producto_id==nuevoPedido.producto_id)">
                                <div class="second-part" v-for="o in ofertas" v-if="o.inventario_id== inv.id">
                                    <input type="number" v-model="nuevoPedido.precio_unidad=o.precio_venta_nuevo"> bs.
                                </div>
                              </div>
                          </div>


                          <div class="group-rom last-group" v-show="nuevoPedido.producto_id!=''">
                              <div class="first-part odd">Precio Total</div>
                              <div class="second-part odd" style="color:#000;">
                                  <h3> {{(nuevoPedido.precio_total)}} bs.</h3>
                              </div>
                          </div>


                            <div class="modal-footer">

                                <div class="btn-group hidden-sm hidden-xs">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                    <button type="button" class="btn btn-theme" @click="agregarPedido()">Nuevo Pedido</button>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- **********************************************************************************************************************************************************
                MAIN MENU
                *********************************************************************************************************************************************************** -->
            <!--sidebar start-->

        </aside>
        <aside class="right-side">
            <div class="user-head centered">
              <h4 class="pull-left ">Clientes</h4>
                <div v-for="a in asignar" v-if="a.user_id==iduser">
                    <div v-if="a.rol_asignacion=='SuperAdmin' || a.rol_asignacion=='Admin'">
                        <a href="#" class="btn btn-theme04 pull-right" data-toggle="modal" data-target="#myModalNuevoPedido" >+ Pedido</a>
                    </div>
                </div>
            </div>
            <div class="invite-row">

            </div>
            <ul class="chat-available-user" v-if="rol=='SuperAdmin' || rol=='Admin'">

                <li v-for="p in pedidoHecho" v-if="p.estatus=='PedidoHecho'">
                    <a href="#" @click="InfoPedido(p.cliente_id, p.fecha_compra)">
                        <img class="img-circle" src="img/icons8-usuario-importante-64.png" width="32">
                        <div v-for="cli in clientes" v-if="cli.id == p.cliente_id">
                            {{cli.cli_nombres}}

                            <span class="text-muted">&nbsp&nbsp{{p.fecha_compra | myDate1}}</span>
                        </div>
                        <span v-for="cli in clientes" v-if="cli.id == p.cliente_id" class="text-muted">{{cli.cli_usuario}}</span>
                    </a>
                </li>

            </ul>
            <ul class="chat-available-user" v-if="rol=='Dist'">
                <div>
                <li v-for="p in pedidoHecho" v-if="p.estatus=='PedidoHecho' && p.user_id==iduser">
                    <a href="#" @click="InfoPedido(p.cliente_id, p.fecha_compra)">
                        <img class="img-circle" src="img/icons8-usuario-importante-64.png" width="32">
                        <div v-for="cli in clientes" v-if="cli.id == p.cliente_id">
                            {{cli.cli_nombres}}

                            <span class="text-muted">&nbsp&nbsp{{p.fecha_compra | myDate1}}</span>
                        </div>
                        <span v-for="cli in clientes" v-if="cli.id == p.cliente_id" class="text-muted">{{cli.cli_usuario}}</span>
                    </a>
                </li>
                </div>
            </ul>
        </aside>
    </div>
</div>

</template>

<script>

export default {
    data() {
            return {
                pedidoHecho: {},
                Infopedido: {
                    cli_id: '',
                    fe_compra: ''
                },

                nuevoPedido:{
                  tipo:'',
                  producto_id:'',
                  inventario_id:'',
                  oferta_id:'',
                  cantidad_unidad:'',
                  cantidad_caja:'',
                  precio_unidad:'',
                  precio_total:'',
                  cajasunidad:'',

                  cliente_id:'',
                },

                categorias: {},
                categoriaOfertas:{},
                productoOfertas:{},
                articulos:{},
                categoria: {
                    categoria_id: ''
                },
                pedidos: {},
                detalle: {},

                detalle_pedido: {
                    pedido_id: '',

                    cantidad_unidad:'',
                    cantidad_caja:'',
                    precio_unidad:'',
                    precio_total:'',
                    cantidad:'',
                },

                disproduct:{
                    dis_caja:'',
                    dis_unidad:'',
                },


                precantida: {},

                clientes: {},
                inventarios: {},
                productos: {},
                ofertas:{},

                errors: {},

                search: '',
                loading: true,
                visualizar: true,
                ocultar: false,
                errors:{},
                semanas:'0',

                asignar:{},
                iduser:'',
                usuarios:{},
                rol:'',
            }
        },

        created() {
            /*  Fire.$on('searching',() => {
                          let query = this.search;
                          axios.get('findUser?q='+query)
                          .then((data) => {
                              this.ofertas = data.data;
                          })
                          .catch(() => {

                          })
                      })*/
            this.LoadUser()
            Fire.$on('AfterCreate', () => {
                this.LoadUser()
            })
        },

        methods: {
            LoadUser() {
                    axios.get('pedidos').then(res => {
                        this.pedidos = res.data.pedidos;
                        this.pedidoHecho = res.data.pedidoHecho.data;
                        this.clientes = res.data.clientes;
                        this.inventarios = res.data.inventarios;
                        this.productos = res.data.productos;
                        this.detalle = res.data.detallepedido;
                        this.categorias = res.data.categorias;
                        this.articulos = res.data.articulos;
                        this.ofertas =  res .data.ofertas;
                        this.categoriaOfertas = res.data.categoriaOfertas;
                        this.productoOfertas =  res.data.productoOfertas;

                        this.precantida = res.data.preuni;
                        if(res.data.idpedido.length!=0){
                            this.InfoPedido(res.data.idpedido[0].cliente_id, res.data.idpedido[0].fecha_compra);
                        }else{
                            this.ocultar = false;
                        }
                        
                        this.asignar=res.data.asignar;
                        this.iduser=res.data.iduser;
                        this.usuarios=res.data.usuarios;
                        this.rol=res.data.rol;
                        this.loading = false;
                    })
                },

                InfoPedido(id, fecha) {
                    this.Infopedido.cli_id = id;
                    this.Infopedido.fe_compra = fecha;
                    this.ocultar = true;
                },

                updateShow(item, cantidad) {
                    this.detalle_pedido.pedido_id = item.id;
                    this.detalle_pedido.cantidad_unidad = item.cantidad_unidad;
                    this.detalle_pedido.cantidad_caja = item.cantidad_caja;
                    this.detalle_pedido.precio_unidad = item.precio_unidad;
                    this.detalle_pedido.precio_total = item.precio_total;
                    this.detalle_pedido.cantidad = cantidad;

                },

                editPedido() {
                        const params = {
                            pedido_id : this.detalle_pedido.pedido_id,
                            cantidad_unidad: this.detalle_pedido.cantidad_unidad,
                            cantidad_caja: this.detalle_pedido.cantidad_caja,
                            precio_unidad: this.detalle_pedido.precio_unidad,
                            precio_total: this.detalle_pedido.precio_total,
                      };
                      axios.post('/updateArticulo/', params)
                      .then((res) => {
                          
                           swal.fire(
                              'Actualizado!',
                              'La información ha sido actualizada.',
                              'success'
                              )

                               Fire.$emit('AfterCreate');


                      }).catch(()=> {
                                                swal("¡Ha fallado!", "Había algo malo.", "warning");
                                            });

                },


                entregarPedido() {
                    let formData = new FormData()
                    formData.append('cliente', this.Infopedido.cli_id);
                    formData.append('fecha', this.Infopedido.fe_compra);


                    axios
                        .post('/update/', formData, {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        })
                        .then((res) => {
                            
                            swal.fire(
                              'Actualizado!',
                              'Los Productos Fueron Entregados Correctamente',
                              'success'
                              )
                            Fire.$emit('AfterCreate')

                        })
                        .catch(()=> {
                                                swal("¡Ha fallado!", "Había algo malo.", "warning");
                                            });
                },



                agregarArticulo(){
                  let formData = new FormData();
                  formData.append('tipo', this.nuevoPedido.tipo);
                  formData.append('inventario_id', this.nuevoPedido.inventario_id);
                  formData.append('oferta_id', this.nuevoPedido.oferta_id);
                  formData.append('cantidad_unidad', this.nuevoPedido.cantidad_unidad);
                  formData.append('cantidad_caja', this.nuevoPedido.cantidad_caja);
                  formData.append('precio_unidad', this.nuevoPedido.precio_unidad);
                  formData.append('precio_total', this.nuevoPedido.precio_total);
                  formData.append('cliente_id', this.Infopedido.cli_id);
                  formData.append('fecha_compra', this.Infopedido.fe_compra);


                  axios
                      .post('/createArticulo/', formData, {
                          headers: {
                              'Content-Type': 'multipart/form-data'
                          }
                      })
                      .then(res => {
                          Fire.$emit('AfterCreate')

                          toast.fire({
                              type: 'success',
                              title: 'El Articulo Se Agregado Correctamente..!!!'
                          })

                          this.nuevoPedido.tipo='';
                          this.categoria.categoria_id='';
                          this.nuevoPedido.producto_id='';

                      })
                      .catch(()=> {
                                                swal("¡Ha fallado!", "Había algo malo.", "warning");
                                            });

                },


                actualizarLista: function() {
                  if(this.nuevoPedido.cantidad_unidad!=''){
                        if(this.nuevoPedido.cantidad_unidad<=this.disproduct.dis_unidad) {
                                this.nuevoPedido.cantidad_caja='';
                                this.nuevoPedido.precio_total = (this.nuevoPedido.cantidad_unidad*this.nuevoPedido.precio_unidad).toFixed(2);
                                this.nuevoPedido.cantidad_caja='';
                            }else{
                                this.nuevoPedido.cantidad_unidad=0;
                        }   
                  }
                },

                actualizarLista1: function() {
                  if(this.nuevoPedido.cantidad_caja!='' ){
                      if(this.nuevoPedido.cantidad_caja<=this.disproduct.dis_caja) {
                            this.nuevoPedido.cantidad_unidad='';
                            this.nuevoPedido.precio_total = (this.nuevoPedido.cantidad_caja * this.nuevoPedido.cajasunidad * this.nuevoPedido.precio_unidad).toFixed(2);
                            this.nuevoPedido.cantidad_unidad='';
                         }else{
                                this.nuevoPedido.cantidad_caja=0;
                        }   
                  }
                },

                precioArticulo: function() {
                    
                      if(this.nuevoPedido.precio_unidad!=''){
                        if(this.nuevoPedido.precio_unidad>=0) {
                            if(this.nuevoPedido.cantidad_caja>0){
                            this.nuevoPedido.precio_total = (this.nuevoPedido.cantidad_caja * this.nuevoPedido.cajasunidad * this.nuevoPedido.precio_unidad).toFixed(2);           
                            }else{
                            this.nuevoPedido.precio_total = (this.nuevoPedido.cantidad_unidad * this.nuevoPedido.cajasunidad * this.nuevoPedido.precio_unidad).toFixed(2);
                            }
                        }else{
                            this.nuevoPedido.precio_unidad=0;
                        }
                      }

                },

                validarSemana: function(){
                    if(this.semanas<0){
                           this.semanas=0; 
                    }
                },

                eliminarArticulo(id){
                            swal.fire({
                                title: '¿Estás seguro?',
                                text: "¡No podrás revertir esto!",
                                type: 'advertencia',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Sí, Eliminar!'
                                }).then((result) => {

                                    // Send request to the server
                                     if (result.value) {
                                            axios.get('/pedidos/eliminarArticulo/'+id).then(()=>{
                                                    swal.fire(
                                                    'Eliminado!',
                                                    'Su archivo ha sido eliminado.',
                                                    'success'
                                                    )



                                               Fire.$emit('AfterCreate');


                                               $('.myModalShow').modal().hide();


                                            }).catch(()=> {
                                                swal("¡Ha fallado!", "Había algo malo.", "warning");
                                            });
                                     }
                                });


                },

                validarUnidad : function() {
                    if(this.detalle_pedido.cantidad_unidad!=''){
                        if(this.detalle_pedido.cantidad_unidad<=this.disproduct.dis_unidad) {
                             this.detalle_pedido.precio_total= ( this.detalle_pedido.cantidad_unidad * this.detalle_pedido.precio_unidad).toFixed(2);
                        }else{
                            this.detalle_pedido.cantidad_unidad=0;
                        }
                       
                      }

                },

                validarCaja: function() {
                      if(this.detalle_pedido.cantidad_caja!=''){
                        if(this.detalle_pedido.cantidad_caja<=this.disproduct.dis_caja) {
                            this.detalle_pedido.precio_total= (this.detalle_pedido.cantidad * this.detalle_pedido.cantidad_caja * this.detalle_pedido.precio_unidad).toFixed(2);
                        }else{
                            this.detalle_pedido.cantidad_caja=0;
                        }
                      }
                },

                validarPrecio: function() {
                      if(this.detalle_pedido.precio_unidad!=''){
                        if(this.detalle_pedido.precio_unidad>=0) {
                            if(this.detalle_pedido.cantidad_caja>0){
                                 this.detalle_pedido.precio_total= (this.detalle_pedido.cantidad * this.detalle_pedido.cantidad_caja * this.detalle_pedido.precio_unidad).toFixed(2);
                            }else{
                                this.detalle_pedido.precio_total= (this.detalle_pedido.cantidad * this.detalle_pedido.cantidad_unidad * this.detalle_pedido.precio_unidad).toFixed(2);
                            }
                           
                        }else{
                            this.detalle_pedido.cantidad_caja=0;
                        }
                      }
                },


                eliminarPedido(){
                        const params = {
                            cliente_id : this.Infopedido.cli_id,
                            fecha_compra: this.Infopedido.fe_compra,
                      };

                      swal.fire({
                          title: '¿Estás seguro?',
                          text: "¡No podrás revertir esto!",
                          type: 'advertencia',
                          showCancelButton: true,
                          confirmButtonColor: '#3085d6',
                          cancelButtonColor: '#d33',
                          confirmButtonText: 'Sí, Eliminar!'
                          }).then((result) => {

                              // Send request to the server
                               if (result.value) {
                                      axios.post('/eliminarPedido/', params).then(()=>{
                                              swal.fire(
                                              'Eliminado!',
                                              'Su archivo ha sido eliminado.',
                                              'success'
                                              )


                                         Fire.$emit('AfterCreate');

                                      }).catch(()=> {
                                          swal("¡Ha fallado!", "Había algo malo.", "warning");
                                      });
                               }
                          });

                },

                agregarPedido(){

                  let formData = new FormData();

                  formData.append('tipo', this.nuevoPedido.tipo);
                  formData.append('inventario_id', this.nuevoPedido.inventario_id);
                  formData.append('oferta_id', this.nuevoPedido.oferta_id);
                  formData.append('cantidad_unidad', this.nuevoPedido.cantidad_unidad);
                  formData.append('cantidad_caja', this.nuevoPedido.cantidad_caja);
                  formData.append('precio_unidad', this.nuevoPedido.precio_unidad);
                  formData.append('precio_total', this.nuevoPedido.precio_total);
                  formData.append('cliente_id', this.nuevoPedido.cliente_id);
                

                  axios
                      .post('/pedidos/', formData, {
                          headers: {
                              'Content-Type': 'multipart/form-data'
                          }
                      })
                      .then(res => {
                          

                          toast.fire({
                              type: 'success',
                              title: 'El Articulo Se Agregado Correctamente..!!!'
                          })

                          Fire.$emit('AfterCreate')
                          this.nuevoPedido.cliente_id='';
                          this.nuevoPedido.tipo='';
                          this.categoria.categoria_id='';
                          this.nuevoPedido.producto_id='';

                      })
                      .catch(error => (this.errors = error.response.data.errors))


                },
        }
}

</script>
