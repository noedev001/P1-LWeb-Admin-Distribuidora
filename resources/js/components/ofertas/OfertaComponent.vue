<template>

  <div style="margin-top: 50px;">
    <h3><i class="fa fa-angle-right"></i> Ofertas - Descuentos</h3>
    <div class="row mb">

      <div class="chat-room-head col-md-12">

        <div class="pull-right position">
          <input type="search" placeholder="Buscar" @keyup="searchit" v-model="search" class="form-control search-btn " />
        </div>
      </div>

      <div class="row">
        <div class="col-lg-12">
          <div v-for="o in ofertas.data">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
              <div class="custom-box" style="background:  #BDBDBD">
                <!--<a href="#"
                   @click="deleteOferta(o.oferta_id)"
                   class="col-xs-offset-11 pull-right position">  <i class='fa fa-close ' style="color:red;"></i></a>-->

                   
                    <button class="col-xs-offset-10 pull-right position btn btn-default btn-xs"  data-toggle="modal" data-target="#myModalNOtificacion" @click="limpiarNotificacion(o.inventario_id, o.fecha)">
                      <i class="fa fa-bell" style="color:red;"></i> 
                    </button>
                <div class="servicetitle" style="margin-top: 25px;">
                  <h4>{{o.nombre}}</h4>
                  <hr>
                </div>
                <div class="icn-main-container">
                  <img :src="`images/product/${o.avatar}`" alt="" style="max-width: 100px; max-height: 95px; line-height: 10px;" />
                </div>
                <ul class="pricing">
                  <li>{{o.marca}}</li>
                  <li>Unidades por Caja: {{o.cantidad_unidadxcaja}}</li>
                  <li>Precio Venta x Unidad: {{o.precio_venta_nuevo}}</li>
                  <li>Fecha: {{o.fecha | myDate}}</li>
                  <li>{{o.status}}</li>
                </ul>

          <div v-for="a in asignar" v-if="a.user_id==iduser">
            <div v-if="a.rol_asignacion=='SuperAdmin' || a.rol_asignacion=='Admin'">
                <button class="btn btn-theme" data-toggle="modal" data-target="#myModalEditar" @click="cambiarStado(o)">Cambiar Estado</button>
            </div>
          </div>
              </div>
              <!-- end custombox -->
            </div>
            <!-- end col-4 -->
          </div>
        </div>
        <!--  /col-lg-12 -->
      </div>

      <!-- page start-->

      <!-- page end-->
    </div>
    <!-- /row -->


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

          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary" @click="notificacionGeneral()">Enviar</button>
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
        ofertas: {},
        oferta: {
          inventario_id: '',
          unidad_almacen: '',
          caja_almacen: '',
          unidad_disponible: '',
          caja_disponible: '',
          precio_venta_nuevo: ''
        },
        inventarios: {},
        productos: {},
        errors: {},
        nuevo: false,
        mostrar: true,
        update: false,

        search: '',
        loading: true,
        asignar:'',
        iduser:'',

          notificacion:{
          titulo:'',
          id_inventario:'',
          fecha:'',
        },
      }
    },

    created() {
      Fire.$on('searching', () => {
        let query = this.search
        axios
          .get('findUser?q=' + query)
          .then(data => {
            this.ofertas = data.data
          })
          .catch(() => {})
      })
      this.LoadUser()
      Fire.$on('AfterCreate', () => {
        this.LoadUser()
      })
    },

    methods: {
      LoadUser() {
        axios.get('ofertas').then(res => {
          this.ofertas = res.data.ofertas;
          this.productos = res.data.productos;
          this.inventarios = res.data.inventarios;
          this.asignar=res.data.asignar;
          this.iduser=res.data.iduser;
          this.loading = false;
        })
      },

      getResults(page = 1) {
        axios.get('ofertas?page=' + page).then(response => {
          this.ofertas = response.data.ofertas
        })
      },

      //busqueda
      searchit: _.debounce(() => {
        Fire.$emit('searching')
      }, 1000),

     cambiarStado(item) {
        
      
            axios.put(`/ofertas/${item.oferta_id}`, item)
            .then((res) => {


                 swal.fire(
                    'Cambio de Estado!',
                    'La información ha sido actualizada.',
                    'success'
                    )
                    
                     Fire.$emit('AfterCreate');

            }).catch((error)=>this.errors = error.response.data.errors);
     },

               notificacionGeneral(){
            let formData = new FormData();
            formData.append('titulo', this.notificacion.titulo);
            formData.append('id', this.notificacion.id_inventario);
            formData.append('fecha', this.notificacion.fecha);

            axios.post('/notificarClienteOfe/', formData, {
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
                      })
                      .catch(() => {});
          },

          limpiarNotificacion(item,fe){
            this.notificacion.id_inventario=item;
            this.notificacion.fecha=fe;
            this.notificacion.titulo='';
          },
    }
  }

</script>
