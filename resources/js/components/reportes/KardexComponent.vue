<template>
    <section class="wrapper">

        <h3><i class="fa fa-angle-right"></i> Kardex General</h3>
     
        <!-- row -->
        <div class="row mt">
          <div class="col-md-12">
            <div class="content-panel">
                <h4><i class="fa fa-angle-right"></i> Kardex  {{mes | myDate5}}</h4>
                <div class="pull-right position" style="margin-bottom: 10px;">
                 <!-- <input type="search" placeholder="Buscar" @keyup="searchit" v-model="search" class="form-control search-btn "/>-->
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


              <table class="table table-striped table-advance table-hover" v-for="inv in inventariocantidad" >
                <thead ><tr > <th class="centered" colspan="13" ><label > Productos {{inv.nombre}} - {{inv.marca}} - {{inv.modelo}}</label></th></tr></thead>
                <thead>
                  <tr class="green">
                    <th></th>
                    <th class="centered"><i class="fa fa-caret-square-o-right"></i> Detalle</th>
                    <th class="centered"><i class=" fa fa-calendar"></i> Fecha</th>
                    <th class="centered"><i class=" fa fa-dot-circle-o"></i> Ingresos</th>
                    <th class="centered"><i class=" fa fa-money"></i> Monto Ing.</th>
                    <th class="centered"><i class=" fa fa-money"></i> Monto Ing. Tol</th>
                    <th class="centered"><i class=" fa fa-dollar"></i> Salidas</th>
                    <th class="centered"><i class=" fa fa-money"></i> Monto Sal.</th>
                    <th class="centered"><i class=" fa fa-money"></i> Monto Sal. Tol</th>
                    <th class="centered"><i class=" fa fa-edit"></i> Precio Vent.</th>
                    <th class="centered"><i class=" fa fa-edit"></i> Saldo Cant.</th>
                    <th class="centered"><i class=" fa fa-money"></i> Monto Sal</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody class="centered">
                  <tr v-if=""></tr>
                  <tr v-for="ve in kardex" v-if="ve.inventario_id==inv.id">
                    <td></td>
                    <td ><label v-if="ve.detalle_salida==null">Entrada de Merdaceria</label><label v-else>Salida {{ve.detalle_salida}}</label></td>
                    <td >{{ve.created_at| myDate1}}</td>
                    <td > <label v-if="ve.cantidad_unidad_entrada==null">-</label><label v-else>{{ve.cantidad_unidad_entrada}} Uni.</label></td>
                    <td ><label v-if="ve.precio_venta_unidad_entrada==null">-</label><label v-else>{{ve.precio_venta_unidad_entrada}} Bs.</label></td>
                    <td ><label v-if="ve.precio_venta_unidad_entrada==null">-</label><label v-else>{{ve.precio_venta_unidad_entrada*ve.cantidad_unidad_entrada}} Bs.</label></td>
                    <td ><label v-if="ve.cantidad_unidad_salida==null">-</label><label v-else>{{ve.cantidad_unidad_salida}} Uni.</label></td>
                    <td ><label v-if="ve.precio_venta_unidad_salida==null">-</label><label v-else>{{ve.precio_venta_unidad_salida}} Bs.</label></td>
                    <td ><label v-if="ve.precio_venta_unidad_salida==null">-</label><label v-else>{{ve.precio_venta_unidad_salida * ve.cantidad_unidad_salida}} Bs.</label></td>
                    <td >{{ve.precioanterior}} Bs.</td>
                    <td >{{ve.cantidad_total}} Un.</td>
                    <td >{{ve.saldototalventa}} Bs</td>
                    <td></td>
                  </tr>
                  <tr class="gris" ><td colspan="13"></td></tr>
                </tbody>
              </table>
                
                <div v-if="inventariocantidad.length<=0" class="col-md-12 centered">
                  <label class="centered" >No Hay Productos</label>
                </div>   
              <label>.</label>

 
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
                search:'',
                mes:'',
                reporte:{

                  consulta:'',
                  mesconsulta:'',
                  fechainicio:'',
                  fechafinal:'',
                },

                inventariocantidad:{},
                kardex:{},
     
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
              axios.get('kardex').then(res => {
                        
                      this.inventariocantidad=res.data.inventariocantidad;
                      this.kardex=res.data.kardex;
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
                      .post('/kardex/', formData, {
                          headers: {
                              'Content-Type': 'multipart/form-data'
                          }
                      })
                      .then((data) => {
                        this.inventariocantidad = data.data;
                          toast.fire({
                              type: 'success',
                              title: 'Ver Reporte',
                          });
                      })
                      .catch(() => {});
            },

            pdfReporte() {
              const params = {
                inventario: this.inventariocantidad,
                detalle: this.kardex,
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
                      .post("pdfKardex", params)
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
