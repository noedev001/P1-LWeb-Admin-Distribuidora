<template>
  <section class="wrapper">
    <h3><i class="fa fa-angle-right"></i> Lista De Creditos Pagados</h3>

    <!-- row -->
    <div class="row mt">
      <div class="col-md-12">
        <div class="content-panel">
          <h4><i class="fa fa-angle-right"></i> Pagos Cancelados del mes de {{mes | myDate5}}</h4>
          <div class="pull-right position">
            <input
              type="search"
              placeholder="Buscar"
              @keyup="searchit"
              v-model="search"
              class="form-control search-btn"
            />
          </div>
          <hr />

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
                  

                 <!-- <button class="btn btn-success btn pull-right position" @click="pdfReporte()" style="margin-top: 20px;"><i class="fa fa-file-text-o"></i> PDF</button>-->
                </div>
              </div>

          <table class="table table-striped table-advance table-hover">
            <thead>
              <tr>
                <th></th>
                <th class="centered"><i class="fa fa-users"></i> Nombres</th>
                <th class="centered">
                  <i class="fa fa-envelope-o"></i> Correo
                </th>
                <th class="centered">
                  <i class="fa fa-calendar"></i> Fecha De Pedido
                </th>
                <th class="centered"><i class="fa fa-edit"></i> Detalle</th>
                <th></th>
              </tr>
            </thead>
            <tbody v-if="rol=='SuperAdmin' || rol=='Admin'">
              <tr v-for="cli in clientes">
                <td></td>
                <td>{{ cli.cli_nombres }}&nbsp{{ cli.cli_apellidos }}</td>
                <td class="centered">{{ cli.cli_usuario }}</td>
                <td class="centered">
                  <span>{{ cli.fecha_entrega | myDate }}</span>
                </td>
                <td class="centered">
                  <button
                    class="btn btn-theme btn-xs"
                    data-toggle="modal"
                    data-target="#myModalPedido"
                    @click="showListPedido(cli.id, cli.fecha_entrega)"
                  >
                    <i class="fa fa-copy"> Pedido</i>
                  </button>
                  <button
                    class="btn btn-info btn-xs"
                    data-toggle="modal"
                    data-target="#myModalPagos"
                    @click="showListPagos(cli.id, cli.fecha_entrega)"
                  >
                    <i class="fa fa-credit-card"> Pagos</i>
                  </button>
                </td>
                <td></td>
              </tr>
            </tbody>

            <tbody v-if="rol=='Dist'">
              <tr v-for="cli in clientes" v-if="cli.user_id==iduser">
                <td></td>
                <td>{{ cli.cli_nombres }}&nbsp{{ cli.cli_apellidos }}</td>
                <td class="centered">{{ cli.cli_usuario }}</td>
                <td class="centered">
                  <span>{{ cli.fecha_entrega | myDate }}</span>
                </td>
                <td class="centered">
                  <button
                    class="btn btn-theme btn-xs"
                    data-toggle="modal"
                    data-target="#myModalPedido"
                    @click="showListPedido(cli.id, cli.fecha_entrega)"
                  >
                    <i class="fa fa-copy"> Pedido</i>
                  </button>
                  <button
                    class="btn btn-info btn-xs"
                    data-toggle="modal"
                    data-target="#myModalPagos"
                    @click="showListPagos(cli.id, cli.fecha_entrega)"
                  >
                    <i class="fa fa-credit-card"> Pagos</i>
                  </button>
                </td>
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

    <!-- Pedidos Modal-->
    <div
      class="modal fade"
      id="myModalPedido"
      tabindex="-1"
      role="dialog"
      aria-labelledby="myModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-hidden="true"
            >
              &times;
            </button>
            <h4 class="modal-title" id="myModalLabel">
              <i class="fa fa-stack-overflow"></i>&nbsp Pedidos Realizado
            </h4>
          </div>

          <div class="modal-body">

            <div class="pull-left">
              <address>
                <strong>Pedidos Realizado</strong><br />
                <abbr title="Phone">Fecha: </abbr> {{pedidopagos.fecha | myDate1 }}
                Sucre, Bolivia<br />
                
              </address>
            </div>

            <table class="table">
              <thead>
                <tr class="green">
                  <th class="text-left">DESCRIPCION</th>
                  <th style="width: 80px" class="text-right">CANT.</th>
                  <th style="width: 100px" class="text-right">P. UNIT</th>
                  <th style="width: 100px" class="text-right">TOTAL</th>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="(de, index) in detallepedido"
                  v-if="
                    pedidopagos.cliente_id == de.cliente_id &&
                    pedidopagos.fecha == de.fecha_entrega
                  "
                >
                  <td
                    v-for="pro in productos"
                    v-if="pro.id == de.inventarios[0].producto_id"
                  >
                    {{ pro.nombre }}-{{ pro.marca }}
                  </td>

                  <td class="text-right" v-if="de.cantidad_caja > 0">
                    {{
                      de.cantidad_caja * de.inventarios[0].cantidad_unidad_caja
                    }}
                  </td>
                  <td class="text-right" v-else>{{ de.cantidad_unidad }}</td>
                  <td class="text-right">{{ de.precio_unidad }}</td>
                  <td class="text-right">{{ de.precio_total }}</td>
                </tr>

                <tr>
                  <td colspan="2" rowspan="4"></td>

                  <td class="text-right"><strong>Total </strong></td>
                  <td
                    class="text-right"
                    v-for="pre in preciototal"
                    v-if="
                      pre.cliente_id == pedidopagos.cliente_id &&
                      pre.fecha_entrega == pedidopagos.fecha
                    "
                  >
                    {{ pre.PrecioTotal }} Bs
                  </td>
                </tr>
              </tbody>
            </table>

            <div class="modal-footer">
              <button class="btn btn-danger btn-sm" data-dismiss="modal">
                Cerrar
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Pagos Modal-->
    <div
      class="modal fade"
      id="myModalPagos"
      tabindex="-1"
      role="dialog"
      aria-labelledby="myModalLabel"
      aria-hidden="true"
    >
       <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-hidden="true"
            >
              &times;
            </button>
            <h4 class="modal-title" id="myModalLabel">
              <i class="fa fa-stack-overflow"></i>&nbsp Pagos Realizado
            </h4>
          </div>

          <div class="modal-body">

            <div class="pull-left">
              <address>
                <strong>Pagos Hechos</strong><br />
               
                Sucre, Bolivia<br />
                <strong>Monto Total: <label v-for="pre in preciototal"
                    v-if="
                      pre.cliente_id == pedidopagos.cliente_id &&
                      pre.fecha_entrega == pedidopagos.fecha
                    ">  {{ pre.PrecioTotal }} bs.</label></strong>
              </address>
            </div>

            <table class="table">
              <thead>
                <tr class="green">
                  <th class="centered">Forma de Pago</th>
                  <th  class="centered">Monto</th>
                  <th  class="centered">Deposito</th>
                  <th  class="centered">Fecha</th>
                </tr>
              </thead>
              <tbody class="centered">
                <tr class="unread" v-for="pa in pagos" v-if="pedidopagos.cliente_id==pa.cliente_id && pedidopagos.fecha==pa.fecha_entrega">
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
                                      <td >{{pa.fecha_pago | myDate1 }}</td>

                                  </tr>

              </tbody>
            </table>

            <div class="modal-footer">
              <button class="btn btn-danger btn-sm" data-dismiss="modal">
                Cerrar
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  data() {
    return {
      clientes: {},
      detallepedido: {},
      productos: {},
      preciototal: {},
      pagos:{},
      pedidopagos: {
        fecha: "",
        cliente_id: "",
      },

      search: "",

      asignar:{},
      iduser:'',
      usuarios:{},
      rol:'',

       mes:'',
      reporte:{

      consulta:'',
      mesconsulta:'',
      fechainicio:'',
      fechafinal:'',
      },
    };
  },

  created() {
    Fire.$on("searching", () => {
      let query = this.search;
      axios
        .get("busquedalistaPagos?q=" + query)
        .then((data) => {
          this.clientes = data.data;
        })
        .catch(() => {});
    });
    this.LoadPagos();
    Fire.$on("AfterCreate", () => {
      this.LoadPagos();
    });
  },

  methods: {


    //busqueda
    searchit: _.debounce(() => {
      Fire.$emit("searching");
    }, 1000),

    LoadPagos() {
      axios.get("pagos").then((res) => {
        this.clientes = res.data.clientes;
        this.detallepedido = res.data.detallepedido;
        this.productos = res.data.productos;
        this.preciototal = res.data.preciototal;
        this.pagos = res.data.pagos;

        this.asignar=res.data.asignar;
        this.iduser=res.data.iduser;
        this.usuarios=res.data.usuarios;
        this.rol=res.data.rol;

         this.mes =res.data.fecha;
      });
    },

    showListPedido(id, fe) {
      this.pedidopagos.cliente_id = id;
      this.pedidopagos.fecha = fe;
    },

    showListPagos(id, fe) {
      this.pedidopagos.cliente_id = id;
      this.pedidopagos.fecha = fe;
    },

    consulta(){
      let formData = new FormData();

      
      formData.append('consulta', this.reporte.consulta);

      formData.append('mesconsulta', this.reporte.mesconsulta);
      formData.append('fechainicio', this.reporte.fechainicio);
                  formData.append('fechafinal', this.reporte.fechafinal);               

                  axios
                      .post('/pagos/', formData, {
                          headers: {
                              'Content-Type': 'multipart/form-data'
                          }
                      })
                      .then((data) => {
                        this.clientes = data.data;
                          toast.fire({
                              type: 'success',
                              title: 'Ver Reporte',
                          });
                      })
                      .catch(() => {});
            },
  },
};
</script>
