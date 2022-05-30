<template>

  <div style="margin-top: 50px;">
    <h3><i class="fa fa-angle-right"></i>
      Inventario
      <div v-for="a in asignar" v-if="a.user_id==iduser"><div v-if="a.rol_asignacion=='SuperAdmin' || a.rol_asignacion=='Admin'">
      <button class="btn btn-success btn"  data-toggle="modal" data-target="#myModal" @click="limpiar()">
        <i class="fa fa-plus"></i> Nuevo
      </button>
       <button class="btn btn-theme btn pull-right position" @click="pdfReporte()" ><i class="fa fa-file-text-o"></i> PDF Kardex Resumido</button>
      </div>
      </div>
    </h3>
    <div class="row mb">


      <div class="chat-room-head col-md-12">

        <div class="pull-right position">
          <input type="search" placeholder="Buscar" @keyup="searchit" v-model="search" class="form-control search-btn "/>
        </div>
      </div>

        <div class="col-md-12" style="margin-top: 10px;">

            <div class="form-group col-md-2" >
                        <label>Productos :</label>
                        <select name="productos" class="form-control" v-model="filtros.mas" >
                          <option value="" selected>Seleccione</option>
                          <option value="mas" >Mas Vendidos</option>
                          <option value="menos">Menos Vendidos</option>

                        </select>
            </div>
            <div class="form-group col-md-2" v-if="filtros.mas=='mas'" >
                        <label>Productos :</label>
                        <select name="productos" class="form-control" v-model="filtros.val" >
                          <option value="" selected>Seleccione</option>
                          <option value="cantidad" @click="validar(filtros.val)">Cantidad</option>
                          <option value="precio" @click="validar(filtros.val)">Precio</option>

                        </select>
            </div>
            <div class="form-group col-md-2" v-if="filtros.mas=='menos'" >
                        <label>Productos :</label>
                        <select name="productos" class="form-control" v-model="filtros.val" >
                          <option value="" selected>Seleccione</option>
                          <option value="salida" @click="validar(filtros.val)">Con Salida</option>
                          <option value="sinsalida" @click="validar(filtros.val)">Sin Salida</option>

                        </select>
            </div>

            <div class="form-group col-md-2" >
                      <label>Por Costos </label>
            <input type="text"
                           name="minimo"
                           placeholder="Minimo"
                           class="form-control"
                           v-model="filtros.min"  @click="validar(filtros.min)"
                           v-on:keyup="minimo">       
            </div>
            <div class="form-group col-md-2" >
                      <label>A </label>
            <input type="text"
                           name="maximo"
                           placeholder="Maximo"
                           class="form-control"
                           v-model="filtros.max"  @click="validar(filtros.max)"
                            v-on:keyup="maximo">       
            </div>

            <div class="form-group col-md-2" >
                        <label>Productos Publicados :</label>
                        <select name="productos" class="form-control" v-model="filtros.publicar" >
                          <option value="" selected>Seleccione</option>
                          <option value="No" @click="validarPublicar(filtros.publicar)">Sin Publicar</option>
                          <option value="Si" @click="validarPublicar(filtros.publicar)">Publicados</option>

                        </select>
            </div>
                    


               
        </div>

        <div class="row">
          <div class="col-lg-12">
            <spiner v-show="loading"></spiner>
            <div v-for="inv in inventarios.data">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
              <div class="custom-box">
                  <!-- <a href="#"  @click="deleteInventario(inv.id)" class="col-xs-offset-11 pull-right position" >  <i class='fa fa-close ' style="color:red;"></i></a>-->
    <div class="servicetitle" >
                  <button class="col-xs-offset-10 pull-right position btn btn-default btn-xs"  data-toggle="modal" data-target="#myModalNOtificacion" @click="limpiarNotificacion(inv.id)">
                    <i class="fa fa-bell" style="color:red;"> </i> 
                  </button>
                  <button class=" btn btn-theme btn-xs"   @click="cambiarEstado(inv.id)" >
                    <i class="glyphicon glyphicon-ok-circle" v-if="inv.publicado=='Si'"> Publicado</i> 
                    <i class="glyphicon glyphicon-remove-circle" v-if="inv.publicado=='No'"> Sin Publicar</i> 
                  </button>
    </div>
                <div class="servicetitle" >
                  <h4 v-for="pro in productos" v-if="pro.id==inv.producto_id">{{pro.nombre}}</h4>
                  <hr>
                </div>
                <div class="icn-main-container" v-for="pro in productos" v-if="pro.id==inv.producto_id">
                  <img :src="`images/product/${pro.avatar}`" alt="" style="max-width: 100px; max-height: 95px; line-height: 10px;" />
                </div>
                <div v-for="pro in productos" v-if="pro.id==inv.producto_id">
                  <p v-for="cat in categorias" v-if="cat.id==pro.categoria_id">{{cat.nombre}}</p>
                </div>
                <ul class="pricing">
                  <li  v-for="pro in productos" v-if="pro.id==inv.producto_id">{{pro.marca }} <label v-if="pro.modelo!=null">-- {{pro.modelo}}</label></li>
                  <li>Unidades por Caja: {{inv.cantidad_unidad_caja}}</li>
                  <li>Unidades Disponible: {{inv.cantidad_unidad_almacen_dis}}</li>
                  <li>Cajas Disponibles: {{inv.cantidad_caja_almacen_dis}}</li>
                  <!--<li>Precio Compra x Unidad: {{inv.precio_compra_unidad}}</li>-->
                  <li>Precio Venta x Unidad: {{inv.precio_venta_unidad}}</li>
                  <!--<li>Vencimiento: {{inv.fecha_vencimiento | myDate}}</li>-->
                  <li>{{inv.status}}</li>
                </ul>
                <div v-for="a in asignar" v-if="a.user_id==iduser">
                  <div v-if="a.rol_asignacion=='SuperAdmin' || a.rol_asignacion=='Admin'">
                    <button class="btn btn-theme" data-toggle="modal" data-target="#myModalEditar" @click="updateShow(inv)">Entradas </button>
                    <button class="btn btn-info" data-toggle="modal" data-target="#myModalSalida" @click="salidaShow(inv)">Salidas</button>
                    <button class="btn btn-success" data-toggle="modal" data-target="#myModalOferta" @click="ofertaShow(inv)">Oferta</button>
                  </div>
                </div>
              </div>
              <!-- end custombox -->
            </div>
            <!-- end col-4 -->
            </div>

            <div class="card-footer"  >
              <pagination :data="inventarios" @pagination-change-page="getResults" class="dataTables_paginate paging_bootstrap pagination" ></pagination>
          </div>
          </div>
          <!--  /col-lg-12 -->
        </div>
        <!--  /row -->


      <!-- page end-->
    </div>
    <!-- /row -->
    <!-- Nuevo Inventario Modal -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel">   <i class="fa fa-stack-overflow"></i>&nbsp Agregar Nuevo Producto a Inventario</h4>
        </div>
        <div class="modal-body">

          <div class="form-group" >
              <label>Seleccione La Categoria :</label>
              <select name="categoria" class="form-control" v-model="cat.categoria">
                  <option value="" selected>Seleccione una de las Categorias...</option>
                  <option v-for="cat in categorias"
                  :value="cat.id" >{{cat.nombre}}</option>
              </select>
          </div>

          <div class="form-group" v-if="cat.categoria!=''" >
              <label>Selecione el Producto :</label>
              <select name="producto" class="form-control" v-model="inventario.producto_id">
                  <option value="" selected>Seleccione uno de los Productos...</option>
                  <option v-for="pro in productos" v-if="pro.categoria_id==cat.categoria"
                  :value="pro.id" >{{pro.nombre}}</option>
              </select>
          </div>

          <div class="form-group" v-if="inventario.producto_id!=''" >
            <label class="label label-success" v-for="pro in productos" v-if="pro.id==inventario.producto_id">{{pro.marca}}</label>
            <label class="label label-primary" v-for="pro in productos" v-if="pro.id==inventario.producto_id">{{pro.modelo}}</label>
            <label class="label label-theme" v-for="pro in productos" v-if="pro.id==inventario.producto_id">{{pro.medida}}</label>

          </div>

          <div class="form-group" v-if="inventario.producto_id!=''">
                    <input type="number"
                           name="cantidad_unidad_caja"
                           v-model="inventario.cantidad_unidad_caja"
                           id="valor1"
                           placeholder="Cantidad de Unidades x Caja"
                           class="form-control"
                           :class="{'is-danger':errors.cantidad_unidad_caja}">
                    <small v-if="errors.cantidad_unidad_caja" class="has-text-danger red1">{{errors.cantidad_unidad_caja[0]}}</small>
          </div>

          <div class="form-group">
            <label class="label label-warning" v-for="pro in productos" v-if="pro.id==inventario.producto_id">{{pro.nota}}</label>
          </div>

          <div class="form-group" v-if="inventario.cantidad_unidad_caja!=''" v-show="visible2"  >
                    <input type="text"
                           name="cantidad_unidad_almacen"
                           v-model="inventario.cantidad_unidad_almacen"
                           id="valor2"
                           v-on:keyup="actualizarLista"
                           placeholder="Cantidad de Unidades Adquiridas"
                           class="form-control"
                           :class="{'is-danger':errors.cantidad_unidad_almacen}">
                    <small v-if="errors.cantidad_unidad_almacen" class="has-text-danger red1">{{errors.cantidad_unidad_almacen[0]}}</small>
          </div>
          <div class="form-group" v-if="inventario.cantidad_unidad_caja!=''" v-show="oculto2">
                    <input type="text"
                           name="cantidad_unidad_almacen"
                           v-model="inventario.cantidad_unidad_almacen"
                           id="valor2"
                           v-on:keyup="actualizarLista"
                           disabled
                           placeholder="Cantidad de Unidades Adquiridas"
                           class="form-control"
                           :class="{'is-danger':errors.cantidad_unidad_almacen}">
                    <small v-if="errors.cantidad_unidad_almacen" class="has-text-danger red1">{{errors.cantidad_unidad_almacen[0]}}</small>
          </div>

          <div class="form-group" v-if="inventario.cantidad_unidad_caja!=''" v-show="visible">
                    <input type="text"
                           name="cantidad_caja_almacen"
                           v-model="inventario.cantidad_caja_almacen"
                           id="valor3"
                           v-on:keyup="actualizarLista1"
                           placeholder="Cantidad de Cajas Adquiridas"
                           class="form-control"
                           :class="{'is-danger':errors.cantidad_caja_almacen}">
                    <small v-if="errors.cantidad_caja_almacen" class="has-text-danger red1">{{errors.cantidad_caja_almacen[0]}}</small>
          </div>

          <div class="form-group" v-if="inventario.cantidad_unidad_caja!=''" v-show="oculto">
                    <input type="text"
                           name="cantidad_caja_almacen"
                           v-model="inventario.cantidad_caja_almacen"
                           id="valor3"
                           v-on:keyup="actualizarLista1"
                           disabled
                           placeholder="Cantidad de Cajas Adquiridas"
                           class="form-control"
                           :class="{'is-danger':errors.cantidad_caja_almacen}">

                    <small v-if="errors.cantidad_caja_almacen" class="has-text-danger red1">{{errors.cantidad_caja_almacen[0]}}</small>
          </div>

           <!--<div class="form-group" v-if="inventario.cantidad_caja_almacen!=''">
                    <input type="text"
                           name="precio_compra_unidad"
                           v-model="inventario.precio_compra_unidad"
                           placeholder="Ingresar Precio Compra Unidad"
                           class="form-control"
                           :class="{'is-danger':errors.precio_compra_unidad}">
                    <small v-if="errors.precio_compra_unidad" class="has-text-danger red1">{{errors.precio_compra_unidad[0]}}</small>
          </div>-->

          <div class="form-group" v-if="inventario.cantidad_caja_almacen!=''">
                    <input type="text"
                           name="precio_venta_unidad"
                           v-model="inventario.precio_venta_unidad"
                           placeholder="Ingresar Precio de Venta Unidad"
                           class="form-control"
                           :class="{'is-danger':errors.precio_venta_unidad}">
                    <small v-if="errors.precio_venta_unidad" class="has-text-danger red1">{{errors.precio_venta_unidad[0]}}</small>
          </div>

          <!--<div class="form-group" v-if="inventario.precio_venta_unidad!=''">

                      <input type="date" v-model="inventario.fecha_vencimiento"   min="2018-01-01" max="2050-1-1"  :class="{'is-danger':errors.cantidad_unidad_caja}">
                      <small v-if="errors.fecha_vencimiento" class="has-text-danger red1">{{errors.fecha_vencimiento[0]}}</small>

          </div>-->


          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary" @click="agregar()">Agregar</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Entrada Inventario Modal -->
<div class="modal fade" id="myModalEditar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">   <i class="fa fa-stack-overflow"></i>&nbsp Nueva Entrada de Producto</h4>
      </div>
      <div class="modal-body">


        <div class="form-group" v-for="pro in productos" v-if="pro.id==inventario.producto_id">
          <label  style="color: #000;" class="label label-info">Nombre: {{pro.nombre}}</label>│
          <label  style="color: #000;" class="label label-default" v-for="cat in categorias" v-if="cat.id==pro.categoria_id" >Categoria: {{cat.nombre}}</label>│
          <label  style="color: #000;" class="label label-success" >Marca: {{pro.marca}}</label>│
          <label  style="color: #000;" class="label label-warning" v-show="pro.modelo!=null">Modelo: {{pro.modelo}}</label>
          <label  style="color: #000;" class="label label-warning" v-show="pro.modelo==null">Modelo: ...</label>
        </div>


        <div class="form-group" >
                  <label style="color: #000;">Unidades por Caja : </label>
                  <input type="text"
                         name="cantidad_unidad_caja"
                         v-model="inventario.cantidad_unidad_caja"
                         placeholder="Cantidad de Unidades x Caja"
                         class="form-control"
                         id="valor10"
                         :class="{'is-danger':errors.cantidad_unidad_caja}" disabled>
                  <small v-if="errors.cantidad_unidad_caja" class="has-text-danger red1">{{errors.cantidad_unidad_caja[0]}}</small>
        </div>


        <div class="form-group" >
                  <label style="color: #000;">Unidades Adquiridas: </label>
                  <input type="text"
                         name="cantidad_unidad_almacen"
                         v-model="inventario.cantidad_unidad_almacen"
                         placeholder="Cantidad de Unidades Adquiridas"
                         class="form-control"
                         id="valor20"
                         v-on:keyup="actualizarLista10"
                         :class="{'is-danger':errors.cantidad_unidad_almacen}">
                  <small v-if="errors.cantidad_unidad_almacen" class="has-text-danger red1">{{errors.cantidad_unidad_almacen[0]}}</small>
        </div>

        <div class="form-group" >
                  <label style="color: #000;">Cajas Adquiridas : </label>
                  <input type="text"
                         name="cantidad_caja_almacen"
                         v-model="inventario.cantidad_caja_almacen"
                         placeholder="Cantidad de Cajas Adquiridas"
                         class="form-control"
                         id="valor30"
                         v-on:keyup="actualizarLista20"
                         :class="{'is-danger':errors.cantidad_caja_almacen}">
                  <small v-if="errors.cantidad_caja_almacen" class="has-text-danger red1">{{errors.cantidad_caja_almacen[0]}}</small>
        </div>

         <!--<div class="form-group" >
              <label style="color: #000;">Precio de Compra por Unidad : </label>
                  <input type="text"
                         name="precio_compra_unidad"
                         v-model="inventario.precio_compra_unidad"
                         placeholder="Ingresar Precio Compra Unidad"
                         class="form-control"
                         :class="{'is-danger':errors.precio_compra_unidad}">
                  <small v-if="errors.precio_compra_unidad" class="has-text-danger red1">{{errors.precio_compra_unidad[0]}}</small>
        </div>-->

        <div class="form-group">
            <label style="color: #000;">Precio de Venta por Unidad : </label>
                  <input type="text"
                         name="precio_venta_unidad"
                         v-model="inventario.precio_venta_unidad"
                         placeholder="Ingresar Precio de Venta Unidad"
                         class="form-control"
                         :class="{'is-danger':errors.precio_venta_unidad}">
                  <small v-if="errors.precio_venta_unidad" class="has-text-danger red1">{{errors.precio_venta_unidad[0]}}</small>
        </div>

        <!--<div class="form-group" >
                    <label style="color: #000;">Fecha De Salida  : </label>
                    <input type="date" v-model="inventario.fecha_vencimiento"   min="2018-01-01" max="2050-1-1"  :class="{'is-danger':errors.cantidad_unidad_caja}">
                    <small v-if="errors.fecha_vencimiento" class="has-text-danger red1">{{errors.fecha_vencimiento[0]}}</small>

        </div>-->


        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary" @click="updateInventario(inventario)">Registrar Entrada</button>
        </div>
      </div>
    </div>
  </div>
</div>


  <!-- Salida Inventario Modal -->
<div class="modal fade" id="myModalSalida" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">   <i class="fa fa-stack-overflow"></i>&nbsp Salida de Productos</h4>
      </div>
      <div class="modal-body">


        <div class="form-group" v-for="pro in productos" v-if="pro.id==inventario.producto_id">
          <label  style="color: #000;" class="label label-info">Nombre: {{pro.nombre}}</label>│
          <label  style="color: #000;" class="label label-default" v-for="cat in categorias" v-if="cat.id==pro.categoria_id" >Categoria: {{cat.nombre}}</label>│
          <label  style="color: #000;" class="label label-success" >Marca: {{pro.marca}}</label>│
          <label  style="color: #000;" class="label label-warning" v-show="pro.modelo!=null">Modelo: {{pro.modelo}}</label>
          <label  style="color: #000;" class="label label-warning" v-show="pro.modelo==null">Modelo: ...</label>
        </div>


        <div class="form-group" >
                  <label style="color: #000;">Unidades por Caja : </label>
                  <input type="text"
                         name="cantidad_unidad_caja"
                         v-model="inventario.cantidad_unidad_caja"
                         placeholder="Cantidad de Unidades x Caja"
                         class="form-control"
                         id="valor10"
                         :class="{'is-danger':errors.cantidad_unidad_caja}" disabled>
                  <small v-if="errors.cantidad_unidad_caja" class="has-text-danger red1">{{errors.cantidad_unidad_caja[0]}}</small>
        </div>


        <div class="form-group" >
                  <label style="color: #000;">Unidades Para Salida: </label>
                  <input type="text"
                         name="cantidad_unidad_almacen"
                         v-model="inventario.cantidad_unidad_almacen"
                         placeholder="Cantidad de Unidades Adquiridas"
                         class="form-control"
                         id="valor20"
                         v-on:keyup="actualizarLista10"
                         :class="{'is-danger':errors.cantidad_unidad_almacen}">
                  <small v-if="errors.cantidad_unidad_almacen" class="has-text-danger red1">{{errors.cantidad_unidad_almacen[0]}}</small>
        </div>

        <div class="form-group" >
                  <label style="color: #000;">Cajas para Salida : </label>
                  <input type="text"
                         name="cantidad_caja_almacen"
                         v-model="inventario.cantidad_caja_almacen"
                         placeholder="Cantidad de Cajas Adquiridas"
                         class="form-control"
                         id="valor30"
                         v-on:keyup="actualizarLista20"
                         :class="{'is-danger':errors.cantidad_caja_almacen}">
                  <small v-if="errors.cantidad_caja_almacen" class="has-text-danger red1">{{errors.cantidad_caja_almacen[0]}}</small>
        </div>



        <div class="form-group">
            <label style="color: #000;">Precio de Venta por Unidad : </label>
                  <input type="text"
                         name="precio_venta_unidad"
                         v-model="inventario.precio_venta_unidad"
                         placeholder="Ingresar Precio de Venta"
                         class="form-control"
                         disabled
                         :class="{'is-danger':errors.precio_venta_unidad}">
                  <small v-if="errors.precio_venta_unidad" class="has-text-danger red1">{{errors.precio_venta_unidad[0]}}</small>
        </div>

        <div class="form-group">
            <label style="color: #000;">Detalle : </label>
                  

                  <textarea  class="form-control" name="detalle" v-model="inventario.detalle"  placeholder="Dellate"   maxlength="255" ></textarea>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary" @click="salidaInventario(inventario)">Registrar Salida</button>
        </div>
      </div>
    </div>
  </div>
</div>



<!-- Oferta  Modal -->
<div class="modal fade" id="myModalOferta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h4 class="modal-title" id="myModalLabel">   <i class="fa fa-stack-overflow"></i>&nbsp Producto para Añadir a Oferta</h4>
    </div>
    <div class="modal-body">


      <div class="form-group" v-for="pro in productos" v-if="pro.id==inventario.producto_id">
        <label  style="color: #000;" class="label label-info">Nombre: {{pro.nombre}}</label>│
        <label  style="color: #000;" class="label label-default" v-for="cat in categorias" v-if="cat.id==pro.categoria_id" >Categoria: {{cat.nombre}}</label>│
        <label  style="color: #000;" class="label label-success" >Marca: {{pro.marca}}</label>│
        <label  style="color: #000;" class="label label-warning" v-show="pro.modelo!=null">Modelo: {{pro.modelo}}</label>
        <label  style="color: #000;" class="label label-warning" v-show="pro.modelo==null">Modelo: ...</label>

      </div>



      <div class="form-group" >
        
              <label  style="color: #000;" class="label label-warning">Unidades por Caja : {{inventario.cantidad_unidad_caja}}</label>
      </div>

      <div class="form-group">
        <label class="label label-warning" v-for="pro in productos" v-if="pro.id==inventario.producto_id">{{pro.nota}}</label>
      </div>


      <div class="form-group" >
                
                <label  style="color: #000;" class="label label-warning">Unidades Disponibles : {{inventario.unidad_oferta}}</label>
                
      </div>

      <div class="form-group" >
                
                <label  style="color: #000;" class="label label-warning">Cajas Disponibles : {{inventario.caja_oferta}}</label>
                
      </div>


      <div class="form-group">
          <label style="color: #000;">Precio Nuevo : </label>
                <input type="text"
                       name="precio_venta_unidad"
                       v-model="inventario.precio_venta_unidad"
                       placeholder="Ingresar Precio de Venta"
                       class="form-control"
                       :class="{'is-danger':errors.precio_venta_unidad}">
                <small v-if="errors.precio_venta_unidad" class="has-text-danger red1">{{errors.precio_venta_unidad[0]}}</small>
                <label style="color: #000;" class="label label-warning">Precio de Venta por Unidad Anteiror: {{inventario.precioAnterior}}Bs</label>
      </div>

      <div class="form-group" >
                  <label style="color: #000;">Fecha de Limite : </label>
                  <input class="form-control" type="date" v-model="inventario.fecha"   min="2018-01-01" max="2050-1-1"  :class="{'is-danger':errors.cantidad_unidad_caja}">
                  <small v-if="errors.fecha_vencimiento" class="has-text-danger red1">{{errors.fecha_vencimiento[0]}}</small>

      </div>

      <div class="form-group">
        <label style="color: #000;">Tipo de Oferta : </label>
        <input type="text" v-model="inventario.oferta" placeholder="Eje. 2x1 o Rebaja 2%"  class="form-control">
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" @click="ofertaAgregar(inventario)">Guardas Oferta</button>
      </div>
    </div>
  </div>
</div>
</div>



   <!-- NOtificaion Modal -->
  <div class="modal fade" id="myModalNOtificacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel">   <i class="fa fa-stack-overflow"></i>&nbsp Enviar Notificacion</h4>
        </div>
        <div class="modal-body">

             <div class="form-group" >
                        <label>Titulo de Notificacion :</label>
                       <input type="text"
                           name="titulo"
                           placeholder="Tutilo"
                           class="form-control"
                           v-model="notificacion.titulo"  
                        >     
            </div>
            <div class="form-group" >
                <label>Tipos de Clientes :</label>
                <select name="clientes" class="form-control" v-model="notificacion.cliente"  >
                  <option value="" selected>Seleccionar Tipo Cliente</option>
                  <option value="1">Todos los Clientes</option>
                  <option value="2">Clientes que Adquirieron este Articulo</option>
                  <option value="3">Clientes que no Realizaron Pedidos</option>
                  <option value="4">Cliente en Especifico</option>
                </select>    
            </div>

            <div class="form-group" v-if="notificacion.cliente=='4'">
              <button class="btn btn-success btn-xs"  data-toggle="modal" data-target="#myModalCliente" style="margin-bottom: 5px;">
                <i class="fa fa-user"></i> Cliente
              </button>
              <br>
              <label>Cliente Seleccionado:</label>
              <input type="text"
                       name="precio_venta_unidad"
                       placeholder="Nombre del Cliente"
                       class="form-control"
                       disabled
                       v-model="notificacion.nombre"
                      >
              
            </div>
            



          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary" @click="notificacionGeneral()">Enviar</button>
          </div>
        </div>
      </div>
    </div>
  </div>


     <!-- Elejir cliente Modal -->
  <div class="modal fade" id="myModalCliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel">   <i class="fa fa-stack-overflow"></i>&nbsp Seleccionar Cliente</h4>
        </div>
        <div class="modal-body">



            <div class="form-group" >
              <label>Cliente Seleccionado :</label>
              <input type="text"
                       name="precio_venta_unidad"
                       placeholder="Nombre del Cliente"
                       class="form-control"
                       disabled
                       v-model="notificacion.nombre"
                      >
            </div>

            <table class="table table-striped table-advance table-hover">
                
                <thead>
                  <tr>
                    <th></th>
                    <th class="centered"><i class="fa fa-users"></i> Nombres</th>
                    <th class="centered"><i class="fa fa-envelope-o"></i> Correo</th>
                    <th class="centered"><i class=" fa fa-mobile"></i> Nuemero de Celular</th>                                          
                    <th></th>
                  </tr>
                </thead>
                <tbody >
                  <tr v-for="cli in clientes.data"  @click="seleccionarCliente(cli)" >
                    
                    <td></td>
                    <td >{{cli.cli_nombres }}&nbsp{{ cli.cli_apellidos}}</td>
                    <td class="centered" >{{cli.cli_usuario}} </td>
                    <td class="centered"><span>{{cli.cli_celular}}</span></td>
                    <td></td>
                  </tr>
                </tbody>
              

              </table>
                    <div class="card-footer"  >
                      <pagination :data="clientes" @pagination-change-page="getResults" class="dataTables_paginate paging_bootstrap pagination" ></pagination>
                  </div>
            

          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal" @click="limpiarCliente()">Cerrar</button>
            <button type="button" class="btn btn-primary" data-dismiss="modal">Seleccionar</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  </div>

</template>

<script>

  export default {
    data() {
      return {
        inventarios: {},
        inventario: {
          producto_id: '',
          cantidad_unidad_caja: '',
          cantidad_unidad_almacen: '',
          cantidad_caja_almacen: '',
          precio_compra_unidad: '',
          precio_venta_unidad: '',
          fecha_vencimiento: '',
          oferta:'',

          unidad_oferta:'',
          caja_oferta:'',
          precioAnterior:'',

          detalle:'',
          fecha:'',
        },

        productos: {},
        categorias: {},
        cat:{
          categoria:'',
        },
        errors: {},
        visible: true,
        oculto: false,
        visible2: true,
        oculto2: false,
        update: false,
        verunidad: false,
        vercaja: false,


        search:'',
        loading: true,

        asignar:'',
        iduser:'',

        filtros:{
          mas:'',
          val:'',
          min:'',
          max:'',
          publicar:'',
        },

        notificacion:{
          titulo:'',
          cliente:'',
          id_inventario:'',
          nombre:'',
          cliente_id:'',
        },

        inventariosPdf:{},
        clientes:{},


      }
    },

    created() {
      Fire.$on('searching',() => {
                let query = this.search;
                axios.get('findUser?q='+query)
                .then((data) => {
                    this.inventarios = data.data;
                })
                .catch(() => {

                })
            })
      this.LoadUser();
      Fire.$on('AfterCreate', () => {
        this.LoadUser();
      });
    },

    methods: {
      LoadUser() {
        axios.get('inventarios').then(res => {
          this.inventarios = res.data.inventarios;
          this.categorias = res.data.categorias;
          this.productos = res.data.productos;
          this.asignar=res.data.asignar;
          this.iduser=res.data.iduser;
          this.inventariosPdf = res.data.inventariosPdf;
          this.loading = false;
          this.clientes=res.data.clientes;
        });
      },

      getResults(page = 1) {
          axios.get('inventarios?page=' + page)
          .then(response => {
              this.inventarios = response.data.inventarios;
          });
      },

      //busqueda
      searchit: _.debounce(() => {
          Fire.$emit('searching');
      },1000),


      agregar(){
        let formData = new FormData();
        formData.append('producto_id', this.inventario.producto_id);
        formData.append('cantidad_unidad_caja', this.inventario.cantidad_unidad_caja);
        formData.append('cantidad_unidad_almacen', this.inventario.cantidad_unidad_almacen);
        formData.append('cantidad_caja_almacen', this.inventario.cantidad_caja_almacen);
        formData.append('precio_compra_unidad', this.inventario.precio_venta_unidad);
        formData.append('precio_venta_unidad', this.inventario.precio_venta_unidad);
        formData.append('fecha_vencimiento', this.inventario.fecha_vencimiento);

        axios.post('inventarios', formData).then((res) => {



               Fire.$emit('AfterCreate');



               toast.fire({
                 type: 'success',
                 title: 'Inventario Agregado Correctamente..!!!'
               });

               this.cat.categoria='';
               this.inventario.producto_id='';
               this.inventario.cantidad_unidad_caja='';
               this.inventario.cantidad_unidad_almacen='';
               this.inventario.cantidad_caja_almacen='';
               this.inventario.precio_compra_unidad='';
               this.inventario.precio_venta_unidad='';
               this.inventario.fecha_vencimiento='';

               this.errors.producto_id='';
               this.errors.cantidad_unidad_caja='';
               this.errors.cantidad_unidad_almacen='';
               this.errors.cantidad_caja_almacen='';
               this.errors.precio_compra_unidad='';
               this.errors.precio_venta_unidad='';
               this.errors.fecha_vencimiento='';




            }).catch((error)=>this.errors = error.response.data.errors);

      },

      //Eliminar
      deleteInventario(id){
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
                                axios.delete('inventarios/'+id).then(()=>{
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
                    })
            },

            salidaShow(item){
              this.inventario.id = item.id;
              this.inventario.producto_id = item.producto_id;
              this.inventario.cantidad_unidad_caja = item.cantidad_unidad_caja;
              this.inventario.cantidad_unidad_almacen = item.cantidad_unidad_almacen_dis;
              this.inventario.cantidad_caja_almacen = item.cantidad_caja_almacen_dis;
              this.inventario.precio_venta_unidad = item.precio_venta_unidad;
              this.inventario.precio_compra_unidad=item.precio_compra_unidad;
            },

            updateShow(item){
              this.inventario.id = item.id;
              this.inventario.producto_id = item.producto_id;
              this.inventario.cantidad_unidad_caja = item.cantidad_unidad_caja;
              this.inventario.cantidad_unidad_almacen = '';
              this.inventario.cantidad_caja_almacen = '';
              this.inventario.precio_compra_unidad = '';
              this.inventario.precio_venta_unidad = '';
              this.inventario.fecha_vencimiento = '';
            },

            updateInventario(item){
              const params = {
              producto_id : item.producto_id,
              cantidad_unidad_caja : item.cantidad_unidad_caja,
              cantidad_unidad_almacen : item.cantidad_unidad_almacen,
              cantidad_caja_almacen : item.cantidad_caja_almacen,
              precio_compra_unidad : item.precio_venta_unidad,
              precio_venta_unidad : item.precio_venta_unidad,
              fecha_vencimiento : item.fecha_vencimiento,
            };

            axios.put(`/inventarios/${item.id}`, params)
            .then((res) => {
                // success
              //$('#addNew').modal('hide');
               //$('.modal-backdrop').hide();
                this.update=false;

                 swal.fire(
                    'Nuevos Prodcutos!',
                    'La información ha sido actualizada.',
                    'success'
                    )
                    
                    Fire.$emit('AfterCreate');
                    this.inventario.cantidad_unidad_almacen='';
                    this.inventario.cantidad_caja_almacen='';
                    this.inventario.precio_compra_unidad='';
                    this.inventario.precio_venta_unidad='';




            }).catch((error)=>this.errors = error.response.data.errors);

            },

          actualizarLista: function() {
            if(this.inventario.cantidad_unidad_almacen!=''){
            this.inventario.cantidad_caja_almacen = this.inventario.cantidad_unidad_almacen/this.inventario.cantidad_unidad_caja;
            this.oculto=true;
            this.visible=false;
            }else{
              this.oculto=false;
              this.visible=true;
            }

          },

          actualizarLista1: function() {
            if(this.inventario.cantidad_caja_almacen!=''){
              this.inventario.cantidad_unidad_almacen = this.inventario.cantidad_unidad_caja*this.inventario.cantidad_caja_almacen;
              this.oculto2=true;
              this.visible2=false;
            }else{
              this.oculto2=false;
              this.visible2=true;
            }
          },

          actualizarLista10: function() {
            if(this.inventario.cantidad_unidad_almacen!=''){
            this.inventario.cantidad_caja_almacen = this.inventario.cantidad_unidad_almacen/this.inventario.cantidad_unidad_caja;
            this.oculto=true;
            this.visible=false;
            }else{
              this.oculto=false;
              this.visible=true;
            }

          },

          actualizarLista20: function() {
            if(this.inventario.cantidad_caja_almacen!=''){
              this.inventario.cantidad_unidad_almacen = this.inventario.cantidad_unidad_caja*this.inventario.cantidad_caja_almacen;
              this.oculto2=true;
              this.visible2=false;
            }else{
              this.oculto2=false;
              this.visible2=true;
            }
          },


        ofertaShow(item){
            this.inventario.id = item.id;
            this.inventario.producto_id = item.producto_id;
            this.inventario.cantidad_unidad_caja = item.cantidad_unidad_caja;
            this.inventario.unidad_oferta = item.cantidad_unidad_almacen_dis;
            this.inventario.caja_oferta = item.cantidad_caja_almacen_dis;
            this.inventario.precio_compra_unidad = item.precio_compra_unidad;
            this.inventario.precioAnterior = item.precio_venta_unidad;
            this.inventario.fecha_vencimiento = item.fecha_vencimiento;
          },

          ofertaAgregar(item){

              let formData = new FormData();
              formData.append('inventario_id', item.id);
              formData.append('cantidad_unidadxcaja', item.cantidad_unidad_caja);
              formData.append('cantidad_unidad_almacen', item.cantidad_unidad_almacen);
              formData.append('cantidad_caja_almacen', item.cantidad_caja_almacen);
              formData.append('precio_venta_unidad', item.precio_venta_unidad);
              formData.append('oferta', item.oferta);
              formData.append('fecha', item.fecha);
              axios.post('/ofertasCreate/',
                      formData,
                      {
                      headers: {
                          'Content-Type': 'multipart/form-data'
                      }
                    }
                  ).then((res) => {
                                     Fire.$emit('AfterCreate');
                                     this.limpiar();
                                     toast.fire({
                                       type: 'success',
                                       title: 'Producto Agregado Correctamente..!!!',

                                     });

                  }).catch((error)=>this.errors = error.response.data.errors);

          },



          limpiar(){
            this.cat.categoria='';
            this.inventario.producto_id='';
            this.inventario.cantidad_unidad_caja='';
            this.inventario.cantidad_unidad_almacen='';
            this.inventario.cantidad_caja_almacen='';
            this.inventario.precio_compra_unidad='';
            this.inventario.precio_venta_unidad='';
            this.inventario.fecha_vencimiento='';
            this.inventario.detalle='';
            this.inventario.fecha='';
          },

          validarUnidad : function() {
                if(this.inventario.unidad_oferta<this.inventario.cantidad_unidad_almacen){
                  this.inventario.cantidad_unidad_almacen='';
                  this.verunidad=true;
                  this.inventario.cantidad_caja_almacen='';
                }else {
                  this.verunidad=false;
                  this.inventario.cantidad_caja_almacen=this.inventario.cantidad_unidad_almacen/this.inventario.cantidad_unidad_caja;
                }

          },
          validarCaja : function() {
                if(this.inventario.caja_oferta<this.inventario.cantidad_caja_almacen){
                  this.inventario.cantidad_caja_almacen='';
                  this.vercaja=true;
                  this.inventario.cantidad_unidad_almacen='';
                }else {
                  this.vercaja=false;
                  this.inventario.cantidad_unidad_almacen=this.inventario.cantidad_caja_almacen*this.inventario.cantidad_unidad_caja;
                }

          },


           salidaInventario(item){

              let formData = new FormData();
              formData.append('inventario_id', item.id);
              formData.append('cantidad_unidadxcaja', item.cantidad_unidad_caja);
              formData.append('cantidad_unidad_almacen', item.cantidad_unidad_almacen);
              formData.append('cantidad_caja_almacen', item.cantidad_caja_almacen);
              formData.append('precio_venta_unidad', item.precio_venta_unidad);
              formData.append('detalle', item.detalle);
              formData.append('precio_compra_unidad', item.precio_compra_unidad);
              axios.post('/salidaProducto/',
                      formData,
                      {
                      headers: {
                          'Content-Type': 'multipart/form-data'
                      }
                    }
                  ).then((res) => {
                                    this.limpiar();
                                     Fire.$emit('AfterCreate');
                                     toast.fire({
                                       type: 'success',
                                       title: 'Salida de Producto Correcto..!!!',
                                     });
                                     

                  }).catch((error)=>this.errors = error.response.data.errors);

          },

          validar(item){
            if(item=="mas" || item=="precio" || item=='cantidad' || item=='salida' || item=='sinsalida'){
              this.filtros.min='';
              this.filtros.max='';
              this.consultaFiltro();
            }else{
              this.filtros.mas='';

              //this.consultaFiltro();
            }

           

          },
          validarPublicar(item){
            if(item=="Si" || item=="No"){
              this.filtros.min='';
              this.filtros.max='';
              this.filtros.mas='';
              this.consultaFiltro();
            }
          },

          minimo: function() {
            if(this.filtros.min!=''){
              if(this.filtros.min>0){
                  this.consultaFiltro()
              }else{
                this.filtros.min='';
              }
            }
          },
          maximo: function() {
            if(this.filtros.max!=''){
              if(this.filtros.max>0){
                  this.consultaFiltro()
              }else{
                this.filtros.max='';
              }
            }
          },



          consultaFiltro(){
             let formData = new FormData();

                  formData.append('mas', this.filtros.mas);
                  formData.append('min', this.filtros.min);
                  formData.append('max', this.filtros.max);  
                  formData.append('val', this.filtros.val); 
                  formData.append('publicar', this.filtros.publicar);  
                  
                  axios
                      .post('/consultaFiltros/', formData, {
                          headers: {
                              'Content-Type': 'multipart/form-data'
                          }
                      })
                      .then((data) => {
                        this.inventarios = data.data;

                          toast.fire({
                              type: 'success',
                              title: 'Ver Datos',
                          });
                      })
                      .catch(() => {});
          },

          notificacionGeneral(){
            let formData = new FormData();
            formData.append('titulo', this.notificacion.titulo);
            formData.append('id', this.notificacion.id_inventario);
            formData.append('cliente', this.notificacion.cliente);
            formData.append('cliente_id', this.notificacion.cliente_id);

            axios.post('/notificarCliente/', formData, {
                          headers: {
                              'Content-Type': 'multipart/form-data'
                          }
                      })
                      .then((data) => {
                        //this.inventarios = data.data;
                          toast.fire({
                              type: 'success',
                              title: 'Se envio una notificacion',
                          });
                            //Fire.$emit('AfterCreate');
                        this.notificacion.titulo='';
                        this.notificacion.cliente='';
                        this.notificacion.nombre='';
                        this.notificacion.cliente_id='';

                      })
                      .catch(() => {});
          },

          limpiarNotificacion(item){
            this.notificacion.id_inventario=item;
            this.notificacion.titulo='';
            this.notificacion.cliente='';
          },

          pdfReporte() {
              const params = {
                inventarios: this.inventariosPdf,
                productos: this.productos,
              };

              let timerInterval;
              swal
                .fire({
                  title: "Abriendo La Factura",
                  html: "<b></b> ",
                  timer: 1000,
                  timerProgressBar: true,
                  showConfirmButton: false,

                  didOpen: () => {
                    swal.showLoading();
                  },
                  willClose: () => {
                    clearInterval(timerInterval);
                  },
                })
                .then((result) => {
                  /* Read more about handling dismissals below */
                  if (result.dismiss === swal.DismissReason.timer) {
                    axios
                      .post("pdfResumido", params)
                      .then((data) => {
               
                          window.open(data.data, '_blank');

                      })
                      .catch(() => {
                        swal("¡Ha fallado!", "Había algo malo.", "warning");
                      });
                  }
                });
            },

          cambiarEstado(id){
            axios.get('/inventarios/estado/'+id).then(()=>{
              swal.fire(
                'Estado!',
                'Este Producto sera Visible a los Clientes',
                'success'
                )
                 Fire.$emit('AfterCreate');
                }).catch(()=> {
                  swal("¡Ha fallado!", "Había algo malo.", "warning");
                });
          },


          seleccionarCliente(cli){
            this.notificacion.nombre=cli.cli_nombres+' '+cli.cli_apellidos+ ' - '+ cli.cli_usuario;
            this.notificacion.cliente_id=cli.id;
          },
          limpiarCliente(){
            this.notificacion.nombre='';
            this.notificacion.cliente_id='';
          }
    }
  }

</script>
