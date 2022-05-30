<template>
  <div class="content">
    <div class="row mt">
  <div class="col-lg-12">
    <div class="row content-panel">
      <!-- /col-md-4 -->
      <div class="col-md-2 profile-text">
        <br>
                <p>
                     <a class="btn btn-theme" @click="nuevoProducto()" v-show="nuevoActivo">
                       <i class="fa fa-plus"></i> &nbsp Nuevo Producto
                     </a>
                 </p>
                 <p>
                     <a class="btn btn-theme04" @click="cancelarProducto()" v-show="productoActivo">
                       <i class="fa fa-times-circle"></i> &nbsp Cacelar
                     </a>
                 </p>

                 <p>
                   <label class="red1" v-show="productoActivo">
                     Todos los campos con * son importantes
                   </label>
                </p>

      </div>
      <!-- /col-md-4 -->
      <div class="" v-if="productoActivo">

        <form   @submit.prevent="ProductoUpdate(producto)" v-if="update">

        <div class="col-md-3 right-divider hidden-sm hidden-xs">

          <div class="profile-pic ">

            <div class="form-group" v-show="productoActivo">
                <label>Categoria de Producto</label>
                <select name="categoria" class="form-control" v-model="producto.categoria_id">
                  <option :value="producto.categoria_id" selected>{{categorias.nombre}}</option>
                  <option v-for="(categoria, index) in categorias.data"
                  :value="categoria.id">{{categoria.nombre}}</option>
                </select>
            </div>
            <div class="form-group">
                <label>Nombre</label>
                <input type="text" name="nombre" v-model="producto.nombre" id="nombre" placeholder="Ingresar Nombre"
                class="form-control":class="{'is-danger':errors.nombre}">
                <small v-if="errors.nombre" class="has-text-danger red1">{{errors.nombre[0]}}</small>
            </div>
            <div class="form-group">
                <label>Marca</label>
                <input type="text" name="marca" v-model="producto.marca" id="marca" placeholder="Ingresar la Marca del Producto"
                class="form-control":class="{'is-danger':errors.marca}">
                <small v-if="errors.marca" class="has-text-danger red1">{{errors.marca[0]}}</small>
            </div>

            <div class="form-group">
                <label>Modelo</label>
                <input type="text" name="modelo" v-model="producto.modelo" id="modelo" placeholder="Ingresar el Modelo del Producto"
                class="form-control">
            </div>

          </div>
        </div>
        <div class="col-md-3 right-divider hidden-sm hidden-xs">
          <div class="profile-pic">

            <div class="form-group">
                <label>Medidas</label>
                <input type="text" name="medida" v-model="producto.medida" id="medida" placeholder="Ingresar la Medida del Producto"
                class="form-control">

            </div>

            <div class="form-group">
                <label>Descripción</label>
                <input type="text" name="descripcion" v-model="producto.descripcion" id="descripcion" placeholder="Ingresar la descripcion del Producto"
                class="form-control">

            </div>

            <div class="form-group" v-show="productoActivo">
                <label>Nota de Venta de Producto</label>
                <select name="nota" class="form-control" v-model="producto.nota">
                  <option :value="producto.nota" selected>{{producto.nota}}</option>
                  <option  value="Venta unicamente por Unidad">Venta unicamente por Unidad</option>
                  <option  value="Venta unicamente por Caja">Venta unicamente por Caja</option>
                  <option  value="Venta por Caja o Unidad">Venta por Caja o Unidad</option>
                </select>
            </div>

          </div>
        </div>
        <div class="col-md-3">
          <div class=" centered">

            <div class="fileupload fileupload-new" data-provides="fileupload">
              <div class="fileupload-new thumbnail" >
                <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image"  v-if="producto.avatar=='' "/>
                <img :src="`/images/product/${producto.avatar}`" alt="" style="max-width: 300px; max-height: 350px; line-height: 10px; border-radius:5px;" v-if="producto.avatar!='' "/>

                  <br>
              </div>
              <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 300px; max-height: 250px; line-height: 10px;"></div>
              <div>
                  <p >
                <span class="btn btn-theme02 btn-file">
                  <span class="fileupload-new"><i class="fa fa-camera"></i></span>
                <span class="fileupload-exists"><i class="fa fa-undo"></i> Actualizar</span>

                  <input type="file" class="default fa fa-camera"  id="file" ref="file"  v-on:change="handleFileUpload"/>

                </span>
                  <button type="submit"  class="btn btn-theme " ><i class="fa fa-floppy-o"></i>&nbsp Actualizar</button>

                </p>
              </div>
            </div>


          </div>
        </div>
        </form>

            <form   @submit.prevent="agregar()" v-else>

            <div class="col-md-3 right-divider hidden-sm hidden-xs">

              <div class="profile-pic ">

                <div class="form-group" v-show="productoActivo">
                    <label>Categoria de Producto</label><label class="red1"> &nbsp *</label>
                    <select name="categoria" class="form-control":class="{'is-danger':errors.categoria_id}" v-model="producto.categoria_id" >
                      <option v-for="(categoria, index) in categorias.data"
                      :value="categoria.id">{{categoria.nombre}}</option>
                    </select>
                    <small v-if="errors.categoria_id" class="has-text-danger red1">{{errors.categoria_id[0]}}</small>
                </div>
                <div class="form-group">
                    <label>Nombre</label><label class="red1"> &nbsp *</label>
                    <input type="text" name="nombre" v-model="producto.nombre" id="nombre" placeholder="Ingresar Nombre"
                    class="form-control":class="{'is-danger':errors.nombre}">
                    <small v-if="errors.nombre" class="has-text-danger red1">{{errors.nombre[0]}}</small>
                </div>
                <div class="form-group">
                    <label>Marca</label><label class="red1"> &nbsp *</label>
                    <input type="text" name="marca" v-model="producto.marca" id="marca" placeholder="Ingresar la Marca del Producto"
                    class="form-control":class="{'is-danger':errors.marca}">
                    <small v-if="errors.marca" class="has-text-danger red1">{{errors.marca[0]}}</small>
                </div>

                <div class="form-group">
                    <label>Modelo</label>
                    <input type="text" name="modelo" v-model="producto.modelo" id="modelo" placeholder="Ingresar el Modelo del Producto"
                    class="form-control":class="{'is-danger':errors.modelo}">
                    <small v-if="errors.modelo" class="has-text-danger red1">{{errors.modelo[0]}}</small>
                </div>

              </div>
            </div>
            <div class="col-md-3 right-divider hidden-sm hidden-xs">
              <div class="profile-pic">

                <div class="form-group">
                    <label>Medidas</label>
                    <input type="text" name="medida" v-model="producto.medida" id="medida" placeholder="Ingresar la Medida del Producto"
                    class="form-control":class="{'is-danger':errors.medida}">
                    <small v-if="errors.medida" class="has-text-danger red1">{{errors.medida[0]}}</small>
                </div>
                 <!--
                <div class="form-group">
                    <label>Numero de Serie</label>
                    <input type="text" name="serie" v-model="producto.serie" id="serie" placeholder="Ingresar el Numero de Serie"
                    class="form-control":class="{'is-danger':errors.serie}">
                    <small v-if="errors.serie" class="has-text-danger red1">{{errors.serie[0]}}</small>
                </div>-->

                <div class="form-group">
                    <label>Descripción</label>
                    <input type="text" name="descripcion" v-model="producto.descripcion" id="descripcion" placeholder="Ingresar la descripcion del Producto"
                    class="form-control":class="{'is-danger':errors.descripcion}">
                    <small v-if="errors.descripcion" class="has-text-danger red1">{{errors.descripcion[0]}}</small>
                </div>

                <div class="form-group" v-show="productoActivo">
                    <label>Nota de Venta de Producto</label><label class="red1"> &nbsp *</label>
                    <select name="nota" class="form-control":class="{'is-danger':errors.nota_id}" v-model="producto.nota" >
                        <option  value="Venta unicamente por Unidad">Venta unicamente por Unidad</option>
                        <option  value="Venta unicamente por Caja">Venta unicamente por Caja</option>
                        <option  value="Venta por Caja o Unidad">Venta por Caja o Unidad</option>
                    </select>

                </div>

              </div>
            </div>
            <div class="col-md-3">
              <div class=" centered">

                <div class="fileupload fileupload-new" data-provides="fileupload">
                  <div class="fileupload-new thumbnail" >
                    <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image" alt="" />
                      <br>
                  </div>
                  <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 300px; max-height: 250px; line-height: 10px;"></div>
                  <div>
                      <p >
                    <span class="btn btn-theme02 btn-file">
                      <span class="fileupload-new"><i class="fa fa-camera"></i></span>
                    <span class="fileupload-exists"><i class="fa fa-undo"></i> Actualizar</span>

                      <input type="file" class="default fa fa-camera"  id="file" ref="file"  v-on:change="handleFileUpload"/>

                    </span>
                      <button type="submit"  class="btn btn-theme fileupload-exists" ><i class="fa fa-floppy-o"></i>&nbsp Guardar</button>

                    </p>
                  </div>
                </div>


              </div>
            </div>
            </form>
          </div>


      <!-- /col-md-4 -->
    </div>
    <!-- /row -->
  </div>
  <!-- /col-lg-12 -->
  <div class="col-lg-12 mt">
    <div class="row content-panel">
      <div class="col-md-12">
        <div class="pull-left position">
          <input type="search" placeholder="Buscar" @keyup="searchit" v-model="search" class="form-control search "/>
        </div>
        <pagination :data="cat" @pagination-change-page="getResults" class="dataTables_paginate paging_bootstrap pagination" ></pagination>


      </div>

        <br><br>
      <div class="panel-heading">

        <ul class="nav nav-tabs nav-justified blue" >

              <li v-for="(categoria,index) in cat.data" class="active"  v-if="index==0">
                <a data-toggle="tab" :href="`#${categoria.id}`" >{{categoria.nombre}}</a>
              </li>
              <li v-for="(categoria,index) in cat.data" v-if="index!=0">
                <a data-toggle="tab" :href="`#${categoria.id}`" >{{categoria.nombre}}</a>
              </li>

        </ul>
      </div>
      <!-- /panel-heading -->
      <div class="panel-body">
        <div class="tab-content" >
            <spiner v-show="loading"></spiner>
          <div v-for="(categoria, index) in categorias.data " :id="`${categoria.id}`" class="tab-pane active" v-if="index==0">
            <div class="row">

              <div v-for="producto in productos.data" v-if="producto.categoria_id==categoria.id">
                  <div class="col-lg-4 col-md-4 col-sm-4 mb"  >

                    <div class="content-panel pn">
                      <div id="spotify"  :style="`background: url(/images/product/${producto.avatar}); no-repeat center top; background-position: center center;	min-height: 220px;-webkit-background-size: 100%;
min-height: 200px;
width: 40%;
margin-left: 25%;
margin-right: 0px;
margin-bottom: 20px;
background-repeat: no-repeat;
                      ` ">

                        <div class="col-xs-8 col-xs-offset-12 row show-grid">

                            <button class="btn btn-sm btn-clear-g" @click=" deleteProducto(producto.id)"> <i class='fa fa-close ' style="color:red;"></i>  </button>

                        </div>


                        <div class="sp-title">
                          <h3 style="color: black;">{{producto.nombre}}</h3>
                          <h5 style="color: black;">{{producto.marca}}</h5>
                        </div>
                        <div class="play">
                          <a href="#" style="color:white;"  data-toggle="modal" data-target="#showProducto"  @click="productoShow(producto,categoria)" ><i class="fa fa-eye" style="color:#000;"></i></a>
                        </div>
                      </div>

                      <p class="followers" style="margin-left: 10px;"><a href="#" @click="updateProducto(producto,categoria)" > <i class='glyphicon glyphicon-edit '></i> <i class="fa fa-indent"></i>&nbsp{{categoria.nombre}}
                          </a>
                      </p>

                    </div>

                  </div>
              </div>

            </div>
          </div>

          <div v-for="(categoria, index) in categorias.data " :id="`${categoria.id}`" class="tab-pane" v-if="index!=0">
            <div class="row">

              <div v-for="producto in productos.data" v-if="producto.categoria_id==categoria.id">
                  <div class="col-lg-4 col-md-4 col-sm-4 mb"  >
                    <div class="content-panel pn">
                      <div id="spotify"  :style="`background: url(/images/product/${producto.avatar}); no-repeat center top; background-position: center center;	min-height: 220px;-webkit-background-size: 100%;
                        min-height: 200px;
                        width: 40%;
                        margin-left: 25%;
                        margin-right: 0px;
                        margin-bottom: 20px;
                        background-repeat: no-repeat;
                      ` ">

                        <div class="col-xs-8 col-xs-offset-12">
                          <button class="btn btn-sm btn-clear-g" @click="deleteProducto(producto.id)">  <i class='fa fa-close ' style="color:red;"></i></button>
                        </div>
                        <div class="sp-title">
                          <h3 style="color: black;">{{producto.nombre}}</h3>
                          <h5 style="color: black;">{{producto.marca}}</h5>
                        </div>
                        <div class="play">
                          <a href="#" style="color:white;"  data-toggle="modal" data-target="#showProducto"  @click="productoShow(producto,categoria)" ><i class="fa fa-eye" style="color:#000;"></i></a>
                        </div>
                      </div>

                      <p class="followers" style="margin-left: 10px;"><a href="#" @click="updateProducto(producto,categoria) " ><i class='glyphicon glyphicon-edit '></i> <i class="fa fa-indent"></i>&nbsp{{categoria.nombre}}
                          </a>
                      </p>

                    </div>
                  </div>
              </div>

            </div>
          </div>

          <!-- /tab-pane -->

          <!-- /tab-pane -->
        </div>
        <!-- /tab-content -->
      </div>
      <!-- /panel-body -->
    </div>
    <!-- /col-lg-12 -->
  </div>
  <!-- /row -->
  </div>
                  <!-- MOdal Show- User   Mostrar informacion de Perfil-->

                  <div id="showProducto" class="modal fade" tabindex="-1"  aria-labelledby="addNewLabel" aria-hidden="true" role="dialog">
                      <div class="modal-dialog modal-dialog-centered">
                          <div class="modal-content " >

                            <div class="modal-header">
                              <h3 class="modal-title"><i class='fa fa-pencil-square'></i><b> Información de Producto</b></h3>

                            </div>

                              <div class="modal-body">

                                <div class="col-xs-12 .col-sm-6 col-md-7">
                                  <div class="profile-picc centered ">

                                    <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image"  v-if="producto.avatar=='' "/>
                                    <img :src="`/images/product/${producto.avatar}`" alt="" style="max-width: 500px; max-height: 250px; line-height: 10px;" v-if="producto.avatar!='' "/>

                                  </div>
                                </div>

                                <div class="">

                                  <div class="form-group">
                                      <label style="color: #000;">Nombre : </label>
                                      <label  v-model="producto.nombre">{{producto.nombre | upText}}</label>
                                  </div>

                                  <div class="form-group">
                                      <label style="color: #000;">Marca : </label>
                                      <label  v-model="producto.marca">{{producto.marca }}</label>
                                  </div>

                                  <div class="form-group" v-show="producto.modelo==null">
                                      <label style="color: #000;">Modelo : </label>
                                      <label  v-model="producto.modelo" >...</label>
                                  </div>
                                  <div class="form-group" v-show="producto.modelo!=null">
                                      <label style="color: #000;">Modelo : </label>
                                      <label  v-model="producto.modelo" >{{producto.modelo }}</label>
                                  </div>

                                  <div class="form-group" v-show="producto.medida==null">
                                      <label style="color: #000;">Medida : </label>
                                      <label  v-model="producto.medida">...</label>
                                  </div>
                                  <div class="form-group" v-show="producto.medida!=null">
                                      <label style="color: #000;">Medida : </label>
                                      <label  v-model="producto.medida">{{producto.medida }}</label>
                                  </div>

                                  <div class="form-group" v-show="producto.serie==null">
                                      <label style="color: #000;">Serie : </label>
                                      <label  v-model="producto.serie">...</label>
                                  </div>
                                  <div class="form-group" v-show="producto.serie!=null">
                                      <label style="color: #000;">Serie : </label>
                                      <label  v-model="producto.serie">{{producto.serie }}</label>
                                  </div>

                                  <div class="form-group" v-show="producto.descripcion==null">
                                      <label style="color: #000;">Descripcion : </label>
                                      <label  v-model="producto.descripcion">...</label>
                                  </div>
                                  <div class="form-group" v-show="producto.descripcion!=null">
                                      <label style="color: #000;">Descripcion : </label>
                                      <label  v-model="producto.descripcion">{{producto.descripcion }}</label>
                                  </div>

                                </div>

                              </div>


                          </div>
                      </div>
                  </div>


  </div>
</template>

<script>
    export default {
      data(){
        return{
          file: '',
          productos:{},
          cat:{},
          producto:{
            nombre:'',
            marca:'',
            modelo:'',
            medida:'',
            serie:'',
            descripcion:'',
            nota:'',
            avatar:'',

          },

          categorias:{},

          errors:{},
          productoActivo: false,
          nuevoActivo:true,
          update:false,
          loading:true,
          search:'',


        }
      },

      created(){
       Fire.$on('searching',() => {
              let query = this.search;
              axios.get('findBusquedaProd?q='+query)
              .then((data) => {
                  this.productos = data.data;
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
          axios.get('/productos')
          .then(( res )=>{
            this.productos = res.data.productos;
            this.categorias = res.data.categorias;
            this.cat = res.data.cat;
            this.loading = false;
          });
        },

        getResults(page = 1) {
            axios.get('productos?page=' + page)
            .then(response => {
                this.cat = response.data.cat;
            });
        },

        //busqueda
        searchit: _.debounce(() => {
            Fire.$emit('searching');
        },1000),

          nuevoProducto(){
              this.productoActivo=true;
              this.nuevoActivo = false;
          },

          cancelarProducto(){
            this.productoActivo=false;
            this.nuevoActivo = true;
            this.update=false;
            this.producto.nombre='';
            this.producto.marca='';
            this.producto.medida='';
            this.producto.modelo='';
            this.producto.serie='';
            this.producto.descripcion='';
            this.producto.nota='';
            this.producto.avatar='';
            this.producto.categoria_id='';

            this.errors.nombre='';
            this.errors.marca='';
            this.errors.modelo='';
            this.errors.medida='';
            this.errors.serie='';
            this.errors.categoria_id='';
          },

          handleFileUpload(e){
            let fil = e.target.files[0];
            //this.file = this.$refs.file.files[0];
            //console.log(fil);
            this.file = fil;
            //this.perfil[0].avatar=fil.name;
          },

          agregar(){
            let formData = new FormData();
            formData.append('file', this.file);
            formData.append('nombre', this.producto.nombre);
            formData.append('marca', this.producto.marca);
            formData.append('modelo', this.producto.modelo);
            formData.append('medida', this.producto.medida);
            formData.append('serie', this.producto.serie);
            formData.append('descripcion', this.producto.descripcion);
            formData.append('nota', this.producto.nota);
            formData.append('categoria_id', this.producto.categoria_id);

            axios.post('productos',
                    formData,
                    {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                  }
                ).then((res) => {
                   Fire.$emit('AfterCreate');
                   this.cancelarProducto();
                   toast.fire({
                     type: 'success',
                     title: 'Producto Agregado Correctamente..!!!'
                   });

                   this.errors.nombre='';
                   this.errors.marca='';
                   this.errors.modelo='';
                   this.errors.medida='';
                   this.errors.serie='';
                   this.errors.categoria_id='';

                }).catch((error)=>this.errors = error.response.data.errors);

          },


          //Eliminar
          deleteProducto(id){
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
                                    axios.delete('productos/'+id).then(()=>{
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

                productoShow(item,item1){
                  this.producto.nombre = item.nombre;
                  this.producto.marca=item.marca;
                  this.producto.modelo=item.modelo;
                  this.producto.medida=item.medida;
                  this.producto.serie=item.serie;
                  this.producto.descripcion=item.descripcion;
                  this.producto.nota=item.nota;
                  this.producto.avatar=item.avatar;

                  this.categorias.nombre = item1.nombre;

                },


                updateProducto(item,item1){

                  this.productoActivo=true;
                  this.nuevoActivo = false;
                  this.update=true;
                  this.producto.id = item.id;
                  this.producto.nombre = item.nombre;
                  this.producto.marca=item.marca;
                  this.producto.modelo=item.modelo;
                  this.producto.medida=item.medida;
                  this.producto.serie=item.serie;
                  this.producto.descripcion=item.descripcion;
                  this.producto.nota=item.nota;
                  this.producto.avatar=item.avatar;
                  this.producto.categoria_id=item.categoria_id;

                  this.categorias.nombre = item1.nombre;
                },

                ProductoUpdate(item){
                 let formData = new FormData();

                  formData.append('file', this.file);
                  formData.append('id', item.id);
                  formData.append('nombre', item.nombre);
                  formData.append('marca', item.marca);
                  formData.append('modelo', item.modelo);
                  formData.append('medida', item.medida);
                  formData.append('serie', item.serie);
                  formData.append('descripcion', item.descripcion);
                  formData.append('nota', item.nota);
                  formData.append('avatar', item.avatar);
                  formData.append('categoria_id', item.categoria_id);

                  //const formData= {file: this.file, nombre: item.nombre, marca: item.marca, modelo: item.modelo, medida: item.medida, serie: item.serie, descripcion: item.descripcion, avatar: item.avatar, categoria_id: item.categoria_id  };

                  axios.post('/updateProducto/',formData,
                  {
                  headers: {
                      'Content-Type': 'multipart/form-data'
                  }
                }
                ).then((res) => {
                      // success
                      this.cancelarProducto();
                     //$('.modal-backdrop').hide();

                       swal.fire(
                          'Actualizado!',
                          'La información ha sido actualizada.',
                          'success'
                          )

                           Fire.$emit('AfterCreate');

                  }).catch((error)=>this.errors = error.response.data.errors);

                },




      },

    }
</script>
