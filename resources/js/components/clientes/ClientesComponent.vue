<template>
    <section class="wrapper">

        <h3><i class="fa fa-angle-right"></i> Listado de Clientes</h3>
     
        <!-- row -->
        <div class="row mt">
          <div class="col-md-12">
            <div class="content-panel">
                <h4><i class="fa fa-angle-right"></i> Clientes</h4>
                <div class="pull-right position">
                  <input type="search" placeholder="Buscar" @keyup="searchit" v-model="search" class="form-control search-btn "/>
                </div>
                <hr>
              <table class="table table-striped table-advance table-hover">
                
                <thead>
                  <tr>
                    <th></th>
                    <th class="centered"><i class="fa fa-users"></i> Nombres</th>
                    <th class="centered"><i class="fa fa-envelope-o"></i> Correo</th>
                    <th class="centered"><i class="fa fa-user"></i> Ci</th>
                    <th class="centered"><i class=" fa fa-mobile"></i> Nuemero de Celular</th>
                    <th class="centered"><i class=" fa fa-map-marker"></i> Dirección</th>
                    
                    <th class="centered">
                      <div v-for="a in asignar" v-if="a.user_id==iduser">
                        <div v-if="a.rol_asignacion=='SuperAdmin' || a.rol_asignacion=='Admin'">
                              <i class=" fa fa-book"></i> Detalle Asignar
                        </div>
                      </div>
                    </th>
                       
                    <th></th>
                  </tr>
                </thead>
                <tbody v-if="rol=='SuperAdmin' || rol=='Admin'">
                   
                  <tr v-for="cli in clientes.data" >
                    
                    <td></td>
                    <td >{{cli.cli_nombres }}&nbsp{{ cli.cli_apellidos}}</td>
                    <td class="centered" >{{cli.cli_usuario}} </td>
                    <td class="centered">{{cli.ci}}</td>
                    <td class="centered"><span>{{cli.cli_celular}}</span></td>
                    <td class="centered"><span>{{cli.direccion}}</span></td>
                    <td class="centered"> 
                     <div v-for="a in asignar" v-if="a.user_id==iduser">
                        <div v-if="a.rol_asignacion=='SuperAdmin' || a.rol_asignacion=='Admin'">
                          <button class="btn btn-success btn-xs" data-toggle="modal" data-target="#myModalAsignar" @click="asignarUsuario(cli)" v-if="cli.user_id==null">
                            <i class="fa fa-user"> Asignar</i>
                          </button>
                          <button class="btn btn-info btn-xs" data-toggle="modal" data-target="#myModalAsignar" @click="asignarUsuario(cli)" v-if="cli.user_id!=null">
                            <label v-for="us in usuarios" v-if="us.id==cli.user_id"> {{us.name | upText}} </label>
                          </button>
                    </div>
                      </div>
                    </td>
                    <td></td>
                  </tr>
                </tbody>
                <tbody v-if="rol=='Dist'">
                   
                  <tr v-for="cli in clientes.data" v-if="cli.user_id==iduser" >
                    
                    <td></td>
                    <td >{{cli.cli_nombres }}&nbsp{{ cli.cli_apellidos}}</td>
                    <td class="centered" >{{cli.cli_usuario}} </td>
                    <td class="centered">{{cli.ci}}</td>
                    <td class="centered"><span>{{cli.cli_celular}}</span></td>
                    <td class="centered"><span>{{cli.direccion}}</span></td>
                    <td class="centered"> 

                    </td>
                    <td></td>
                     
                  </tr>


                </tbody>

              </table>

              
                    <div class="card-footer"  >
                      <pagination :data="clientes" @pagination-change-page="getResults" class="dataTables_paginate paging_bootstrap pagination" ></pagination>
                  </div>
            </div>
            <!-- /content-panel -->
          </div>
          <!-- /col-md-12 -->
        </div>
        <!-- /row -->
                            <!-- MOdal Asignar Cliente -->

                            <div id="myModalAsignar" class="modal fade" tabindex="-1"  aria-labelledby="addNewLabel" aria-hidden="true" role="dialog">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">

                                      <div class="modal-header">
                                        <h3 class="modal-title"><i class='fa fa-pencil-square'></i><b>Asignar un Usuario al Cliente </b></h3>

                                      </div>                                
                                        <div class="modal-body">
                                         
                                        <div class="form-group" >
                                            <label>Roles de Usuarios</label>
                                            <select name="departamento" class="form-control" v-model="asignacion.user_id">
                                             
                                              <option v-for="us in usuarios"
                                              :value="us.id">{{us.name}}  </option>
                                            </select>
                                        </div>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="submit" name="submit" value="Actualizar" class="btn btn-theme"  @click="actualizar()"/>
                                            <button type="button" class="btn btn-danger" data-dismiss="modal"  >Cerrar</button>
                                        </div>
                                      </form>

                                    </div>
                                </div>
                            </div>

      </section> 

</template>

<script>
    export default {
        data(){
            return{

                clientes:{},
                search:'',
                asignacion:{
                  user_id:'',
                  dato_id:'',
                },
                asignar:{},
                iduser:'',
                usuarios:{},
                rol:'',
            }
        },

        created() {
             Fire.$on('searching',() => {
                        let query = this.search;
                        axios.get('busquedaClientes?q='+query)
                        .then((data) => {
                            this.clientes = data.data;
                        })
                        .catch(() => {

                        })
                    })
            this.LoadClientes();
            Fire.$on('AfterCreate', () => {
                this.LoadClientes();
            });
        },

        methods: {

              getResults(page = 1) {
                axios.get('clientes?page=' + page)
                .then(response => {
                      this.clientes = response.data.clientes;
                });
            },

            //busqueda
            searchit: _.debounce(() => {
                Fire.$emit('searching');
            },1000),

            LoadClientes(){
              axios.get('clientes').then(res => {
                        
                        this.clientes = res.data.clientes;
                        this.asignar=res.data.asignar;
                        this.iduser=res.data.iduser;
                        this.usuarios=res.data.usuarios;
                        this.rol=res.data.rol;
                    });
            },

            asignarUsuario(cli){
                this.asignacion.user_id=cli.user_id;
                this.asignacion.dato_id=cli.iddato;
            },

            actualizar(){
                const parametros={
                user_id: this.asignacion.user_id,
                dato_id: this.asignacion.dato_id,
              }
              axios.post('clientes', parametros)
              .then(res=>{
                toast.fire({
                  type: 'success',
                  title: 'Status Modificado Correctamente..!!!'
                });
                Fire.$emit('AfterCreate');
              

              }).catch();
            }

           

        }
    }
</script>
