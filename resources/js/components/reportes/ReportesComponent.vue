<template>
    <section class="wrapper">

        <h3><i class="fa fa-angle-right"></i> Ventas De Mercaderia</h3>
     
        <!-- row -->
        <div class="row mt">
          <div class="col-md-12">
            <div class="content-panel">
                <h4><i class="fa fa-angle-right"></i> Ventas del mes de {{mes | myDate5}}</h4>
                <div class="pull-right position" style="margin-bottom: 10px;">
                  <input type="search" placeholder="Buscar" @keyup="searchit" v-model="search" class="form-control search-btn "/>
                </div>
                <hr>

              <div  class="col-md-12" style="margin-bottom: 10px;">
                <div class="col-md-9">

                     <div class="form-group col-md-2" >
                        <label>Reporte</label>
                        <select name="departamento" class="form-control" v-model="reporte.consulta">
                          <option value="" selected>Seleccione</option>
                          <option value="1">Mes</option>
                          <option value="2">Rango</option>

                        </select>
                    </div>
                    

        <!-------------------- Opcion 2 ------------------------>

                  <div class="form-group col-md-3" v-if="reporte.consulta==1">
                        <label>Tipo</label>
                        <select name="departamento" class="form-control" v-model="reporte.mesconsulta">
                          <option value="" selected>Seleccione mes</option>
                          <option value="01">Enero</option>
                          <option value="02">Febrero</option>
                          <option value="03">Marzo</option>
                          <option value="04">Abril</option>
                          <option value="05">Mayo</option>
                          <option value="06">Junio</option>
                          <option value="07">Julio</option>
                          <option value="08">Agosto</option>
                          <option value="09">Septiembre</option>
                          <option value="10">Octubre</option>
                          <option value="11">Noviembre</option>
                          <option value="12">Diciembre</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3" v-if="reporte.consulta==2">
                      <label>De</label>
                      <input type="date" class="form-control  " v-model="reporte.fechainicio"   min="2018-01-01" max="2050-1-1"  >         
                    </div>
                    <div class="form-group col-md-3" v-if="reporte.consulta==2">
                      <label>A</label>                        
                      <input type="date" class="form-control  " v-model="reporte.fechafinal"   min="2018-01-01" max="2050-1-1" >
                    </div>

                </div>
                <div class="  col-md-3 " >
                  <button class="btn btn-theme btn" @click="consulta()" v-if="reporte.consulta!=''" style="margin-top: 20px;"><i class="fa fa-file-text-o"></i> Ver</button>
                  

                  <button class="btn btn-success btn pull-right position" @click="pdfReporte()" style="margin-top: 20px;"><i class="fa fa-file-text-o"></i> PDF</button>
                </div>
              </div>


              <table class="table table-striped table-advance table-hover">
                
                <thead>
                  <tr class="green">
                    <th></th>
                    <th class="centered"><i class="fa fa-caret-square-o-right"></i> Nombre de Productos</th>
                    <th class="centered"><i class="fa fa-angle-down"></i> Marca</th>
                    <th class="centered"><i class="fa fa-angle-down"></i> Modelo</th>
                    <th class="centered"><i class=" fa fa-angle-down"></i> Medida</th>
                    <th class="centered"><i class=" fa fa-dot-circle-o"></i> Unidades</th>
                    <th class="centered"><i class=" fa fa-dot-circle-o"></i> Cajas</th>
                    <th class="centered"><i class=" fa fa-dollar"></i> P. Venta U.</th>
                    <th class="centered"><i class=" fa fa-edit"></i> Detalle</th>
                    <th class="centered"><i class=" fa fa-edit"></i> Fecha</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody class="centered">
                  <tr v-for="ve in ventas">
                    <td></td>
                    <td >{{ve.nombre}}</td>
                    <td >{{ve.marca}}</td>
                    <td >{{ve.modelo}}</td>
                    <td >{{ve.medida}}</td>
                    <td >{{ve.cantidad_unidad}}</td>
                    <td >{{ve.cantidad_caja}}</td>
                    <td >{{ve.precio_venta_unidad}}</td>
                    <td >{{ve.detalle}}</td>
                    <td >{{ve.created_at | myDate1}}</td>
                    <td></td>
                  </tr>
                </tbody>
              </table>

 
            </div>
            <!-- /content-panel -->
          </div>
          <!-- /col-md-12 -->
        </div>
        <!-- /row -->

      </section> 

</template>

<script>
    export default {
        data(){
            return{
                ventas:{},
                search:'',
                mes:'',
                reporte:{

                  consulta:'',
                  mesconsulta:'',
                  fechainicio:'',
                  fechafinal:'',
                },


     
            }
        },

        created() {
             Fire.$on('searching',() => {
                        let query = this.search;
                        axios.get('busquedareportes?q='+query)
                        .then((data) => {
                            this.ventas = data.data;
                        })
                        .catch(() => {

                        })
                    });
            this.LoadReportes();
            Fire.$on('AfterCreate', () => {
                this.LoadReportes();
            });
        },

        methods: {



            //busqueda
            searchit: _.debounce(() => {
                Fire.$emit('searching');
            },1000),

            LoadReportes(){
              axios.get('reportes').then(res => {
                        
                        this.ventas = res.data.ventas;
                        this.mes =res.data.fecha;
   
                    });
            },

            consulta(){
                  let formData = new FormData();

      
                  formData.append('consulta', this.reporte.consulta);

                  formData.append('mesconsulta', this.reporte.mesconsulta);
                  formData.append('fechainicio', this.reporte.fechainicio);
                  formData.append('fechafinal', this.reporte.fechafinal);               

                  axios
                      .post('/reportes/', formData, {
                          headers: {
                              'Content-Type': 'multipart/form-data'
                          }
                      })
                      .then((data) => {
                        this.ventas = data.data;
                          toast.fire({
                              type: 'success',
                              title: 'Ver Reporte',
                          });
                      })
                      .catch(() => {});
            },

            pdfReporte() {
              const params = {
                venta: this.ventas,
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
                      .post("pdfReportes", params)
                      .then((data) => {
               
                          window.open(data.data, '_blank');

                      })
                      .catch(() => {
                        swal("¡Ha fallado!", "Había algo malo.", "warning");
                      });
                  }
                });
            },


        }
    }
</script>
