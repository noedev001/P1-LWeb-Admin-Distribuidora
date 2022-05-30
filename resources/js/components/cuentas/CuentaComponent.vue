<template>

<div style="margin-top: 50px;">
    <div class="col-sm-3">
        <section class="panel">
            <div class="panel-body">
              <div class="btn btn-compose">
                    <i class="fa fa-pencil"></i> DetalllesCuentas
              </div>
                <ul class="nav nav-pills nav-stacked mail-nav">
                    <li class="active">
                        <a href="#" @click="pagos()"> <i class="fa fa-money"></i> Pagos <span class="label label-theme pull-right inbox-notification" ></span></a>
                    </li>

                    <li >
                        <a href="#" @click="depositosClientes()"> <i class="fa fa-inbox"></i> Depositos <span class="label label-theme pull-right inbox-notification" v-if="clientesDeposito.length>0">{{clientesDeposito.length}}</span></a>
                    </li>


                </ul>

                
            </div>
        </section>

        <section class="panel" v-show="pago">
            <div class="panel-body">
                <ul class="nav nav-pills nav-stacked labels-info " v-if="rol=='SuperAdmin' || rol=='Admin'">
                    <li>
                        <h4>Lista Clientes Saldos Pendientes</h4>
                    </li>
                    <li v-for="cli in clientesPago.data" >
                        <a href="#"  @click="pagosPedidos(cli.id, cli.fecha_entrega)">
                            <img class="img-circle" src="img/icons8-ajustes-de-usuario-64.png" width="32">{{cli.cli_nombres}} {{cli.cli_apellidos}}
                            <p><span>{{cli.cli_usuario}} </span> </p>
                            <p><span>{{cli.fecha_entrega}} </span> </p>
                        </a>
                    </li>

                </ul>
                <ul class="nav nav-pills nav-stacked labels-info " v-if="rol=='Dist'">
                    <li>
                        <h4>Lista Clientes Saldos Pendientes</h4>
                    </li>
                    <li v-for="cli in clientesPago.data"  v-if="cli.user_id==iduser">
                        <a href="#"  @click="pagosPedidos(cli.id, cli.fecha_entrega)">
                            <img class="img-circle" src="img/icons8-ajustes-de-usuario-64.png" width="32">{{cli.cli_nombres}} {{cli.cli_apellidos}}
                            <p><span>{{cli.cli_usuario}} </span> </p>
                            <p><span>{{cli.fecha_entrega}} </span> </p>
                        </a>
                    </li>

                </ul>

                <div class="card-footer"  >
                  <pagination :data="clientesPago" @pagination-change-page="getResults" class="dataTables_paginate paging_bootstrap pagination" ></pagination>
                </div>

            </div>
        </section>

        <section class="panel" v-show="depo">
            <div class="panel-body">
                <ul class="nav nav-pills nav-stacked labels-info " v-if="rol=='SuperAdmin' || rol=='Admin'">
                    <li>
                        <h4>Lista Clientes Depositos</h4>
                    </li>

                    <li>
                        <h4 > <a href="#"  @click="depositoNoVerificado()"> <label class="lec">No Verificados</label></a>  / <a href="#"  @click="depositoVerificado()"><label class="lec"> Verificado </label> </a></h4>
                    </li>
                      <hr>
                        <li v-for="cli in clientesDeposito" v-show="depositoNoVer">
                            <a href="#" v-if="cli.estado=='NoVerificado'" @click="deposito(cli.id)">
                                <img src="img/icons8-ajustes-de-usuario-64.png" class="img-circle" width="20">{{cli.cli_nombres}}  {{cli.cli_apellidos}}
                                <p><span class="label label-danger">No Verificado</span></p>
                            </a>
                        
                            
                        </li>

                        <li v-for="cli in clientesDepoVer.data" v-show="depositoVer">
                            <a href="#" @click="deposito(cli.id)">
                                <img src="img/icons8-ajustes-de-usuario-64.png" class="img-circle" width="20">{{cli.cli_nombres}} {{cli.cli_apellidos}}
                                <p><label class="lec">{{cli.cli_usuario}}</label></p>
                            </a>
                        </li>

                       <div class="card-footer"  v-show="depositoVer">
                           <!-- <pagination :data="clientesDepoVer" @pagination-change-page="getResultsDepo" class="dataTables_paginate paging_bootstrap pagination" ></pagination>-->
                      </div>               
                </ul>
                <ul class="nav nav-pills nav-stacked labels-info "  v-if="rol=='Dist'">
                    <li>
                        <h4>Lista Clientes Depositos</h4>
                    </li>

                    <li>
                        <h4 > <a href="#"  @click="depositoNoVerificado()"> <label class="lec">No Verificados</label></a>  / <a href="#"  @click="depositoVerificado()"><label class="lec"> Verificado </label> </a></h4>
                    </li>
                      <hr>
                        <li v-for="cli in clientesDeposito" v-show="depositoNoVer" v-if="cli.user_id==iduser">
                            <a href="#" v-if="cli.estado=='NoVerificado'" @click="deposito(cli.id)">
                                <img src="img/icons8-ajustes-de-usuario-64.png" class="img-circle" width="20">{{cli.cli_nombres}}  {{cli.cli_apellidos}}
                                <p><span class="label label-danger">No Verificado</span></p>
                            </a>
                        
                            
                        </li>

                        <li v-for="cli in clientesDepoVer.data" v-show="depositoVer" v-if="cli.user_id==iduser">
                            <a href="#" @click="deposito(cli.id)">
                                <img src="img/icons8-ajustes-de-usuario-64.png" class="img-circle" width="20">{{cli.cli_nombres}} {{cli.cli_apellidos}}
                                <p><label class="lec">{{cli.cli_usuario}}</label></p>
                            </a>
                        </li>

                       <div class="card-footer"  v-show="depositoVer">
                           <!-- <pagination :data="clientesDepoVer" @pagination-change-page="getResultsDepo" class="dataTables_paginate paging_bootstrap pagination" ></pagination>-->
                      </div>               
                </ul>
            </div>
        </section>

    </div>

    <!-- Depositos-->

    <div class="col-sm-9" v-show="depo">
        <section class="panel">
            <header class="panel-heading wht-bg">
                <h4 class="gen-case">
                      Detalles Depositos
                      <div class="pull-right mail-src-position">
                        <div class="input-append">
                         
                        </div>
                      </div>
                </h4>
            </header>
            <div class="panel-body minimal">
                
                <div class="table-inbox-wrap ">
                    <table class="table table-inbox table-hover">
                        <tr>
                              <td> <li class="btn mini tooltips">
                                <i class=" fa fa-user"> Nombre Cliente</i>
                            </li></td>
                              <td> <li class="btn mini">
                              Asunto
                            </li></td>
                              <td><li class="btn mini">
                            Monto
                            </li></td>
                              <td> <li class="btn mini">
                            Deposito
                            </li></td>
                            <td></td>
                              <td><li class="btn mini">
                            Estado
                            </li></td>
                        </tr>
                        <tbody v-for="de in depositos" v-if="de.cliente_id==cliente.id_cliente">
                            <tr class="unread" v-if="de.estado=='NoVerificado'">
                                <td class="view-message  " v-for="cli in clientes" v-if="de.cliente_id==cli.id"><label >{{cli.cli_nombres}} {{cli.cli_apellidos}}</label></td>
                                <td class="view-message " >{{de.asunto}}</td>
                                <td class="view-message ">{{de.monto}}</td>
                                <td class="view-message  inbox-small-cells" >
                                  <a class="fancybox " :href="`images/pagos/${de.fotoweb}`">
                                    <span class="label label-danger"><i class="fa fa-paperclip"></i></span>
                                  </a>
                                </td>
                                <td class="inbox-small-cells"><i class="fa fa-star"></i></td>
                                <td class="view-message  text-right">{{de.fecha}}</td>
                            </tr>

                            <tr class="" v-if="de.estado=='Verificado'">
                              <td class="view-message  " v-for="cli in clientes" v-if="de.cliente_id==cli.id"><label >{{cli.cli_nombres}} {{cli.cli_apellidos}}</label></td>
                              <td class="view-message ">{{de.asunto}}</td>
                              <td class="view-message ">{{de.monto}}</td>
                              <td class="view-message  inbox-small-cells">
                                <a class="fancybox " :href="`images/pagos/${de.fotoweb}`">
                                  <span class="label label-info"><i class="fa fa-paperclip"></i></span>
                                </a>
                              </td>
                              <td class="inbox-small-cells"><i class="fa fa-star inbox-started"></i></td>
                              <td class="view-message  text-right">{{de.fecha}}</td>
                            </tr>
                          
                          
                        </tbody>
                    </table>

                </div>
            </div>
        </section>
    </div>


    <!-- Pagos -->
    <div class="col-sm-9" v-show="pago">
        <section class="panel">
            <header class="panel-heading wht-bg">
                <h4 class="gen-case">
                      Detalles Pagos

                    <div class="pull-right mail-src-position">
                      <div class="input-append">
                       <!-- <input type="search" class="form-control " placeholder="Buscar Clientes" @keyup="searchit" v-model="search">-->
                      </div>
                    </div>
                </h4>
            </header>


            <div class="panel-body ">
              <div class="mail-header row">
                <div class="col-md-8">
                  <h4 class="pull-left" v-for="cli in clientes" ><label v-if="cli.id==pagosCliente.id_cliente"> {{cli.cli_nombres}} {{cli.cli_apellidos}}</label></h4>
                </div>
                <div class="col-md-4">
                  <div class="compose-btn pull-right">
                    <a href="#" class="btn btn-sm btn-theme" data-toggle="modal" data-target="#myModalPagos"><i class="fa fa-dollar"></i> Realizar un Pago</a>
                  </div>
                </div>
              </div>
              <div class="mail-sender">
                <div class="row">
                  <div class="col-md-8" v-for="cli in clientes"  >
                    <div v-if="cli.id==pagosCliente.id_cliente">
                      <i class="fa fa-male"></i>
                      <span>[{{cli.cli_usuario}}]</span>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <p class="date" style="color:#117864;" > Fecha del Pedido {{pagosCliente.fecha_entrega}} </p>  
                  </div>
                  <div class="col-md-4 rigth">
                     <a href="#" class="btn btn-sm btn-theme" data-toggle="modal" data-target="#myModalProductos"><i class="fa fa-plus-square"></i> Mas..</a>
                     <a href="#" class="btn btn-sm btn-success" data-toggle="modal" data-target="#myModalNoti"><i class="fa fa-bell"></i> Notificacion Pago</a>
                  </div>
                </div>
              </div>
              <div class="attachment-mail">
                <p>
                  <span><i class="fa fa-money"></i> PAGOS </span> <span class="pull-right" v-for="fe in fecha" v-if="pagosCliente.id_cliente==fe.cliente_id"> <a href="" @click="eliminarfechapago()">Proxima fecha de Pago {{fe.fecha_entrega | myDate1}} ///</a><br></span>
                </p>

                  <div class="panel-body minimal"  v-for="pre in precioTotal" v-if="pre.cliente_id==pagosCliente.id_cliente && pagosCliente.fecha_entrega==pre.fecha_entrega">
                    <h4><i class="fa fa-angle-right"></i> Saldo Total :  {{saldosPagos.total=pre.PrecioTotal}} Bs.</h4>
          
                    <hr>
                      <div class="table-inbox-wrap ">
                          <table class="table table-hover">
                            <thead >
                              <tr class="green">
                                <th class="centered">Forma de Pago</th>
                                <th class="centered">Monto</th>
                                <th class="centered">Deposito</th>
                                <th class="centered">Fecha de Pago</th>
                                <th></th>
                              </tr>
                            </thead>
                              <tbody class="centered">
                                  <tr class="unread" v-for="pa in pagosShow" v-if="pagosCliente.id_cliente==pa.cliente_id && pagosCliente.fecha_entrega==pa.fecha_entrega">
                                      <td >{{pa.forma_pago}}</td>
                                      <td >{{pa.monto}} Bs.</td>
                                      <td class="view-message  inbox-small-cells" >
                                        <label v-if="pa.foto_pago!=null">
                                            <a class="fancybox "  :href="`images/pagos/${pa.foto_pago}`">
                                              <span class="label label-warning"><i class="fa fa-paperclip"></i></span>
                                            </a>
                                        </label>
                                        <label v-else>
                                          ---
                                        </label>
                                      </td>
                                      <td >{{pa.fecha_pago}}</td>
                                      <td>
                                        <button class="btn btn-danger btn-xs" @click="eliminar(pa.id)"><i class="fa fa-trash-o "></i></button>
                                      </td>
                                  </tr>

                              </tbody>
                          </table>

                      </div>
                  </div>

              </div>
              <div class="group-rom blue">
                <div class="group-rom last-group" v-for="sa  in saldos" v-if="sa.cliente_id==pagosCliente.id_cliente && pagosCliente.fecha_entrega==sa.fecha_entrega">
                  <div class="first-part odd">Saldo Pagado </div>
                  <div class="second-part odd  centered" style="color:#000;"  >
                    <label>
                       {{sa.SaldoPagados}} bs.
                     </label>
                    
                  </div>
              
                </div>

                <div class="group-rom last-group"  v-for="pre in precioTotal" v-if="pre.cliente_id==pagosCliente.id_cliente && pagosCliente.fecha_entrega==pre.fecha_entrega">
                  <div class="first-part odd">Saldo Por Pagar</div>
                  <div class="second-part odd centered" style="color:#000;">
                    <label v-for="(sa, index) in saldos" > 
                        <label v-if="sa.cliente_id==pagosCliente.id_cliente && pagosCliente.fecha_entrega==sa.fecha_entrega">{{saldosPagos.faltante=(pre.PrecioTotal-sa.SaldoPagados)}} bs.</label>
                        <label v-else-if="((index+1) >= dis) && (saldosPagos.faltante==0 || saldosPagos.faltante==pre.PrecioTotal)"> {{saldosPagos.faltante=pre.PrecioTotal}} Bs</label>
                    </label>
                    <label v-if="saldos.length==0">{{saldosPagos.faltante=pre.PrecioTotal}} Bs</label>
                  </div>

                </div>

                </div>

            </div>
        </section>
    </div>







    <!-- Pagos Modal-->
  <div class="modal fade" id="myModalPagos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel">   <i class="fa fa-stack-overflow"></i>&nbsp Realizar un Pago</h4>
        </div>
        <div class="modal-body">

          <div class="panel-body">

            <div class="compose-mail">

                <div class="form-group">
                    <label for="to" class="">Forma:</label>

                      <select name="categoria" class="form-control" v-model="pagoForma.forma"   >
                          <option value="" selected>Seleccione una Forma de Pago...</option>
                          <option :value="1"  v-for="de in depositos" v-if="de.estado=='NoVerificado' && de.cliente_id==pagosCliente.id_cliente">Deposito</option>
                          <option :value="2">Efectivo</option>
                      </select>


                </div>

                <div class="form-group" v-show="pagoForma.forma=='1'">
                    <label for="to" class="">Deposito:</label>

                    <select name="categoria" class="form-control" v-model="pagoForma.id_deposito" >
                        <option selected>Seleccione el Deposito...</option>
                        <option :value="de.id" v-for="de in depositos" v-if="de.estado=='NoVerificado' && de.cliente_id==pagosCliente.id_cliente">Fecha:{{de.fecha}} - Monto: {{de.monto}} Bs</option>
                    </select>

                </div>

                <div class="form-group" v-show="pagoForma.forma=='1'">
                  <label for="subject" class="">Monto: </label>
                  <label for="subject" v-for="de in depositos" v-if="de.id==pagoForma.id_deposito" >{{pagoForma.monto=de.monto}} </label>
                </div>

                <div class="form-group" v-show="pagoForma.forma=='2'">
                  <label for="subject" class="">Monto: </label>
                  <input type="number"  class="form-control" v-model="pagoForma.monto"  v-on:keyup="montoControl">
                </div>

                <div class="form-group" v-show="pagoForma.forma=='1'">
                  <label for="direccion" class="">Foto: </label>
                  <div class="photo " v-for="de in depositos" v-if="de.id==pagoForma.id_deposito"  >
                    <a class="fancybox " :href="`images/pagos/${pagoForma.foto=de.fotoweb}`">
                      <img class="img-responsive " :src="`images/pagos/${pagoForma.foto=de.fotoweb}`" style=" width: 350px;height: 200px;" alt="">
                    </a>
                  </div>
                </div>
                <input type="hidden" v-for="de in depositos" v-if="de.id==pagoForma.id_deposito" v-model="pagoForma.fechadeposito=de.fecha">

                  <label style="color: red;" v-if="saldosPagos.faltante!=''"> El saldo faltante es de : {{saldosPagos.faltante}} Bs.</label>

            </div>
          </div>

          <div class="modal-footer">
              <button class="btn btn-theme btn-sm" @click="guardarPagos()"><i class="fa fa-check"></i> Guardar</button>
              <button class="btn btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
          </div>

        </div>
      </div>
    </div>
  </div>


 <!-- Productos Modal-->
      <div class="modal fade" id="myModalProductos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="myModalLabel">   <i class="fa fa-stack-overflow"></i>&nbsp Productos Adquiridos</h4>
            </div>
            <div class="modal-body">

              <div class="panel-body">

                <div v-for="(pe, aux) in pedidos">
                  <div v-if="pe.cliente_id==pagosCliente.id_cliente && pe.fecha_entrega==pagosCliente.fecha_entrega && pe.estatus=='Entregado'">
                    <div class="room-box" >

                        <h5 class="text-primary" v-for="ped in detallepedido[aux].inventarios" >
                          <p v-for="inv in inventarios" v-if="inv.id==ped.id" >
                            <label v-for="pro in productos" v-if="inv.producto_id==pro.id">{{pro.nombre}}</label>
                          </p>
                        </h5>
                        <div v-for="ped in detallepedido[aux].inventarios">
                        <p v-for="inv in inventarios" v-if="inv.id==ped.id">
                          <label v-for="pro in productos" v-if="inv.producto_id==pro.id">
                          <label class="label label-success" >{{pro.marca}}</label>
                          <label class="label label-primary" >{{pro.modelo}}</label>
                          <label class="label label-theme" >{{pro.medida}}</label>
                        </label></p>
                        </div>
                        <p><span class="text-muted">Precio Unidad : </span>{{pe.precio_unidad}} |
                          <span class="text-muted">Precio Total : {{pe.precio_total}} </span> |
                          <span class="text-muted" v-show="pe.cantidad_caja>0">Cantidad Pedido Caja :  {{pe.cantidad_caja}} </span>
                          <span class="text-muted" v-show="pe.cantidad_unidad>0">Cantidad Pedido Unidad :  {{pe.cantidad_unidad}} </span>
                        </p>

                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>


      <!-- Notificaciones Modal-->
      <div class="modal fade" id="myModalNoti" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="myModalLabel">   <i class="fa fa-stack-overflow"></i>&nbsp Enviar Un Recordatorio De Pago</h4>
            </div>
            <div class="modal-body">

              <div class="panel-body">

               <div class="form-group" >
                    <label style="color: #000;">Fecha De Salida  : </label>
                    <input type="date"    min="2018-01-01" max="2050-1-1" v-model="noti.fecha"  >
                 

               </div>
               
                <div class="form-group">
                  <label class=""  style="color: #000;">Hora : </label> <label class="">09:30:30    /  19:30:30 </label>
                  <div class="">
                    <div class="input-group bootstrap-timepicker">
                      <input type="text" class="form-control timepicker-24" v-model="noti.hora" placeholder="16:30:00">
                      <span class="input-group-btn">
                        <button class="btn btn-theme04" type="button"><i class="fa fa-clock-o"></i></button>
                      </span>
                    </div>
                  </div>
                </div>

                 <div class="form-group" >
                  <label style="color: #000;">Evento : </label>
                  <input type="text"
                         name="precio_compra_unidad"
                         v-model="noti.mensaje"
                         placeholder="Evento"
                         class="form-control"
                        >
                </div>

               <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                  <button type="button" class="btn btn-primary" @click="enviarNotificacion()">Enviar Notificacion</button>
                </div>

                          
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
                depositos: {},
                clientesDeposito: {},
                clientesPago:{},
                pedidos:{},
                detallepedido:{},
                inventarios:{},
                productos:{},
                clientes:{},
                precioTotal:{},
                pagosShow:{},
                saldos:{},
                clientesDepo:{},
                clientesDepoVer:{},
                cuotas:{},

                pagoForma:{
                  forma:'',
                  id_deposito:'',
                  monto:'',
                  foto:'',
                  fechadeposito:'',
                },

                saldosPagos:{
                  faltante:'',
                  total:'',
                },

                cliente:{
                  id_cliente:'',
                },

                pagosCliente:{
                  id_cliente:'',
                  fecha_entrega:'',
                
                },

                depo: false,
                pago: true,
                cuen: false,

                depositoNoVer: false,
                depositoVer:  true,
                search:'',
                dis:'',
                noti:{
                  fecha:'',
                  mensaje:'',
                  hora:'',
                },
                fecha:{},

                asignar:{},
                iduser:'',
                usuarios:{},
                rol:'',

            }
        },
        created() {
              Fire.$on('searching',() => {
                        let query = this.search;
                        axios.get('busquedaPagos?q='+query)
                        .then((data) => {
                            this.clientesPago = data.data;
                        })
                        .catch(() => {

                        })
                    })
            this.LoadCuenta();
            Fire.$on('AfterCreate', () => {
                this.LoadCuenta();
            });
        },

        methods: {

             searchit: _.debounce(() => {
                Fire.$emit('searching');
            },1000),

          getResults(page = 1) {
                    axios.get('cuentas?page=' + page)
                    .then(response => {
                        this.clientesPago = response.data.clientesPago;
                    });
                },

          getResultsDepo(page = 1) {
                    axios.get('cuentas?page=' + page)
                    .then(response => {
                        this.clientesDepoVer= response.data.clientesDepositoVerificado;
                    });
                },

            LoadCuenta() {
                    axios.get('cuentas').then(res => {
                        this.depositos = res.data.depositos;
                        this.clientesDeposito = res.data.clientesDeposito;
                        this.clientesPago = res.data.clientesPago;
                        this.pedidos = res.data.pedidos;
                        this.detallepedido = res.data.detallepedido;
                        this.inventarios =  res.data.inventarios;
                        this.productos = res.data.productos;
                        this.clientes =  res.data.clientes;
                        this.precioTotal = res.data.precioTotal;
                        this.pagosShow = res.data.pagos;
                        this.saldos =  res.data.saldos;
                        this.clientesDepo = res.data.clientesDepo;
                        this.clientesDepoVer = res.data.clientesDepositoVerificado;
                        if(res.data.idpagocliente.length!=0){
                          this.pagosPedidos(res.data.idpagocliente[0].cliente_id,res.data.idpagocliente[0].fecha_entrega);
                        }
                        if(res.data.iddepositocliente.length!=0){
                          this.cliente.id_cliente=res.data.iddepositocliente[0].cliente_id;
                        }
                        this.loading = false;
                        this.dis=res.data.saldos.length;
                        this.cuotas = res.data.cuotas;
                        this.fecha=res.data.fechaproximo;

                        this.asignar=res.data.asignar;
                        this.iduser=res.data.iduser;
                        this.usuarios=res.data.usuarios;
                        this.rol=res.data.rol;
                    });
                },

                

                depositosClientes() {
                    this.depo = true;
                    this.cuen = false;
                    this.pago = false;
                },

                deposito(id) {
                  this.cliente.id_cliente=id;
                },

                pagos(){
                  this.pago=true;
                  this.depo=false;
                },

                pagosPedidos(id,fecha){
                  this.pagosCliente.id_cliente=id;
                  this.pagosCliente.fecha_entrega=fecha;
                  this.saldosPagos.faltante=0;
                },

                guardarPagos(){
                  let formData = new FormData();
                  if(this.pagoForma.forma=='1'){
                    formData.append('forma_pago', "Deposito");
                    formData.append('monto', this.pagoForma.monto);
                    formData.append('foto', this.pagoForma.foto);
                    formData.append('fecha_entrega', this.pagosCliente.fecha_entrega);
                    formData.append('fecha_deposito', this.pagoForma.fechadeposito);
                    formData.append('cliente_id', this.pagosCliente.id_cliente);
                    formData.append('deposito_id', this.pagoForma.id_deposito);
                  }
                  if(this.pagoForma.forma=='2'){
                    formData.append('forma_pago', "Efectivo");
                    formData.append('monto', this.pagoForma.monto);
                    formData.append('foto', ' ');
                    formData.append('fecha_entrega', this.pagosCliente.fecha_entrega);
                    formData.append('fecha_deposito', ' ');
                    formData.append('cliente_id', this.pagosCliente.id_cliente);
                  }

                  formData.append('saldototal', this.saldosPagos.total);
                  formData.append('faltante', this.saldosPagos.faltante);


                  axios.post('cuentas',
                          formData,
                          {
                          headers: {
                              'Content-Type': 'multipart/form-data'
                          }
                        }
                      ).then((res) => {


                                toast.fire({
                                      type: 'success',
                                      title: 'Producto Agregado Correctamente..!!!',

                                });
                            Fire.$emit('AfterCreate');

                            this.pagoForma.forma='';
                            this.pagoForma.id_deposito='';
                            this.pagoForma.monto="";

                      }).catch((error)=>this.errors = error.response.data.errors);
                },


                depositoNoVerificado(){
                  this.depositoNoVer = true;
                  this.depositoVer = false;
                },
                
                depositoVerificado(){
                  this.depositoNoVer = false;
                  this.depositoVer = true;
                },

                 eliminar(id){
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
                                      axios.delete('cuentas/'+id).then(()=>{
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

          montoControl: function() {
            if(this.pagoForma.monto!=''){
              if(this.saldosPagos.faltante-this.pagoForma.monto < 0){
                  this.pagoForma.monto=0;
              }
            }else{
              this.pagoForma.monto='';
            }

          },


          enviarNotificacion(){
              let formData = new FormData();
              formData.append('fecha', this.noti.fecha);
              formData.append('hora', this.noti.hora);
              formData.append('evento', this.noti.mensaje);
              formData.append('id', this.cliente.id_cliente);

               axios.post('pagonotificacion',
                          formData,
                          {
                          headers: {
                              'Content-Type': 'multipart/form-data'
                          }
                        }
                      ).then((res) => {


                                toast.fire({
                                      type: 'success',
                                      title: 'Producto Agregado Correctamente..!!!',

                                });
                            Fire.$emit('AfterCreate');
                            this.noti.fecha='';
                            this.noti.hora='';
                            this.noti.mensaje='';

                        
                      }).catch((error)=>this.errors = error.response.data.errors);
          }


          

        }



}

</script>
