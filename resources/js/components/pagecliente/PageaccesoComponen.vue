<template>
    <div class="icons">
        <div class="fas fa-bars" id="menu-btn"></div>
        <div
            class="fas fa-shopping-cart"
            id="cart-btn"
            v-show="comprobar == true"
        ></div>
        <div
            class="fas fa-user"
            id="login-btn"
            v-show="comprobar == false || comprobar == null"
        ></div>
        <div
            class="fas fa-users"
            id="create-btn"
            v-show="comprobar == false || comprobar == null"
        ></div>
        <div
            class="fas fa-sign-out-alt"
            @click="salir()"
            v-show="comprobar == true"
        ></div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            login: true,
            create: false,
            identificador: {},
            comprobar: {}
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
            });
        },
        salir() {
            swal.fire({
                title: "¿Estás seguro",
                text: "de Salir?",
                type: "advertencia",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sí, Salir!"
            }).then(result => {
                // Send request to the server
                if (result.value) {
                    axios
                        .get("salircuenta")
                        .then(() => {
                            Fire.$emit("AfterCreate");
                        })
                        .catch(() => {
                            swal("¡Ha fallado!", "Había algo malo.", "warning");
                        });
                }
            });
        }
    }
};
</script>
