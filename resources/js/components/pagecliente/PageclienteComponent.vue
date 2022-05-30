<template>
    <div class="container">
        <div class="swiper product-slider">
            <div class="swiper-wrapper">
                <div class="swiper-slide box" v-for="inv in invmas">
                    <div
                        v-for="pro in productos"
                        v-if="pro.id == inv.producto_id"
                    >
                        <img :src="`images/product/${pro.avatar}`" alt="" />

                        <h3>{{ pro.nombre }}</h3>

                        <div class="price">
                            bs
                            {{ inv.precio_venta_unidad }}
                        </div>
                        <div class="stars">
                            <p>
                                {{ pro.descripcion }}
                            </p>
                            <h4>{{ pro.nota }}</h4>
                        </div>

                        <!-- <a
                            href="#"
                            class="btn"
                            v-show="comprobar == true"
                            @click="agregar(inv, pro)"
                            >Agregar al Carrito</a
                        >
 -->
                    </div>

                    <a
                        href="#"
                        class="btn"
                        v-show="comprobar == false || comprobar == null"
                        @click="mensaje()"
                        >Agregar al Carrito</a
                    >
                </div>
            </div>
        </div>

        <div class="swiper mySwyper product-slider">
            <div class="swiper-wrapper">
                <div class="swiper-slide box" v-for="inv in invmen">
                    <div
                        v-for="pro in productos"
                        v-if="pro.id == inv.producto_id"
                    >
                        <img :src="`images/product/${pro.avatar}`" alt="" />

                        <h3>{{ pro.nombre }}</h3>

                        <div class="price">
                            bs {{ inv.precio_venta_unidad }}
                        </div>
                        <div class="stars">
                            <p>
                                {{ pro.descripcion }}
                            </p>
                            <h4>{{ pro.nota }}</h4>
                        </div>
                        <select
                            name="seleccionar"
                            id=""
                            v-if="pro.nota == 'Venta por Caja o Unidad'"
                        >
                            <option value="1"
                                >Venta unicamente por Unidad</option
                            >
                            <option value="2">Venta unicamente por Caja</option>
                        </select>

                        <a
                            href="#"
                            class="btn"
                            v-show="comprobar == true"
                            @click="agregar(inv.pro)"
                            >Agregar al Carrito</a
                        >
                    </div>
                    <a
                        href="#"
                        class="btn"
                        v-show="comprobar == false || comprobar == null"
                        @click="mensaje()"
                        >Agregar al Carrito</a
                    >
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
            productos: {},
            categorias: {},

            invmas: {},
            invmen: {},

            can: {},
            identificador: {},
            comprobar: "",

            carrito: {
                cantidad_unidad: "",
                catidad_caja: "",
                precio_unidad: "",
                precio_total: "",
                cliente_id: ""
            },
            idcliente: ""
        };
    },

    created() {
        this.CargarDatos();
        Fire.$on("AfterCreate", () => {
            this.CargarDatos();
        });
    },
    methods: {
        CargarDatos() {
            axios.get("pagecliente").then(res => {
                this.inventarios = res.data.inventarios;
                this.categorias = res.data.categorias;
                this.productos = res.data.productos;
                this.invmas = res.data.invmas;
                this.invmen = res.data.invmen;
                this.can = res.data.can;

                this.identificador = res.data.identificador;
                this.idcliente = res.data.identificador[0].id;
                this.comprobar = res.data.comprobar;
            });
        },

        mensaje() {
            toast1.fire({
                type: "warning",
                title: "Necesita ingresar con su cuenta"
            });
        },

        agregar(inv, pro) {
            let formData = new FormData();

            if (pro.nota == "Venta unicamente por Unidad") {
                formData.append("cantidad_unidad", res.value);
            } else {
                formData.append("cantidad_unidad", 0);
            }

            if (pro.nota == "Venta unicamente por Caja") {
                formData.append("catidad_caja", res.value);
            } else {
                formData.append("catidad_caja", 0);
            }

            formData.append("cliente_id", this.idcliente);
            formData.append("precio_unidad", this.inv.precio_unidad);
        }
    }
};
</script>
