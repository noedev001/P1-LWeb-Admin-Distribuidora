<template>
    <section class="wrapper">
        <h3><i class="fa fa-angle-right"></i> Lista de Ventas</h3>

        <!-- row -->
        <div class="row mt">
            <div class="col-md-12">
                <div class="content-panel">
                    <h4><i class="fa fa-angle-right"></i> Ventas</h4>
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
                    <table
                        class="table table-striped table-advance table-hover"
                    >
                        <thead>
                            <tr>
                                <th></th>
                                <th class="centered">
                                    <i class="fa fa-users"></i> Nombres
                                </th>
                                <th class="centered">
                                    <i class="fa fa-inbox"></i> Email
                                </th>
                                <th class="centered">
                                    <i class="fa fa-question-circle"></i>
                                    Cantidad de Productos
                                </th>
                                <th><i class="fa fa-money"></i> Monto</th>
                                <th class="centered">
                                    <i class="fa fa-calendar"></i> Fecha
                                </th>
                                <th class="centered">
                                    <i class="fa fa-edit"></i>Detalle
                                </th>
                            </tr>
                        </thead>
                        <tbody v-if="rol == 'SuperAdmin' || rol == 'Admin'">
                            <tr v-for="de in clientesPago.data">
                                <td></td>
                                <td>
                                    {{ de.cli_nombres }}&nbsp{{
                                        de.cli_apellidos
                                    }}
                                </td>
                                <td class="centered">{{ de.cli_usuario }}</td>
                                <td
                                    class="centered"
                                    v-for="pre in preciototal"
                                    v-if="pre.fecha_entrega == de.fecha_entrega"
                                >
                                    {{ pre.CantidadProductos }}
                                </td>
                                <td
                                    class="hidden-phone"
                                    v-for="pre in preciototal"
                                    v-if="pre.fecha_entrega == de.fecha_entrega"
                                >
                                    {{ pre.PrecioTotal }} .Bs
                                </td>
                                <td>
                                    <span>{{ de.fecha_entrega | myDate }}</span>
                                </td>
                                <td class="centered">
                                    <button
                                        class="btn btn-success btn-xs"
                                        data-toggle="modal"
                                        data-target="#myModalFac"
                                        @click="
                                            showfactura(de.id, de.fecha_entrega)
                                        "
                                    >
                                        <i class="fa fa-check"> Ver</i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>

                        <tbody v-if="rol == 'Dist'">
                            <tr
                                v-for="de in clientesPago.data"
                                v-if="de.user_id == iduser"
                            >
                                <td></td>
                                <td>
                                    {{ de.cli_nombres }}&nbsp{{
                                        de.cli_apellidos
                                    }}
                                </td>
                                <td class="centered">{{ de.cli_usuario }}</td>
                                <td
                                    class="centered"
                                    v-for="pre in preciototal"
                                    v-if="pre.fecha_entrega == de.fecha_entrega"
                                >
                                    {{ pre.CantidadProductos }}
                                </td>
                                <td
                                    class="hidden-phone"
                                    v-for="pre in preciototal"
                                    v-if="pre.fecha_entrega == de.fecha_entrega"
                                >
                                    {{ pre.PrecioTotal }} .Bs
                                </td>
                                <td>
                                    <span>{{ de.fecha_entrega | myDate }}</span>
                                </td>
                                <td class="centered">
                                    <button
                                        class="btn btn-success btn-xs"
                                        data-toggle="modal"
                                        data-target="#myModalFac"
                                        @click="
                                            showfactura(de.id, de.fecha_entrega)
                                        "
                                    >
                                        <i class="fa fa-check"> Ver</i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="card-footer">
                        <pagination
                            :data="clientesPago"
                            @pagination-change-page="getResults"
                            class="dataTables_paginate paging_bootstrap pagination"
                        ></pagination>
                    </div>
                </div>
                <!-- /content-panel -->
            </div>
            <!-- /col-md-12 -->
        </div>
        <!-- /row -->

        <!-- factura Modal-->
        <div
            class="modal fade"
            id="myModalFac"
            tabindex="-1"
            role="dialog"
            aria-labelledby="myModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="invoice-body">
                        <div class="pull-left">
                            <h1>E&E</h1>
                            <address>
                                <strong>Distribuidora.</strong><br />
                                Sucre, Bolivia<br />
                                <abbr title="Phone">Cel:</abbr> (+529) 75450473
                            </address>
                        </div>
                        <!-- /pull-left -->
                        <div class="pull-right">
                            <h2>Factura</h2>
                            <div
                                class="centered"
                                v-for="fa in facturasMostrar"
                                v-if="
                                    fa.cliente_id == fac.cli_id &&
                                        fa.fecha == fac.fecha
                                "
                            >
                                <a
                                    :href="`facturas/${fa.facturapdf}`"
                                    target="_black"
                                    class="btn btn-success btn-xs"
                                >
                                    <i class="fa fa-file-text-o"></i
                                ></a>
                            </div>
                        </div>
                        <!-- /pull-right -->
                        <div class="clearfix"></div>
                        <br />
                        <div class="row">
                            <div
                                class="col-md-9"
                                v-for="cli in clientes"
                                v-if="cli.id == fac.cli_id"
                            >
                                <h4>
                                    {{ cli.cli_nombres }}&nbsp{{
                                        cli.cli_apellidos
                                    }}
                                </h4>
                                <address>
                                    <strong>{{ cli.cli_usuario }}</strong
                                    ><br />
                                    Ci/Nit: {{ cli.ci }}<br />
                                    <abbr title="Phone">P:</abbr> (+529)
                                    {{ cli.cli_celular }}
                                </address>
                            </div>
                            <!-- /col-md-9 -->
                            <div class="col-md-3">
                                <br />
                                <div>
                                    <div class="pull-left">Factura :</div>
                                    <div
                                        class="pull-right"
                                        v-for="fa in facturasMostrar"
                                        v-if="
                                            fa.cliente_id == fac.cli_id &&
                                                fa.fecha == fac.fecha
                                        "
                                    >
                                        {{ fa.factura }}
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div>
                                    <!-- /col-md-3 -->
                                    <div class="pull-left">Fecha :</div>
                                    <div class="pull-right">
                                        {{ fac.fecha | myDate1 }}
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <!-- /row -->
                                <br />
                                <div class="well well-small green">
                                    <div class="pull-left">Total :</div>
                                    <div
                                        class="pull-right"
                                        v-for="pre in preciototal"
                                        v-if="
                                            pre.cliente_id == fac.cli_id &&
                                                pre.fecha_entrega == fac.fecha
                                        "
                                    >
                                        {{ pre.PrecioTotal }} Bs
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <!-- /invoice-body -->
                        </div>
                        <!-- /col-lg-10 -->
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-left">DESCRIPCION</th>

                                    <th style="width: 80px" class="text-right">
                                        CANT.
                                    </th>
                                    <th style="width: 100px" class="text-right">
                                        P. UNIT
                                    </th>
                                    <th style="width: 100px" class="text-right">
                                        TOTAL
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(de, index) in detallePedido"
                                    v-if="
                                        fac.cli_id == de.cliente_id &&
                                            fac.fecha == de.fecha_entrega
                                    "
                                >
                                    <td
                                        v-for="pro in productos"
                                        v-if="
                                            pro.id ==
                                                de.inventarios[0].producto_id
                                        "
                                    >
                                        {{ pro.nombre }}-{{ pro.marca }}
                                    </td>

                                    <td
                                        class="text-right"
                                        v-if="de.cantidad_caja > 0"
                                    >
                                        {{
                                            de.cantidad_caja *
                                                de.inventarios[0]
                                                    .cantidad_unidad_caja
                                        }}
                                    </td>
                                    <td class="text-right" v-else>
                                        {{ de.cantidad_unidad }}
                                    </td>
                                    <td class="text-right">
                                        {{ de.precio_unidad }}
                                    </td>
                                    <td class="text-right">
                                        {{ de.precio_total }}
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2" rowspan="4">
                                        <h4>Términos y Condiciones</h4>
                                        <p>
                                            Gracias por hacer negocios con
                                            nosostros. Habrá un cargo de interés
                                            del 13%.
                                        </p>
                                    </td>

                                    <td class="text-right">
                                        <strong>Subtotal</strong>
                                    </td>
                                    <td
                                        class="text-right"
                                        v-for="pre in preciototal"
                                        v-if="
                                            pre.cliente_id == fac.cli_id &&
                                                pre.fecha_entrega == fac.fecha
                                        "
                                    >
                                        {{ pre.PrecioTotal }} Bs
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-right no-border">
                                        <div class="well well-small green">
                                            <strong>Total</strong>
                                        </div>
                                    </td>
                                    <td
                                        class="text-right"
                                        v-for="pre in preciototal"
                                        v-if="
                                            pre.cliente_id == fac.cli_id &&
                                                pre.fecha_entrega == fac.fecha
                                        "
                                    >
                                        <strong
                                            >{{ pre.PrecioTotal }} Bs</strong
                                        >
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
            clientesPago: {},
            preciototal: {},
            facturasMostrar: {},
            detallePedido: {},
            productos: {},
            clientes: {},

            fac: {
                cli_id: "",
                fecha: ""
            },
            search: "",

            asignar: {},
            iduser: "",
            usuarios: {},
            rol: ""
        };
    },

    created() {
        Fire.$on("searching", () => {
            let query = this.search;
            axios
                .get("busquedaVentas?q=" + query)
                .then(data => {
                    this.clientesPago = data.data;
                })
                .catch(() => {});
        });
        this.LoadCuenta();
        Fire.$on("AfterCreate", () => {
            this.LoadCuenta();
        });
    },

    methods: {
        getResults(page = 1) {
            axios.get("ventas?page=" + page).then(response => {
                this.clientesPago = response.data.clientesPago;
            });
        },

        //busqueda
        searchit: _.debounce(() => {
            Fire.$emit("searching");
        }, 1000),

        LoadCuenta() {
            axios.get("ventas").then(res => {
                this.clientesPago = res.data.clientesPago;
                this.preciototal = res.data.precioTotal;
                this.facturasMostrar = res.data.facturas;
                this.detallePedido = res.data.detallepedido;
                this.productos = res.data.productos;
                this.clientes = res.data.clientes;

                this.asignar = res.data.asignar;
                this.iduser = res.data.iduser;
                this.usuarios = res.data.usuarios;
                this.rol = res.data.rol;

                this.loading = false;
            });
        },

        showfactura(id, fe) {
            this.fac.cli_id = id;
            this.fac.fecha = fe;
        },

        pdffactura() {
            const params = {
                id: this.fac.cli_id,
                fecha: this.fac.fecha
            };

            let timerInterval;
            swal.fire({
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
                }
            }).then(result => {
                /* Read more about handling dismissals below */
                if (result.dismiss == swal.DismissReason.timer) {
                    axios
                        .post("pdf", params)
                        .then(() => {})
                        .catch(() => {
                            swal("¡Ha fallado!", "Había algo malo.", "warning");
                        });
                }
            });
        }
    }
};
</script>
