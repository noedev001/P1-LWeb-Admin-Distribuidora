<template>
    <div class="col-md-12" >
        <spiner v-show="loading"></spiner>
      <div class="col-lg-10 col-lg-offset-2 detailed"  v-for="(user, index) in users.data" v-if="user.id==user_id">
        <h4 class="mb">Información Personal</h4>
        <br>
        <div class="col-md-4 centered">

          <div class="">
            <div class="fileupload fileupload-new" data-provides="fileupload">
              <div class="fileupload-new thumbnail" v-for="(perfil, index) in perfil" v-if="perfil.user_id==user_id">
                <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image" alt=""  v-if="perfil.avatar=='' && perfil.user_id==user_id "/>
                <img :src="`images/profile/${perfil.avatar}`" alt="" style="max-width: 300px; max-height: 250px; line-height: 10px;" v-if="perfil.avatar!='' && perfil.user_id==user_id"/>
                  <br>
              </div>
              <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 300px; max-height: 250px; line-height: 10px;"></div>
              <div>
                  <p v-for="(perfil, index) in perfil" v-if="perfil.user_id==user_id">
                <span class="btn btn-theme btn-file">
                  <span class="fileupload-new"><i class="fa fa-camera"></i></span>
                <span class="fileupload-exists"><i class="fa fa-undo"></i> Actualizar</span>

                  <input type="file" class="default fa fa-camera"  id="file" ref="file"  v-on:change="handleFileUpload"/>

                </span>
                  <a v-on:click="submitFile(perfil)" class="btn btn-theme04 fileupload-exists" data-dismiss="fileupload"><i class="fa fa-floppy-o"></i> ADD</a>
                  <button class="btn btn-theme02"  data-toggle="modal" data-target="#showUserPerfil" @click="showPerfil(user,perfil)"><i class="fa fa-edit"></i> Editar Perfil</button>
                </p>
              </div>
            </div>
            <br><br>
          </div>
        </div>

        <!-- /col-md-4 -->
          <div class="form-group">
            <label class="col-lg-2 control-label black1"> Nombre : </label>
            <div class="col-lg-6" >
              <label class="col-lg-4 control-label lec" > {{user.name  }} </label>
            </div>
          </div>
            <br><br>
          <div class="form-group" >
            <label class="col-lg-2 control-label black1">Apellidos : </label>
            <div class="col-lg-6" v-for="(perfil, index) in perfil" v-if="perfil.user_id==user_id">
              <label class="col-lg-4 control-label lec">{{perfil.apellido }}  </label>
            </div>
          </div>
          <br><br>
          <div class="form-group">
            <label class="col-lg-2 control-label black1">Email : </label>
            <div class="col-lg-6" >
                <label class="col-lg-4 control-label lec">{{user.email}} </label>
            </div>
          </div>
          <br><br>
          <div class="form-group">
            <label class="col-lg-2 control-label black1">Dirección : </label>
            <div class="col-lg-6" v-for="(perfil, index) in perfil" v-if="perfil.user_id==user_id">
                <label class="col-lg-4 control-label lec">{{perfil.direccion }} </label>
            </div>
          </div>
          <br><br>
          <div class="form-group">
            <label class="col-lg-2 control-label black1">Celular : </label>
            <div class="col-lg-6" v-for="(perfil, index) in perfil" v-if="perfil.user_id==user_id">
                <label class="col-lg-4 control-label lec"> {{perfil.celular}} </label>
            </div>
          </div>

      </div>



      <!-- MOdal Edit Perfil -->

      <div id="showUserPerfil" class="modal fade" tabindex="-1"  aria-labelledby="addNewLabel" aria-hidden="true" role="dialog">
          <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">

                <div class="modal-header">
                  <h3 class="modal-title"><i class='fa fa-pencil-square'></i><b> Actualización de Perfil de  Usuario </b></h3>
                </div>


                <!-- MOdal editar Perfil -->

              <form   @submit.prevent="actualizarPerfil(user, perfiles)">
                <div class="modal-body">

                  <div class="form-group">
                      <input type="hidden" name="user_id" v-model="user.id" id="user_id"
                      class="form-control">
                      <input type="hidden" name="perfil_id" v-model="perfiles.id" id="perfil_id"
                      class="form-control">
                  </div>


                  <div class="form-group">
                      <label style="color: #000;">Usuario : </label>
                      <input type="text" name="name" v-model="user.name" id="name" placeholder="Ingresa tu Dirección"
                      class="form-control">
                  </div>

                  <div class="form-group">
                      <label style="color: #000;">Apellido : </label>
                      <input type="text" name="apellido" v-model="perfiles.apellido" id="apellido" placeholder="Ingresa tu Apellido"
                      class="form-control">
                  </div>

                  <div class="form-group">
                      <label style="color: #000;">Dirección : </label>
                      <input type="text" name="direccion" v-model="perfiles.direccion" id="direccion" placeholder="Ingresa tu Dirección"
                      class="form-control">
                  </div>

                  <div class="form-group">
                      <label style="color: #000;">Celular : </label>
                      <input type="text" name="celular" v-model="perfiles.celular" id="celular" placeholder="Ingresa tu Numero de Celular"
                      class="form-control">
                  </div>

                </div>



                <div class="modal-footer">
                  <input type="submit" name="submit" id="action" value="Actualizar" class="btn btn-theme02"  />
                  <button type="button" class="btn btn-danger" data-dismiss="modal"  >Close</button>
                </div>

              </form>

              </div>
          </div>
      </div>






    </div>
</template>

<script>
    export default {
      props:['user_id'],
      data(){
        return{
          file: '',
          users:{},
          perfil:{},
          perfiles:{
            id:'',
            apellido:'',
            direccion:'',
            celular:'',
            avatar:''
          },

          user:{
            id:'',
            name:'',
            email:''
          },
          loading: true,


        }
      },

      created(){
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
            this.perfil=res.data.perfiles;
            this.todo = res.data;
            this.loading = false;
          });
        },


        //------Perfil
        showPerfil(item,item1){
            this.user.name = item.name;
            this.user.id = item.id;

            this.perfiles.id = item1.id;
            this.perfiles.apellido = item1.apellido;
            this.perfiles.direccion = item1.direccion;
            this.perfiles.celular = item1.celular;

        },

        actualizarPerfil(item, item1){
            const params = {name: item.name, apellido: item1.apellido, direccion: item1.direccion, celular: item1.celular };
            axios.put(`/users/${item.id}`, params)
            .then((res) => {


               toast.fire({
                 type: 'success',
                 title: 'La información ha sido actualizada..!!!'
               });
                     Fire.$emit('AfterCreate');

            }).catch();

        },


      handleFileUpload(e){
        let fil = e.target.files[0];
        this.file = fil;
      },

      submitFile(item){
            let formData = new FormData();
            formData.append('file', this.file);
            formData.append('id', item.id);
            formData.append('avatar', item.avatar);

            axios.post('/imagenPerfil/',
                formData,
                {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
              }
            ).then((res) => {

               toast.fire({
                 type: 'success',
                 title: 'La Fodo de Perfil ha sido actualizada..!!!'
               });
               Fire.$emit('AfterCreate');

            })
        .catch(function(){
          console.log('FAILURE!!');
        });
      },


      },

    }
</script>
