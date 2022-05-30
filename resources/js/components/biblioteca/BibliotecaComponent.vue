<template>

    <div>
        <h3><i class="fa fa-angle-right"></i> Galeria de Fotos de los Productos</h3>
        <!-- page start-->
        <div class="row mt">
          <aside class="col-lg-2 mt">
            <h4><i class="fa fa-angle-right"></i> Categorias</h4>
            <div id="external-events" class="col-lg-2 mt" >
              <div v-for="ca  in categorias.data">
                <div class="external-event label label-info" @click="verProducto(ca.id)">{{ca.nombre}}</div>
              </div>
               
            </div>
           
          </aside>
          <div class="card-footer "  >
                  <pagination :data="categorias" @pagination-change-page="getResults" class="dataTables_paginate paging_bootstrap pagination" ></pagination>
              </div>
          <aside class="col-lg-10 mt">
            <section class="panel">
              <div class="panel-body">
                <div class="col-lg-2 mt">
                <div  v-show="productoshow" v-for="pro in productos" v-if="pro.categoria_id==cat.categoria">
          
                    <div class="external-event label label-theme" @click="verImagen(pro.id)">{{pro.nombre}}-{{pro.marca}}</div>
               
                </div>
                </div>

                <div  class="col-lg-10 mt">

                  <div class="col-lg-12 "  v-if="cat.categoria==''">
                      <h3>Seleccione una Categoria</h3>
                  </div>

                  <div class="col-lg-2 mt">

                  </div>
                  <div class="col-lg-10 mt">
                    <div class="col-lg-12 mt">
                      
                      <div v-if="biblio.producto=='' && cat.categoria!=''">
                          <h3>Seleccione un Producto</h3>
                      </div>

                    <div v-if="biblio.producto!=''" class="pull-right position">
                     
                        <button class="btn btn-theme " data-toggle="modal" data-target="#myModal">
                          <i class="fa fa-picture-o"></i> &nbsp
                          Nueva Fotografia
                        </button>
                        <br>
                    </div>
                    </div>
                      <div class="row mt"  >
                    <spiner v-show="loading"></spiner>
                    
                  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12  " v-for="bi in biblioteca" v-if="bi.productos_id==biblio.producto" >
                    
                    <div class="project-wrapper ">
                      
                      <div class="project ">
                        
                        <div class="photo-wrapper ">
                          
                          <div class="overlay"></div>
                          
                          <div class="photo ">
                            <a class="fancybox " :href="`images/product/biblio/${bi.avatar}`">
                              <img class="img-responsive " :src="`images/product/biblio/${bi.avatar}`" style=" height: 180px; margin-left: 25%; width: 50%" alt="">
                            </a>
                          </div>
                          <div class="col-xs-8 .col-sm-6" v-for="pro in productos" v-if="bi.productos_id == pro.id"> </div>
                            <div class="col-xs-4 .col-sm-2">  <a href="#" @click="eliminar(bi.id)" class="col-xs-offset-10" >  <i class='fa fa-close' style="color:red;"></i></a>
                          </div>

                        </div>
                      </div>
                    </div>
                    <br><br>
                  </div>
                </div>

                  </div>

                  

                


                </div>

              </div>
            </section>
            
          </aside>
        </div>


        
        


          <!-- Nueva Fotografia -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">   <i class="fa fa-picture-o"></i>&nbsp Agregar Fotografia</h4>
              </div>
              <div class="modal-body">

                <div class="form-group" >
                    <label>Seleccione La Categoria :</label>
                    <select name="categoria" class="form-control" v-model="cat.categoria">
                        <option value="" selected>Seleccione una de las Categorias...</option>
                        <option v-for="cat in categorias.data"
                        :value="cat.id" >{{cat.nombre}}</option>
                    </select>
                </div>
                <div class="form-group" v-if="cat.categoria!=''" >
                    <label>Producto Para Añadir Imagen :</label>
                    <select name="producto" class="form-control" v-model="biblio.producto">
                        <option value="" selected>Seleccione uno de los Productos...</option>
                        <option v-for="pro in productos" v-if="pro.categoria_id==cat.categoria"
                        :value="pro.id" >{{pro.nombre}} - {{pro.marca}} - {{pro.medida}}</option>
                    </select>
                </div>

                <div class="centered" >
                  <div class="fileupload fileupload-new" data-provides="fileupload">
                    <div class="fileupload-new thumbnail" >
                      <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image" alt="" />
                      <br>
                    </div>
                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 300px; max-height: 250px; line-height: 10px;"></div>
                    <div class="modal-footer centered">
                        <p >
                      <span class="btn btn-theme btn-file">
                        <span class="fileupload-new"><i class="fa fa-camera"></i></span>
                      <span class="fileupload-exists"><i class="fa fa-undo"></i> Actualizar</span>
                        <input type="file" class="default fa fa-camera"  id="file" ref="file"  v-on:change="handleFileUpload" />
                      </span>
                        <a v-on:click="submitFile(biblio)" class="btn btn-theme04 fileupload-exists" data-dismiss="fileupload"><i class="fa fa-floppy-o"></i> ADD</a>
                      </p>
                    </div>
                  </div>

                </div>


              </div>

            </div>
          </div>
        </div>



    </div>
    
</template>


<script>

    $(function() {
      //    fancybox
      jQuery(".fancybox").fancybox();
    });
    export default {
        data(){
          return{
            file:'',
            datos:{},
            biblioteca:{},
            productos:{},
            categorias:{},
            biblio:{
              producto:'',
            },
            cat:{
              categoria:'',
            },
            loading:true,
            search:'',
            productoshow:false,

          }
        },

        created(){
         /*Fire.$on('searching',() => {
                let query = this.search;
                axios.get('findBusquedaBib?q='+query)
                .then((data) => {
                    this.categorias = data.data;
                })
                .catch(() => {

                })
            })*/
          this.LoadUser();
          Fire.$on('AfterCreate',() => {
                       this.LoadUser();
                   });
        },


          methods:{

            getResults(page = 1) {
                axios.get('biblioteca?page=' + page)
                .then(response => {
                      this.categorias = response.data.categorias;
                });
            },

            //busqueda
            searchit: _.debounce(() => {
                Fire.$emit('searching');
            },1000),

                    LoadUser(){
                      axios.get('biblioteca')
                      .then(( res )=>{
                        //this.users = res.data.usuarios;
                        this.datos = res.data;
                        this.biblioteca= res.data.biblioteca;
                        this.productos = res.data.productos;
                        this.categorias =  res.data.categorias;
                        this.loading = false;
                      });
                    },

            handleFileUpload(e){
              let fil = e.target.files[0];
              this.file = fil;

            },


            submitFile(item){
                  let formData = new FormData();
                  formData.append('file', this.file);
                  formData.append('id_producto', item.producto);


                  axios.post('/biblioteca/',
                      formData,
                      {
                      headers: {
                          'Content-Type': 'multipart/form-data'
                      }
                    }
                  ).then((res) => {


                    Fire.$emit('AfterCreate');

                     toast.fire({
                       type: 'success',
                       title: 'Imagen agregada..!!!'
                     });

                    this.cat.categoria='',

                     $('#myModal').modal('hiden');
                  })
              .catch(function(){
                console.log('FAILURE!!');
              });
            },

            //Eliminar
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
                                      axios.delete('biblioteca/'+id).then(()=>{
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

            verProducto(id){
              this.productoshow=true;
              this.cat.categoria=id;
              this.biblio.producto='';
            },

            verImagen(id){
              this.biblio.producto=id;
            }


          },

          
    }
</script>
