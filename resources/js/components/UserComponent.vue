<template>
    <div class="contenido">


                <!-- Page-Title -->
                <div class="pagina-titulo">
                    <div class="row align-items-center">
                        <div class="col-6">


                            <v-chip
                                class="ma-2"
                                color="light-blue darken-4"
                                label
                                text-color="white"
                                >
                                <v-icon left >mdi-arrow-right-thick</v-icon>
                                Users
                            </v-chip>
                            <button type="button" class="btn btn-danger waves-effect waves-light" @click="abrirModal('user','registrar')"><i class="icon-plus mr-2"></i>Nuevo</button>


                        </div>
                        <div class="col-6">
                            <ol class="breadcrumb float-right">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Almacen</a></li>
                                <li class="breadcrumb-item active">Users</li>
                            </ol>
                        </div>
                    </div>
                    <!-- end row -->
                </div>

                <div class="row">

                    <div class="col-12">
                        <div class="card m-b-30">
                            <div class="card-body grey lighten-4 black--text">
                                <div class="form-group row container-fluid">
                                    <div class="input-group">
                                        <v-container fluid grid-list-xl>
                                        <v-layout wrap align-center justify-space-around>
                                            <v-flex xs12 sm2 >
                                                <v-select
                                                v-model="criterio"
                                                :items="busqueda"
                                                label="Criterio"
                                                @keyup="listarUser(1,buscar,criterio)"
                                                ></v-select>
                                            </v-flex>
                                            <v-flex xs12 sm8>
                                                <v-text-field
                                                    @keyup="listarUser(1,buscar,criterio)"
                                                    v-model="buscar"
                                                    label="Buscar"
                                                    clearable
                                                ></v-text-field>
                                            </v-flex>
                                            <v-flex xs12 sm1 >
                                                <v-btn @click="listarUser(1,buscar,criterio)" depressed large color="primary">
                                                    <img width="20em" src="http://innova.deliverygasperu.com/public/images/zoom.svg" alt="" srcset="">


                                                </v-btn>
                                            </v-flex>
                                        </v-layout>
                                        </v-container>
                                    </div>
                                </div>


                                <div class="table-responsive-md ">
                                        <table id="datatable" class="table table-bordered  " >
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Documento</th>
                                                <th>Dirección</th>
                                                <th>Telefono</th>
                                                <th>Email</th>
                                                <th>Usuario</th>
                                                <th>Rol</th>
                                                <th>Estado</th>
                                                <th>Opciones</th>
                                            </tr>
                                        </thead>


                                        <tbody>

                                            <tr class="table-dar" v-for="user in arrayUser" :key="user.id">
                                                <td v-text="user.nombre"></td>
                                                <td v-text="user.tipo_documento + ': ' + user.num_documento "></td>
                                                <td v-text="user.direccion"></td>
                                                <td v-text="user.telefono"></td>
                                                <td v-text="user.email"></td>
                                                <td v-text="user.usuario"></td>
                                                <td v-text="user.rol"></td>
                                                <td class="text-center">
                                                    <div v-if="user.condicion == 1">
                                                        <span class="badge badge-success">Activo</span>
                                                    </div>
                                                    <div v-else>
                                                        <span class="badge badge-danger">Desactivo</span>
                                                    </div>

                                                </td>
                                                <td class="btn-block">

                                                    <button @click="abrirModal('user','actualizar',user)" type="button" class="btn btn-warning waves-effect waves-light"><i class="icon-pencil "></i></button>
                                                    <template v-if="user.condicion=='1'">
                                                        <button type="button" class="btn btn-danger waves-effect waves-light" @click="alertaConfirm('Desactivar','¿Seguro que desea Desactivar?','Desactivado', 'desactivar',user.id)">
                                                            <i class="icon-trash-bin"></i>
                                                        </button>
                                                    </template>
                                                    <template v-else>
                                                        <button type="button" class="btn btn-primary waves-effect waves-light" @click="alertaConfirm('Activar','¿Seguro que desea Activar?','Activado', 'activar',user.id)">
                                                            <i class="icon-check"></i>
                                                        </button>
                                                    </template>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-5">
                                        Mostrando
                                    </div>
                                    <div class="col-sm-12 col-md-7 dataTables_paginate paging_simple_numbers" >
                                        <ul class="pagination">
                                            <li class="paginate_button page-item previous" v-if="pagination.current_page > 1" >
                                                <a href="#" class="page-link" @click.prevent="cambiarPagina(pagination.current_page - 1, buscar, criterio)">
                                                    Anterior
                                                </a>
                                            </li>
                                            <li class="paginate_button page-item active" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active':'']">
                                                <a href="#" class="page-link" @click.prevent="cambiarPagina(page, buscar, criterio)" v-text="page"></a>
                                            </li>
                                            <li class="paginate_button page-item " v-if="pagination.current_page < pagination.last_page">
                                                <a href="#" class="page-link" @click.prevent="cambiarPagina(pagination.current_page + 1, buscar, criterio)">
                                                    Siguiente
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end col -->

                </div> <!-- end row -->


                <!-- El modal  -->
                <div class="modal fade " :class="{'mostrar':modal}" tabindex="-1"  role="dialog" aria-labelledby="newProductModal" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content scroll-modal">
                                <div class="modal-header">
                                    <v-chip
                                        class="ma-2"
                                        color="light-blue darken-4"
                                        label
                                        text-color="white"
                                        >
                                        <v-icon left >mdi-arrow-right-thick</v-icon>
                                        <span v-text="tituloModal"></span>
                                    </v-chip>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="cerrarModal()">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body purple lighten-5">
                                    <!-- Cuerpo de mdal -->
                                    <v-container grid-list-xl>
                                            <v-layout wrap>
                                                <v-flex xs12 sm12 >
                                                    <v-layout wrap>
                                                        <v-flex xs4>
                                                            <v-select
                                                                v-model="tipoDocumento"
                                                                :items="tipoDocumentoItems"
                                                                filled
                                                                rounded
                                                                label="Tipo de documento"
                                                            ></v-select>
                                                        </v-flex>
                                                        <v-flex xs8>
                                                            <v-text-field
                                                                v-model="numeroDocumento"
                                                                label="Número de documento"
                                                                filled
                                                                rounded
                                                            ></v-text-field>
                                                        </v-flex>
                                                    </v-layout>



                                                </v-flex>
                                                <v-flex xs12 sm12>
                                                    <v-text-field
                                                        v-model="nombre"
                                                        label="Nombre Completo(*)"
                                                        filled
                                                        rounded
                                                    ></v-text-field>
                                                </v-flex>
                                                <v-flex xs12 sm6>
                                                    <v-text-field
                                                        v-model="direccion"
                                                        label="Dirección"
                                                        filled
                                                        rounded
                                                    ></v-text-field>
                                                </v-flex>
                                                <v-flex xs12 sm6>
                                                    <v-text-field
                                                        v-model="telefono"
                                                        label="Nro Teléfonico"
                                                        filled
                                                        rounded
                                                    ></v-text-field>
                                                </v-flex>
                                                <v-flex xs12 sm6>
                                                    <v-text-field
                                                        v-model="email"
                                                        label="Email"
                                                        filled
                                                        rounded
                                                        type="email"
                                                    ></v-text-field>
                                                </v-flex>
                                                <v-flex xs12 sm6 >
                                                    <v-select
                                                    v-model="id_rol"
                                                    :items="rolItems"
                                                    item-value='id'
                                                    item-text="nombre"
                                                    label="Rol(*)"
                                                    filled
                                                    rounded
                                                    ></v-select>
                                                </v-flex>
                                                <v-flex xs12 sm6>
                                                    <v-text-field
                                                        v-model="usuario"
                                                        label="Usuario"
                                                        filled
                                                        rounded
                                                    ></v-text-field>
                                                </v-flex>
                                                <v-flex xs12 sm6>
                                                    <v-text-field
                                                        v-model="password"
                                                        label="Contraseña"
                                                        filled
                                                        rounded
                                                    ></v-text-field>
                                                </v-flex>
                                                <v-flex xs12 md-6>
                                                    <div class="modal-footer">
                                                        <button type="button"  class="btn red accent-3 text-white" @click="cerrarModal()">Cerrar</button>
                                                        <button  type="button" v-if="tipoAccion==1" class="btn green accent-4 waves-effect waves-light text-white" @click="registrarUser(); ">Guardar</button>
                                                        <button type="button" v-if="tipoAccion==2" class="btn green accent-4 waves-effect waves-light text-white" @click="actualizarUser()">Actualizar</button>
                                                    </div>
                                                </v-flex>
                                                <v-flex xs12 >
                                                    <div v-if="errorUser">
                                                        <v-alert type="error">

                                                                <div class="text-center py-2" v-for="error in errorMostrarMsjUser" :key="error" v-text="error">

                                                                </div>

                                                        </v-alert>
                                                    </div>

                                                </v-flex>
                                            </v-layout>
                                    </v-container>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->



    </div>


</template>

<script>
    export default {
        props: ['ruta'],
        data(){
            return {
                user_id : 0,
                nombre: '',
                busqueda: ['nombre','num_documento','email','telefono'],
                arrayUser:[],
                modal:0,
                tituloModal:0,
                tipoAccion: 1,
                errorUser : 0,
                errorMostrarMsjUser : [],
                pagination: {
                    'total':0,
                    'current_page':0,
                    'per_page':0,
                    'last_page':0,
                    'from':0,
                    'to':0
                },
                offset:3,
                criterio:'nombre',
                buscar: '',
                tipoDocumentoItems: ['DNI', 'RUC'],
                tipoDocumento: 'DNI',
                rolItems: [
                    {id: 1, nombre: "Administrador"},
                    {id: 2, nombre: "Vendedor"},
                    {id: 3, nombre: "Almacenero"},
                ],
                id_rol: '',
                numeroDocumento: '',
                direccion: '',
                telefono: '',
                email : '',
                usuario: '',
                password: ''

            }
        },
        computed:{
            isActived : function(){
                return this.pagination.current_page;
            },
            // calcula los elemento de la pagination
            pagesNumber : function(){
                if(!this.pagination.to){
                    return [];
                }
                var from = this.pagination.current_page - this.offset;
                if(from<1){
                    from = 1;
                }
                var to = from + (this.offset * 2);
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }
                var pagesArray = [];
                while(from <= to){
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;
            }
        },
        methods : {
            listarUser(page, buscar, criterio){

                let me = this;
                let url = me.ruta + '/user?page='+page+'&buscar='+buscar+'&criterio='+criterio;
                axios.get(url)
                .then(function (response) {
                    var respuesta = response.data;
                    me.arrayUser=respuesta.personas.data;
                    me.pagination=respuesta.pagination
                    console.log(me.arrayUser);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
                .finally(function () {
                    // always executed
                });

            },
            cambiarPagina(page, buscar , criterio){
                let me = this;
                me.pagination.current_page = page;
                me.listarUser(page, buscar , criterio);
            },
            registrarUser(){
                let me = this;
                if (me.validarUser()) {
                    return
                }else{
                    let url = me.ruta + '/user/registrar';
                    axios.post(url, {
                        nombre: me.nombre,
                        tipo_documento: me.tipoDocumento,
                        num_documento: me.numeroDocumento,
                        direccion: me.direccion,
                        telefono: me.telefono,
                        email: me.email,
                        usuario: me.usuario,
                        id_rol: me.id_rol,
                        password: me.password,
                    })
                    .then(function (response) {
                        me.nombre='';
                        me.tipo_documento='';
                        console.log(response);
                        me.modal = 0;
                        me.listarUser(1,'','nombre');
                        me.alerta('success','Registrado con exito');
                    })
                    .catch(function (error) {
                        console.log(error);
                        me.alerta('error','Algo ha fallado en el registro');
                    });
                }
            },
            actualizarUser(){

                let me = this;
                let url = me.ruta + '/user/actualizar';
                if (me.validarUser()) {
                    return
                }else{
                    axios.put(url, {
                        id:me.user_id,
                        nombre: me.nombre,
                        tipo_documento: me.tipoDocumento,
                        num_documento: me.numeroDocumento,
                        direccion: me.direccion,
                        telefono: me.telefono,
                        email: me.email,
                        usuario: me.usuario,
                        id_rol: me.id_rol,
                        password: me.password,

                    })
                    .then(function (response) {
                        me.nombre='';
                        me.tipoDocumento = '';
                        me.numeroDocumento = '';
                        me.direccion = '';
                        me.telefono = '';
                        me.email = '';
                        me.usuario = '';
                        me.id_rol = '';
                        me.password = '';
                        console.log(response);
                        me.modal=0;
                        me.listarUser(me.pagination.current_page,me.buscar,'nombre');
                        me.alerta('info','Actualizado con exito');
                    })
                    .catch(function (error) {
                        console.log(error);
                        me.alerta('error','La actualizacion ha fallado');
                    });
                }
            },
            abrirModal(modelo, accion, data=[]){
                var  me = this;
                switch(modelo){
                    case "user":{
                        switch (accion) {
                            case "registrar":
                                {
                                    me.modal = 1;
                                    me.tituloModal =  'Registrar User'
                                    me.nombre = '';
                                    me.tipo_documento = '';
                                    me.tipoAccion = 1;
                                    break
                                }
                            case "actualizar":
                                {
                                    me.modal = 1;
                                    me.tituloModal =  'Actualziar User';
                                    me.user_id = data.id;
                                    me.nombre =  data.nombre,
                                    me.tipoDocumento =  data.tipo_documento,
                                    me.numeroDocumento =  data.num_documento,
                                    me.direccion =  data.direccion,
                                    me.telefono =  data.telefono,
                                    me.email =  data.email,
                                    me.usuario =  data.usuario,
                                    me.rol =  data.rol,
                                    me.id_rol =  data.id_rol,
                                    me.password =  data.password,
                                    me.tipoAccion = 2;
                                    break
                                }

                        }
                    }
                }
            },
            cerrarModal(){
                this.modal = 0;
                this.tituloModal = '';
                this.nombre = '';
                this.tipo_documento = '';
            },
            eliminar(){
                alertaConfirm(titulo,message,outText)
            },
            alerta(type,message){
                var me = this;
                const Toast = me.$swal.mixin({
                toast: true,
                position: 'bottom-end',
                showConfirmButton: false,
                timer: 2000
                });

                Toast.fire({
                type: type,
                title: message
                })
            },
            alertaConfirm(titulo,message,outText, accion, id){
                var me = this;
                me.$swal.fire({
                    title: titulo,
                    text: message,
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, '+titulo
                    }).then((result) => {
                        if (result.value) {
                            switch (accion) {
                                case 'activar':
                                    axios.put(me.ruta + '/user/activar', {
                                        'id' : id
                                    })
                                    .then(function (response) {
                                        me.alerta('success',outText);
                                        me.listarUser(me.pagination.current_page,me.buscar,'nombre');
                                    })
                                    .catch(function (error) {
                                        console.log(error);
                                        me.alerta('error','Falla al activar el user');
                                    });
                                    break;

                                case 'desactivar':
                                    axios.put(me.ruta + '/user/desactivar', {
                                        'id' : id
                                    })
                                    .then(function (response) {
                                        me.alerta('success',outText);
                                        me.listarUser(me.pagination.current_page,me.buscar,'nombre');
                                    })
                                    .catch(function (error) {
                                        console.log(error);
                                        me.alerta('error','Falla al desactivar el user');
                                    });
                                    break;

                            }
                        }else{

                            result.dismiss
                        }

                    })
            },
            validarUser(){
                this.errorUser = 0;
                this.errorMostrarMsjUser = [];
                if(!this.nombre) this.errorMostrarMsjUser.push("El nombre no puede estar vacio");
                if(this.tipoDocumento == "DNI" && this.numeroDocumento.length != 8) this.errorMostrarMsjUser.push("El DNI DEBE CONTENER 8 DIGITOS");
                if(this.tipoDocumento == "RUC" && this.numeroDocumento.length != 11) this.errorMostrarMsjUser.push("EL RUC DEBE TENER 11 DIGITOS");
                if(!this.id_rol) this.errorMostrarMsjUser.push("El rol no puede estar vacio");
                if(!this.usuario) this.errorMostrarMsjUser.push("El usuario no puede estar vacio");
                if(!this.password) this.errorMostrarMsjUser.push("El password no puede estar vacio");
                if(this.errorMostrarMsjUser.length) this.errorUser = 1;
                return this.errorUser;
            }
        },
        mounted() {
            this.listarUser(1,this.buscar,this.criterio);
            // $().DataTable();
        }
    }
</script>

<style>
    .btn-block{
        /* padding: 0 !important; */
        display: flex !important;
        border: 0 !important;
        justify-content: space-evenly;
        align-items: center;
    }
    .modal-content{
        width: 100% !important;
        position: absolute !important;

    }
    .mostrar{
        display: list-item !important;
        padding-top: 5rem;
        /* height: 100vh !important; */
overflow: hidden;
        opacity: 1 !important;
        position: absolute !important;
        background-color: rgba(0, 0, 0, 0.671) !important;
        /* display: flex !important; */
        /* justify-content: center; */
        /* align-items: center; */
        /* overflow: hidden; */

    }
    .div-error{
        display:flex;
        justify-content: center;
        width:100%;
    }
    .text-error, .text-error *{
        color:red !important;
        font-weight:bold;

    }
    .scroll-modal{
        overflow-y: scroll;
        max-height: 80vh !important;
    }

</style>

