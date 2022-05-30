<template>
    <section class="wrapper">

        <h3><i class="fa fa-angle-right"></i> Lista de Bitacora todos los Usuarios</h3>
     
        <!-- row -->
        <div class="row mt">
          <div class="col-md-12">
            <div class="content-panel">
                <h4><i class="fa fa-angle-right"></i> Bitacora</h4>
                <div class="pull-right position">
                  <input type="search" placeholder="Buscar" @keyup="searchit" v-model="search" class="form-control search-btn "/>
                </div>
                <hr>
              <table class="table table-striped table-advance table-hover">
                
                <thead>
                  <tr class="green">
                    <th></th>
                    <th class="centered"><i class="fa fa-caret-square-o-right"></i> Nombres</th>
                    <th class="centered"><i class="fa fa-angle-down"></i> Correo</th>
                    <th class="centered"><i class="fa fa-angle-down"></i> Fecha Inicio</th>
                    <th class="centered"><i class=" fa fa-angle-down"></i> Hora Inicio</th>
                    <th class="centered"><i class=" fa fa-dot-circle-o"></i> Fecha Salida</th>
                    <th class="centered"><i class=" fa fa-dot-circle-o"></i> Hora Salida</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody class="centered">
                  <tr v-for="ve in bitacora.data">
                    <td></td>
                    <td >{{ve.name}}</td>
                    <td >{{ve.email}}</td>
                    <td >{{ve.fecha_inicio | myDate2}}</td>
                    <td >{{ve.hora_inicio}} </td>
                    <td >{{ve.fecha_salida | myDate2}}</td>
                    <td >{{ve.hora_salida }}</td>
                    <td></td>
                  </tr>
                </tbody>
              </table>

              
                    <div class="card-footer"  >
                      <pagination :data="bitacora" @pagination-change-page="getResults" class="dataTables_paginate paging_bootstrap pagination" ></pagination>
                  </div>
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
                bitacora:{},
                search:'',
            }
        },

        created() {
             Fire.$on('searching',() => {
                        let query = this.search;
                        axios.get('busquedabitacora?q='+query)
                        .then((data) => {
                            this.bitacora = data.data;
                        })
                        .catch(() => {

                        })
                    })
            this.LoadBitacora();
            Fire.$on('AfterCreate', () => {
                this.LoadBitacora();
            });
        },

        methods: {

              getResults(page = 1) {
                axios.get('bitacoras?page=' + page)
                .then(response => {
                      this.bitacora = response.data.bitacora;
                });
            },

            //busqueda
            searchit: _.debounce(() => {
                Fire.$emit('searching');
            },1000),

            LoadBitacora(){
              axios.get('bitacoras').then(res => {
                        
                        this.bitacora = res.data.bitacora;
                    });
            },


        }
    }
</script>
