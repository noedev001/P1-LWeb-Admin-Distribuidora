<template>
    <div class="container">
        <div class="shopping-cart">
            <div class="box">
                <i class="fas fa-trash"></i>
                <img src="image/cart-img-1.png" alt="" />
                <div class="content">
                    <h3>watermelon</h3>
                    <span class="price">$4.99/-</span>
                    <span class="quantity">qty : 1</span>
                </div>
            </div>
            <div v-for="iden in identificador">
                <div v-for="pre in preuni" v-if="pre.cliente_id == iden.id">
                    <div class="totalcantidad">
                        Cantidad de productos : {{ pre.CantidadProductos }}
                    </div>
                    <div class="total">total : Bs {{ pre.PrecioTotal }}</div>
                </div>
            </div>
            <a href="#" class="btn">checkout</a>
        </div>

        <form @submit.prevent="entrar()" class="login-form">
            <h3>Iniciar Sesion</h3>
            <input
                type="email"
                placeholder="Ingresa tu email"
                class="box"
                v-model="cliente.email"
            />
            <input
                type="password"
                placeholder="Ingrese tu password"
                class="box"
                v-model="cliente.password"
            />

            <input type="submit" value="Iniciar Sesion" class="btn" />
        </form>

        <form @submit.prevent="crearCuenta()" class="create-form">
            <h3>Crear Cuenta</h3>
            <input
                type="text"
                placeholder="Ingrese su Nombre"
                class="box"
                v-model="cliente.nombre"
            />
            <input
                type="text"
                placeholder="Ingrese su Apelldio"
                class="box"
                v-model="cliente.apellido"
            />
            <input
                type="text"
                placeholder="Ingrese su Ci"
                class="box"
                v-model="cliente.ci"
            />
            <input
                type="text"
                placeholder="Ingrese su Direccion"
                class="box"
                v-model="cliente.direccion"
            />
            <input
                type="text"
                placeholder="Ingrese su Numero de Celular"
                class="box"
                v-model="cliente.celular"
            />
            <input
                type="email"
                placeholder="Ingresa tu email"
                class="box"
                v-model="cliente.email"
            />
            <input
                type="password"
                placeholder="Ingreasa tu password"
                class="box"
                v-model="cliente.password"
            />

            <input type="submit" value="Crear Cuenta" class="btn" />
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            login: true,
            create: false,
            cliente: {
                nombre: "",
                apellido: "",
                celular: "",
                email: "",
                password: "",
                ci: "",
                direccion: "",
                celular: ""
            },
            ingresar: {},
            identificador: {},
            comprobar: {},
            preuni: {},
            pedidoHecho: {}
        };
    },

    created() {
        this.load();
        Fire.$on("AfterCreate", () => {
            this.load();
        });
    },
    methods: {
        load() {
            axios.get("pagecliente").then(res => {
                this.identificador = res.data.identificador;
                this.comprobar = res.data.comprobar;
                this.preuni = res.data.preuni;
                this.pedidoHecho = res.data.pedidoHecho;
            });
        },

        crearCuenta() {
            let formData = new FormData();
            formData.append("nombre", this.cliente.nombre);
            formData.append("apellido", this.cliente.apellido);
            formData.append("ci", this.cliente.ci);
            formData.append("direccion", this.cliente.direccion);
            formData.append("celular", this.cliente.celular);
            formData.append("email", this.cliente.email);
            formData.append("password", this.cliente.password);

            axios
                .post("pagecliente", formData, {
                    headers: {
                        "Content-Type": "multipart/form-data"
                    }
                })
                .then(res => {
                    Fire.$emit("AfterCreate");

                    toast.fire({
                        type: "success",
                        title: "Producto Agregado Correctamente..!!!"
                    });

                    this.cliente.nombre = "";
                    this.cliente.apellido = "";
                    this.cliente.ci = "";
                    this.cliente.direccion = "";
                    this.cliente.celular = "";
                    this.cliente.email = "";
                    this.cliente.password = "";
                })
                .catch(error => console.log(error));
        },
        entrar() {
            let formData = new FormData();
            formData.append("email", this.cliente.email);
            formData.append("password", this.cliente.password);

            axios
                .post("entrarlogin", formData, {
                    headers: {
                        "Content-Type": "multipart/form-data"
                    }
                })
                .then(res => {
                    this.ingresar = res.data;

                    if (this.ingresar.comprobar == true) {
                        Fire.$emit("AfterCreate");

                        toast1.fire({
                            type: "success",
                            title: "Bien venido..!!!"
                        });
                        this.cliente.email = "";
                        this.cliente.password = "";

                        document
                            .querySelector(".login-form")
                            .classList.remove("active");
                    } else {
                        if (this.ingresar.comprobar == false) {
                            toast2.fire({
                                type: "error",
                                title:
                                    "Algo salio mal comprueba tu email o password"
                            });
                        }
                    }
                })
                .catch(error => console.log(error));
        }
    }
};
</script>
