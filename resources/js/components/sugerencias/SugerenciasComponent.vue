<template>
    <section class="wrapper">

        <h3><i class="fa fa-angle-right"></i> Lista Sugerencias y Errores</h3>
     
        <!-- row -->
        <div class="row mt">
          <div class="col-md-12">
            <div class="content-panel">
                <h4><i class="fa fa-angle-right"></i> Sugerencias - Errores</h4>
                <div class="pull-right position">
                  <input type="search" placeholder="Buscar" @keyup="searchit" v-model="search" class="form-control search-btn "/>
                </div>
                <hr>
              <table class="table table-striped table-advance table-hover">
                
                <thead>
                  <tr>
                    <th></th>
                    <th class="centered"><i class="fa fa-users"></i> Nombres</th>
                    <th class="centered"><i class="fa fa-question-circle"></i> Correo</th>
                    <th class="centered"><i class="fa fa-envelope-o"></i> Mensaje</th>
                    <th class="centered"><i class=" fa fa-calendar"></i> Fecha</th>
                    <th class="centered"><i class=" fa fa-edit"></i>Detalle</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="su in sugerencias.data">
                    <td></td>
                    <td >{{su.cli_nombres }}&nbsp{{ su.cli_apellidos}}</td>
                    <td class="centered" >{{su.cli_usuario}} </td>
                    <td >{{su.sugerencias}}</td>
                    <td class="centered"><span>{{su.created_at | myDate1 }}</span></td>
                    <td class="centered">
                     <button class="btn btn-danger btn-xs" @click="eliminar(su.id)"><i class="fa fa-trash-o "></i></button>
                  
                    </td>
                    <td></td>
                  </tr>
                </tbody>
              </table>

              
                    <div class="card-footer"  >
                      <pagination :data="sugerencias" @pagination-change-page="getResults" class="dataTables_paginate paging_bootstrap pagination" ></pagination>
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

                sugerencias:{},

                search:'',
            }
        },

        created() {
             Fire.$on('searching',() => {
                        let query = this.search;
                        axios.get('busquedaSugerencias?q='+query)
                        .then((data) => {
                            this.sugerencias = data.data;
                        })
                        .catch(() => {

                        })
                    })
            this.LoadSugerencia();
            Fire.$on('AfterCreate', () => {
                this.LoadSugerencia();
            });
        },

        methods: {

              getResults(page = 1) {
                axios.get('sugerencias?page=' + page)
                .then(response => {
                      this.sugerencias = response.data.sugerencias;
                });
            },

            //busqueda
            searchit: _.debounce(() => {
                Fire.$emit('searching');
            },1000),

            LoadSugerencia(){
              axios.get('sugerencias').then(res => {
                        
                        this.sugerencias = res.data.sugerencias;
                    });
            },

            eliminar(id){
                      swal.fire({
                          title: '¿Estás seguro?',
                          text: "¡No podrás revertir esto!",
                          type: 'advertencia',
                          showCancelButton: true,
                          confirmButtonColor: '#3085d6',
                          cancelButtonColor: '#d33',
                          confirmButtonText: 'Sí, Eliminar!'
                          }).then((result) => {

                              // Send request to the server
                               if (result.value) {
                                      axios.delete('sugerencias/'+id).then(()=>{
                                              swal.fire(
                                              'Eliminado!',
                                              'Su archivo ha sido eliminado.',
                                              'success'
                                              )
                                         Fire.$emit('AfterCreate');
                                      }).catch(()=> {
                                          swal("¡Ha fallado!", "Había algo malo.", "warning");
                                      });
                               }
                          })
                  },

        }
    }
</script>
