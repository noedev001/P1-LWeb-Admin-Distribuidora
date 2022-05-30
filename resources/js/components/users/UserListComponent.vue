<template>
            <div class="col-md-12">
                <spiner v-show="loading"></spiner>
              <div class="chat-room-head col-md-12">
                <h3>Lista de Usuarios</h3>
                <div class="pull-right position">
                  <input type="search" placeholder="Buscar" @keyup="searchit" v-model="search" class="form-control search-btn "/>
                </div>
              </div>
            </br></br></br></br>
                  <!-- /.card-header -->
                  <div class="card-body table-responsive ">
                    <table class="table table-hover text-center ">
                      <thead style="color: #1abc9c ;" >
                        <tr >
                            <th class="text-center"><i class="fa fa-user"></i> Nombre</th>
                            <th class="text-center"><i class="fa fa-envelope"></i> Email</th>
                            <th class="text-center"><i class="fa fa-calendar"></i> Registro</th>
                            <th class="text-center"><i class=" fa fa-edit"></i> Status</th>
                            <th class="text-center"><i class=" fa fa-th-list"></i> Acciones</th>
                      </tr>
                      </thead>
                      <tbody>
                      <tr v-for="(user, index) in users.data">
                        <td>{{user.name | upText }}</td>
                        <td>{{user.email}}</td>
                        <td>{{user.created_at | myDate}}</td>
                        <td v-for="(asignar) in todo.asignasiones" v-if="user.id == asignar.user_id"  >
                          <a v-if="asignar.rol_asignacion == ''"  href="#"  data-toggle="modal" data-target="#ShowUpdateStatus" @click="UpdateStatus(user,asignar)">
                              <span class="label label-danger label-mini">Asignar</span>
                          </a>
                          <a v-if="asignar.rol_asignacion!='' && asignar.rol_asignacion=='SuperAdmin'"  href="#"  data-toggle="modal" data-target="#ShowUpdateStatus" @click="UpdateStatus(user,asignar)">
                              <span class="label label-success label-mini">Super Admin</span>
                          </a>
                          <a v-if="asignar.rol_asignacion!='' && asignar.rol_asignacion=='Admin' "  href="#"  data-toggle="modal" data-target="#ShowUpdateStatus" @click="UpdateStatus(user,asignar)">
                              <span class="label label-primary label-mini">Admin</span>
                          </a>
                          <a v-if="asignar.rol_asignacion!='' &&  asignar.rol_asignacion=='Dist'"  href="#"  data-toggle="modal" data-target="#ShowUpdateStatus" @click="UpdateStatus(user,asignar)">
                              <span class="label label-theme label-mini">Distribuidor</span>
                          </a>
                        </td>

                        <td>
                            <a  v-for="(perfil) in todo.perfiles" v-if="user.id == perfil.user_id"  href="#" data-toggle="modal" data-target="#showUser"  @click="UserShow(user,perfil)" >
                                <i class='glyphicon glyphicon-eye-open green'></i>

                            </a>
                            /
                            <a href="#"  @click="deleteUser(user.id)">
                                <i class='glyphicon glyphicon-trash red'></i>
                            </a>

                        </td>
                      </tr>
                    </tbody>
                  </table>
                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer"  >
                    <pagination :data="users" @pagination-change-page="getResults" ></pagination>
                </div>


                            <!-- MOdal Show update Status -->

                            <div id="ShowUpdateStatus" class="modal fade" tabindex="-1"  aria-labelledby="addNewLabel" aria-hidden="true" role="dialog">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">

                                      <div class="modal-header">
                                        <h3 class="modal-title"><i class='fa fa-pencil-square'></i><b>Actualizar el Status del Usuarion : {{user.name}} </b></h3>

                                      </div>
                                      <form @submit.prevent="updateStatus(asignar)">
                                        <div class="modal-body">
                                          <input type="hidden" id="id_user" name="id_users" v-model="asignar.id" class="form-control">


                                        <div class="form-group" v-if="asignar.rol_asignacion == ''">
                                            <label>Roles de Usuarios</label>
                                            <select name="departamento" class="form-control" v-model="asignar.rol_asignacion">
                                              <option value="" selected>Seleccione uno de los Roles...</option>
                                              <option value="SuperAdmin">Super Administrador</option>
                                              <option value="Admin">Administrador</option>
                                              <option value="Dist">Distribuidor</option>
                                            </select>
                                        </div>
                                        <div class="form-group" v-if="asignar.rol_asignacion != ''">
                                            <label>Roles de Usuarios</label>
                                            <select name="departamento" class="form-control" v-model="asignar.rol_asignacion">
                                              <option v-for="(sucursal, index) in todo.sucursales"
                                              :value="sasignar.rol_asignacion">{{asignar.rol_asignacion}}</option>
                                              <option value="SuperAdmin">Super Administrador</option>
                                              <option value="Admin">Administrador</option>
                                              <option value="Dist">Distribuidor</option>
                                            </select>
                                        </div>

                                        </div>

                                        <div class="modal-footer">
                                            <input type="submit" name="submit" value="Actualizar" class="btn btn-theme"  />
                                            <button type="button" class="btn btn-danger" data-dismiss="modal"  >Cerrar</button>
                                        </div>
                                      </form>

                                    </div>
                                </div>
                            </div>


                            <!-- MOdal Show- User   Mostrar informacion de Perfil-->

                            <div id="showUser" class="modal fade" tabindex="-1"  aria-labelledby="addNewLabel" aria-hidden="true" role="dialog">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content " >

                                      <div class="modal-header">
                                        <h3 class="modal-title"><i class='fa fa-pencil-square'></i><b> Información de Usuario</b></h3>

                                      </div>

                                        <div class="modal-body">

                                          <div class="profile-pic centered ">
                                            <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image"  v-if="perfil.avatar=='' "/>
                                            <img :src="`images/profile/${perfil.avatar}`" alt="" style="max-width: 500px; max-height: 250px; line-height: 10px;" v-if="perfil.avatar!='' "/>
                                              <br>
                                          </div>

                                          <div class="form-group">
                                              <label style="color: #000;">Usuario : </label>
                                              <label  v-model="user.name">{{user.name | upText}}</label>
                                          </div>

                                          <div class="form-group">
                                              <label style="color: #000;">Apellido : </label>
                                              <label  v-model="perfil.apellido">{{perfil.apellido }}</label>
                                          </div>

                                          <div class="form-group">
                                              <label style="color: #000;">Email : </label>
                                              <label  v-model="user.email">{{user.email }}</label>
                                          </div>

                                          <div class="form-group">
                                              <label style="color: #000;">Dirección : </label>
                                              <label  v-model="perfil.direccion">{{perfil.direccion }}</label>
                                          </div>

                                          <div class="form-group">
                                              <label style="color: #000;">Celular : </label>
                                              <label  v-model="perfil.celular">{{perfil.celular }}</label>
                                          </div>


                                        </div>


                                    </div>
                                </div>
                            </div>

<!-- col-md-12 -->
  </div>

</template>

<script>
    export default {
      data(){
        return{
          users:{},
          todo:{},
          user:{
            name:'',
            email:'',
            role:'',
            sucur:'',
          },
          perfil:{
            apellido:'',
            direccion:'',
            celular:'',
            avatar:''
          },
        asignar:{
          id:'',
          rol_asignacion:'',

        },
          search:'',
          loading: true,




        }
      },

      created(){
        Fire.$on('searching',() => {
              let query = this.search;
              axios.get('findUser?q='+query)
              .then((data) => {
                  this.users = data.data;
              })
              .catch(() => {

              })
          })
        this.LoadUser();
        Fire.$on('AfterCreate',() => {
                     this.LoadUser();
                 });
      },

      methods:{

        LoadUser(){
          axios.get('/users')
          .then(( res )=>{
            this.users = res.data.usuarios;
            this.todo = res.data;
            this.perfil = res.data.perfiles;
            this.loading = false;
          });
        },



        getResults(page = 1) {
            axios.get('users?page=' + page)
            .then(response => {
                this.users = response.data.usuarios;
            });
        },

        //busqueda
        searchit: _.debounce(() => {
            Fire.$emit('searching');
        },1000),

        //------Status

        updateStatus(item){
          const parametros={
            asignar_id: item.id,
            role: item.rol_asignacion,
          }
          axios.post('users', parametros)
          .then(res=>{

            Fire.$emit('AfterCreate');
            $('#ShowUpdateStatus').modal('hide');
           //$('.modal-backdrop').hide();
            toast.fire({
              type: 'success',
              title: 'Status Modificado Correctamente..!!!'
            });

          }).catch();
        },


            //Eliminar
            deleteUser(id){
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
                                      axios.delete('users/'+id).then(()=>{
                                              swal.fire(
                                              'Eliminado!',
                                              'Su archivo ha sido eliminado.',
                                              'success'
                                              )
                                         
                                      }).catch(()=> {
                                          swal("¡Ha fallado!", "Había algo malo.", "warning");
                                      });
                                      Fire.$emit('AfterCreate');
                               }
                          })
                  },



          // ver usuario

          UserShow(user,item){
            this.user.name = user.name;
            this.user.id = user.id;
            this.user.email = user.email;
            this.perfil.apellido = item.apellido;
            this.perfil.direccion = item.direccion;
            this.perfil.celular = item.celular;
            this.perfil.avatar = item.avatar
          },


          //------Status Show Update
          UpdateStatus(item,item1){

            this.user.name = item.name;
            this.user.id = item.id;
            this.asignar.id = item1.id;
            this.asignar.rol_asignacion = item1.rol_asignacion;
          },




      },

    }
</script>
