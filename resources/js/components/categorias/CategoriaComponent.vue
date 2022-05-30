<template>
        <div class="row mt">
          <div class="row mt">
            <div class="col-md-12">
              <section class="task-panel tasks-widget">
                <div class="panel-heading">
                  <div class="pull-left">
                    <h5><i class="fa fa-tasks"></i> Lista de Categorias</h5>
                  </div>
                  <br>
                </div>
                <div class="panel-body ">
                  <div class="task-content ">
                    <div class="col-md-6 offset-md-6 mt-6  blue">
                    <form @submit.prevent="editarCategoria(categoria)" v-if="editarActivo">
                      <div class="menu">
                      <div class="modal-header">
                              <h3 class="modal-title my-3 "><i class='fa fa-pencil-square'></i><b>Editar Formulario</b></h3>
                      </div>
                      <div class="card-body blue">

                               <div class="form-group">
                                    <label class="control-label">Nombre</label>
                                    <input type="text" name="nombre" v-model="categoria.nombre" class="form-control" placeholder="Ingresar el Nombre" >
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Descripcion</label>
                                  <textarea  class="form-control" name="descripcion" v-model="categoria.descripcion"  placeholder="Ingresar descripcion"   maxlength="255" ></textarea>
                                </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success">Guardar</button>
                                    <button type="submit" class="btn btn-danger" @click="cancelarEdicion()">Cancelar</button>
                                </div>
                        </div>

                      </div>
                    </form>


                    <form @submit.prevent="agregar" v-else>
                      <div class="menu">


                      <div class="modal-header">
                              <h3 class="modal-title my-3 "><i class='fa fa-pencil-square'></i><b>Agregar Categoria</b></h3>
                      </div>
                      <div class="card-body">

                               <div class="form-group">
                                    <label class="control-label">Nombre</label>
                                    <input type="text" name="nombre" v-model="categoria.nombre" class="form-control":class="{'is-danger':errors.nombre}"
                                     placeholder="Ingresar el Nombre" >
                                    <small v-if="errors.nombre" class="has-text-danger red1">{{errors.nombre[0]}}</small>
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Descripcion</label>
                                  <textarea class="form-control":class="{'is-danger':errors.descripcion}" name="descripcion"v-model="categoria.descripcion"  placeholder="Ingresar descripcion"   maxlength="255" ></textarea>
                                    <small v-if="errors.descripcion" class="has-text-danger red1">{{errors.descripcion[0]}}</small>
                                </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                </div>
                        </div>
                      </div>
                    </form>
                  </div>
                  <!-- division -->
                  <div class="col-md-1"></div>
                  <!-- lista de categorias -->
                  <div class="col-md-6 offset-md-6">

                    <div class="modal-header" >

                             <div class="col-sm-12">
                               <div class="col-xs-6 col-sm-8">
                                 <div class="col-xs-6 col-sm-6"><h4><i class='fa fa-list'></i> Lista de Categorías</h4></div>
                                 <div class="pull-right position">
                                   <input type="search" placeholder="Buscar" @keyup="searchit" v-model="search" class="form-control search-btn "/>
                                 </div>
                               </div>
                            </div>

                      </div>

                          <div class="card-body">
                            <spiner v-show="loading"></spiner>
                              <div class="card-body table-responsive p-0">
                                    <ul class="list-group ">
                                       <li class="list-group-item " v-for="(categoria, index) in categorias" >
                                         <span class="badge badge-primary float-right ">
                                          {{categoria.updated_at}}
                                         </span>
                                         <p><h4 class="my-3 lec"><b>
                                           {{categoria.nombre }}
                                         </b></h4></p>
                                        <hr/>
                                         <p class="oscuro"><font color="white">
                                           {{categoria.descripcion}}
                                         </font></p>
                                         <hr/>

                                           <a href="#" @click="editarFormulario(categoria)">  <i class='fa fa-edit green'></i></a>

                                           <a href="#" @click="eliminarCategoria(categoria.id)">  <i class='glyphicon glyphicon-trash red'></i></a>



                                       </li>

                                    </ul>
                            </div>
                          </div>

                  </div>

                  </div>

                </div>
              </section>
            </div>
            <!-- /col-md-12-->
          </div>

            </div>
        </div>

</template>

<script>
    export default {
      data(){
        return{
          categorias:{},
          categoria:{
            nombre:'',
            descripcion:'',
          },
          errors:{},
          editarActivo: false,

          loading: true,
          search:'',
        }
      },


      created(){
        Fire.$on('searching',() => {
              let query = this.search;
              axios.get('findBusqueda?q='+query)
              .then((data) => {
                  this.categorias = data.data;
              })
              .catch(() => {

              })
          })
        this.cargar();
        Fire.$on('AfterCreate',() => {
                     this.cargar();
                 });
      },


      methods:{




        cargar(){
          axios.get('/categorias')
          .then(( res )=>{
            this.categorias = res.data;
            this.loading = false;
          });
          },


          //busqueda
          searchit: _.debounce(() => {
              Fire.$emit('searching');
          },1000),


        agregar(){
          const parametros={
            nombre: this.categoria.nombre,
            descripcion: this.categoria.descripcion
          }
          this.categoria.nombre = '';
          this.categoria.descripcion = '';

          axios.post('categorias', parametros)
          .then(res=>{
            Fire.$emit('AfterCreate');
            toast.fire({
              type: 'success',
              title: 'Categoria Creado Correctamente..!!!'
            });
            this.errors.nombre='';
            this.errors.descripcion='';
          }).catch((error)=>this.errors = error.response.data.errors);
        },

        editarFormulario(categoria){
          this.editarActivo = true;
          this.categoria.nombre = categoria.nombre;
          this.categoria.descripcion = categoria.descripcion;
          this.categoria.id = categoria.id;
        },

        editarCategoria(item){
          const params = {nombre: item.nombre, descripcion: item.descripcion, };
          axios.put(`/categorias/${item.id}`, params)
          .then(res=>{

            this.editarActivo = false;
            this.categoria.nombre = '';
            this.categoria.descripcion = '';
            swal.fire(
               'Actualizado!',
               'La información ha sido actualizada.',
               'success'
               )

                Fire.$emit('AfterCreate');


          }).catch((error)=>this.errors = error.response.data.errors);
        },

        cancelarEdicion(){
          this.editarActivo = false;
          this.categoria = {nombre:'', descripcion:'',};
        },

        eliminarCategoria(id){
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
                          axios.delete('categorias/'+id).then(()=>{
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
