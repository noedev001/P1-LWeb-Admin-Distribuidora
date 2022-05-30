<template>

      <div class="nav notify-row" id="top_menu noti">

          
        <!--  notification start -->
        <ul class="nav top-menu">
          <!-- notificacion sugerencias -->
           <li id="header_inbox_bar" class="dropdown"  v-if="rol=='SuperAdmin' || rol=='Admin'">
            <a data-toggle="dropdown" class="dropdown-toggle" href="index.html#">
              <i class="fa fa-comments-o"></i>
              <span class="badge bg-theme" v-if="sugerencia.length>0">{{sugerencia.length}}</span>
              </a>
            <ul class="dropdown-menu extended inbox" v-if="sugerencia.length>0">
              <div class="notify-arrow notify-arrow-green"></div>
              <li>
                <p class="green">Tiene {{sugerencia.length}} nuevas notificaciones</p>
              </li>
              <li v-for="su in sugerencia" >
                
                <a href="sugerencias" @click="estado(su.id)">
                  <span class="photo">
                    <img alt="avatar" :src="`${su.foto}`">
                  </span>
                  <span class="subject">
                  <span class="from">{{su.cli_nombres}} {{su.cli_apellidos}}</span>
                  <span class="time">{{su.created_at | myDate4}}</span>
                  </span>
                  <span class="message">
                  Nueva Sugerencia
                  </span>
                  </a>
                  
              </li>
              
            </ul>
          </li>

          <!-- notificacion deposito -->
          <li id="header_inbox_bar" class="dropdown" >
            <a data-toggle="dropdown" class="dropdown-toggle" href="index.html#">
              <i class="fa fa-hdd-o"></i>
              <span class="badge bg-success" v-if="depositos.length>0">{{depositos.length}}</span>
              </a>
            <ul class="dropdown-menu extended inbox" v-if="depositos.length>0">
              <div class="notify-arrow notify-arrow-green"></div>
              <li>
                <p class="green">{{depositos.length}} depositos pendientes</p>
              </li>
              <li v-for="de in depositos" >
                
                <a href="cuentas">
                  <span class="photo"><img alt="avatar" :src="`${de.foto}`"></span>
                  <span class="subject">
                  <span class="from">{{de.cli_nombres}} {{de.cli_apellidos}}</span>
                  <span class="time">{{de.fecha | myDate4}}</span>
                  </span>
                  <span class="message">
                  Deposito hecho de {{de.monto}} bs.
                  </span>
                  </a>
                  
              </li>
              
            </ul>
          </li>




          <!-- productos oferta-->
          <li id="header_notification_bar " class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="index.html#">
              <i class="fa fa-bell-o"></i>
              <span class="badge bg-warning" v-if="oferta.length>0">{{oferta.length}}</span>
              </a>
            <ul class="dropdown-menu extended notification" v-if="oferta.length>0">
              <div class="notify-arrow notify-arrow-yellow"></div>
              <li>
                <p class="yellow">{{oferta.length}} Productos en Ofeta o Descuento</p>
              </li>
              <li v-for="o in oferta">
                <a href="ofertas">

                  <span class="label label-danger"><i class="fa fa-bell"></i></span>
                  <span class="subject">
                  <span class="from">{{o.nombre}} {{o.marca}} </span>
                  <span class="time pull-right position">Lim. {{o.fecha | myDate4}}</span>
                  </span>
                  <span class="message centered ">
                  <br>{{o.oferta}}
                  </span>                  
                  </a>
              </li>
            
              <li>
                <a href="ofertas">Productos en Oferta</a>
              </li>
            </ul>
          </li>  


          <!-- settings start -->
          <li class="dropdown" v-if="rol=='SuperAdmin' || rol=='Admin'">
            <a data-toggle="dropdown" class="dropdown-toggle" href="index.html#">
              <i class="fa fa-tasks"></i>
              <span class="badge bg-theme" v-if="productos.length>0">{{productos.length}}</span>
              </a>

            <ul class="dropdown-menu extended tasks-bar" v-if="productos.length>0">
              <div class="notify-arrow notify-arrow-green"></div>
              <li>
                <p class="green">Tienes {{productos.length}} productos Bajos en Almacen</p>
              </li>
              <li v-for="pro in productos">
                <a href="inventarios">
                  <div class="task-info">
                    <div class="desc">{{pro.nombre}} {{pro.marca}}</div>
                    <div class="percent">{{pro.promedio}}%</div>
                  </div>
                  <div class="progress progress-striped" v-if="pro.promedio<100 && pro.promedio>=85">
                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" :style="`width: ${pro.promedio}%`">
                      <span class="sr-only">85 a 100(success)</span>
                    </div>
                  </div>
                  <div class="progress progress-striped" v-if="pro.promedio<85 && pro.promedio>=50">
                    <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" :style="`width: ${pro.promedio}%`">
                      <span class="sr-only">50 a 85 (info)</span>
                    </div>
                  </div>
                  <div class="progress progress-striped" v-if="pro.promedio<50 && pro.promedio>=25">
                    <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" :style="`width: ${pro.promedio}%`">
                      <span class="sr-only">25 a 50 (warning)</span>
                    </div>
                  </div>
                  <div class="progress progress-striped" v-if="pro.promedio<25 && pro.promedio>=0">
                    <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" :style="`width: ${pro.promedio}%`">
                      <span class="sr-only">0 a 25 (danger)</span>
                    </div>
                  </div>
                </a>
              </li>

              <li class="external">
                <a href="inventarios">Inventario</a>
              </li>
            </ul>
          </li>
          <!-- settings end -->

          <!-- notificacion sugerencias -->
           <li id="header_inbox_bar" class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="index.html#">
              <i class="fa fa-shopping-cart"></i>
              <span class="badge bg-theme" v-if="pedido.length>0">{{pedido.length}}</span>
              </a>
            <ul class="dropdown-menu extended inbox" v-if="pedido.length>0">
              <div class="notify-arrow notify-arrow-green"></div>
              <li>
                <p class="green">Tiene {{pedido.length}} pedidos nuevos</p>
              </li>
              <li v-for="su in pedido" >
                
                <a href="pedidos" @click="estado(su.id)">
                  <span class="photo">
                    <img alt="avatar" :src="`${su.foto}`">
                  </span>
                  <span class="subject">
                  <span class="from">{{su.cli_nombres}} {{su.cli_apellidos}}</span>
                  <span class="time">{{su.fecha_compra | myDate4}}</span>
                  </span>
                  <span class="message">
                  Cantidad de Productos {{su.cantidadproductos}}
                  </span>
                  </a>
                  
              </li>
              
            </ul>
          </li>

        </ul>
        <!--  notification end -->
      </div>
 
</template>

<script>
     export default {
        data(){
            return{
                sugerencia:{},
                depositos:{},
                oferta:{},
                productos:{},
                pedido:{},

                asignar:{},
                iduser:'',
                usuarios:{},
                rol:'',
            }
        },

        created() {

            this.LoadNoti();
            Fire.$on('AfterCreate', () => {
                this.LoadNoti();
            });
        },

        methods: {

            LoadNoti(){
              axios.get('home').then(res => {
                        this.sugerencia = res.data.sugerencia;
                        this.depositos=res.data.depositos;
                        this.oferta=res.data.oferta;
                        this.productos=res.data.productos;
                        this.pedido=res.data.pedido;

                        this.asignar=res.data.asignar;
                        this.iduser=res.data.iduser;
                        this.usuarios=res.data.usuarios;
                        this.rol=res.data.rol;
                    });
            },

            estado(id){
              
              axios.put(`/notificaciones/${id}`)
              .then(res=>{

              }).catch((error)=>this.errors = error.response.data.errors);
            }

         


        }
    }
</script>
