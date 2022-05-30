<template>
 <section class="wrapper">
  <div class="col-lg-9 main-chart">
<div class="centered">
    <h1>BIENVENIDO</h1>
    <h3>a la</h3> 


</div>

    <div class="border-head centered">
   <h3>Distribuidora E&E</h3> 
    </div>

    <div class="row" style="margin-top: 120px;">

              <div class="col-lg-4 col-md-4 col-sm-4 mb" >
                <div class="product-panel-2 pn" v-for="ve in venta">
                  <div class="badge badge-hot">Venta</div>
                  <img src="img/carrito.png" width="120" alt="">
                  
                  <h5 class="mt">Ultimo Producto Vendido</h5>
                  <h5 class="mt">{{ve.nombre}}-{{ve.marca}}</h5>
      
                  <button class="btn btn-small btn-theme04">Precio {{ve.precio_venta_unidad}}bs</button>
                </div>
              </div>

 

                       <div class="col-md-4 col-sm-4 mb">
                <div class="darkblue-panel pn">
                  <div class="darkblue-header">
                    <h5>Cantidad de Clientes</h5>
                  </div>
                  <h1 class="mt"><i class="fa fa-user fa-3x"></i></h1>
                  <p>Total Clientes</p>
                  <footer>
                    <div class="centered">
                      <h5 v-for="cli in cliente"><i class="fa fa-trophy"></i> {{cli.clientes}}</h5>
                    </div>
                  </footer>
                </div>
                <!--  /darkblue panel -->
              </div>

                <div class="col-lg-4 col-md-4 col-sm-4 mb">
                <div class="content-panel pn" v-for="da in datos">
                  <div id="profile-01">
                    <h3>{{da.cli_nombres}} {{da.cli_apellidos}}</h3>
        
                    <h6>Ultimo Pedido Realizado</h6>
                  </div>
                  <div class="profile-01 centered">
                    <p><i class="fa fa-mobile-phone"></i> {{da.cli_celular}}</p>
                  </div>
                  <div class="centered">
                    <h6><i class="fa fa-envelope"></i><br/>{{da.cli_usuario}}</h6>
                    
                  </div>
                </div>
                </div>
                

    </div>

          <div class="row">
            
              <div class="col-md-12 mb">
                <div class="message-p pn">
                  <div class="message-header">
                    <h5>ENVIAR AVISIS A LOS CLIENTES</h5>
                  </div>
                  <div class="row">
                    <div class="col-md-3 centered hidden-sm hidden-xs" style="padding-top: 6%;">
                      <h3>Enviar Aviso</h3>
                    </div>
                    <div class="col-md-9" style="padding-top: 4%; border-right-width: 0px; border-right-style: solid;padding-right: 25px;">
                      <p>
                        Mensaje
                      </p>
          
                 
                      
                        <div class="form-group">
                          <input type="text" class="form-control" v-model="conf.aviso" id="exampleInputText" placeholder="Ej. Gracias por confiar en Nosotros">
                        </div>
                        <button type="submit" class="btn btn-default" @click="notificar()" v-if="conf.fecha!='' && conf.aviso!=''">Enviar</button>
                     
                       <div class="pull-right position" >
                       <button class="btn btn-default btn-xs" style="margin-top: 20px;margin-right: 20px;" data-toggle="modal" data-target="#myModalAviso">
                        <i class="fa fa-cog" style="color:red;"> </i> 
                      </button>
                    </div>
                    </div>
                   
                  </div>
                </div>
                
              </div>
       
            </div> 


 </div>

             <div class="col-lg-3 ds">

                 <h4 class="centered mt">EQUIPO CONECTADO</h4>
            <!-- First Member -->
            <div class="desc" v-if="equipo.length<=0">
              <div class="thumb">
              </div>
              <div class="details">
                <p>
                   <a >Ningun Usuario Conectado</a>
                </p>
              
              </div>
            </div>

            <div class="desc" v-for="co in equipo">
              <div class="thumb">
 
                <img class="img-circle" src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image" alt=""  v-if="co.avatar==''" width="45px" height="45px" align=""/>
                <img class="img-circle" :src="`images/profile/${co.avatar}`" alt="" width="45px" height="45px" align="" v-if="co.avatar!=''"/>
              </div>
              <div class="details">
                <a >{{co.name}}</a><br/>
                <p>
                  
                  {{co.email}}<br/>
                   inicio <a >{{co.created_at | myDate1}}</a>
                </p>
              
              </div>
            </div>
            <!-- Second Member -->



            <div id="calendar" class="mb">
              <div class="panel green-panel no-margin">
                <div class="panel-body">
                  <div id="date-popover" class="popover top" style="cursor: pointer; disadding: block; margin-left: 33%; margin-top: -50px; width: 175px;">
                    <div class="arrow"></div>
                    <h3 class="popover-title" style="disadding: none;"></h3>
                    <div id="date-popover-content" class="popover-content"></div>
                  </div>
                  <div id="my-calendar"></div>
                </div>
              </div>
            </div>
             </div>

  <!-- Notificaion Modal -->
  <div class="modal fade" id="myModalAviso" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel">   <i class="fa fa-stack-overflow"></i>&nbsp Configurar Aviso</h4>
        </div>
        <div class="modal-body">

            <div class="form-group" >
                <label>Tipos de Clientes :</label>
                <select name="clientes" class="form-control" v-model="conf.cliente"  >
                  <option value="" selected>Seleccionar Tipo Cliente</option>
                  <option value="1">Todos los Clientes</option>
                  <option value="4">Cliente en Especifico</option>
                </select>    
            </div>

            <div class="form-group" v-if="conf.cliente=='4'">
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
                       v-model="conf.nombre"
                      >
              
            </div>

            <div class="form-group" v-if="conf.cliente=='4'  || conf.cliente=='1'" >
                <label>Fecha limite de Aviso :</label>
                <input class="form-control" type="date" v-model="conf.fecha"   min="2021-01-01" max="2050-1-1" >    
            </div>
            



          <div class="modal-footer">
     
            <button type="button" class="btn btn-primary" data-dismiss="modal">Aplicar</button>
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
                       v-model="conf.nombre"
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

 
 </section>

 
</template>

<script>
 
    export default {
        data(){
            return{
                equipo:{},
                venta:{},
                cliente:{},
                datos:{},
                conf:{
                  aviso:'',
                  cliente:'',
                  nombre:'',
                  cliente_id:'',
                  fecha:'',
                },
                clientes:{},

               
            }
        },

        created() {

            this.LoadHome();
            Fire.$on('AfterCreate', () => {
                this.LoadHome();
            });
        },

        methods: {


            LoadHome(){
              axios.get('home').then(res => {
                        this.equipo = res.data.equipo;
                        this.venta = res.data.venta;
                        this.cliente= res.data.cliente;
                        this.datos =res.data.datos;
                        this.clientes = res.data.clientes;
     

                    });
            },

                  getResults(page = 1) {
          axios.get('clientes?page=' + page)
          .then(response => {
              this.clientes = response.data.clientes;
          });
      },

            notificar(){
              const parametros={
                aviso: this.conf.aviso,
                cliente_id: this.conf.cliente_id,
                fecha: this.conf.fecha,
                cliente: this.conf.cliente,
              }


              axios.post('mensajes', parametros)
              .then(res=>{
                //Fire.$emit('AfterCreate');
                toast.fire({
                  type: 'success',
                  title: 'Notificacion enviada Correctamente..!!!'
                });

              }).catch((error)=>this.errors = error.response.data.errors);
            },

            seleccionarCliente(cli){
            this.conf.nombre=cli.cli_nombres+' '+cli.cli_apellidos+ ' - '+ cli.cli_usuario;
            this.conf.cliente_id=cli.id;
          },
           limpiarCliente(){
            this.conf.nombre='';
            this.conf.cliente_id='';
          }


        }
    }
</script>


