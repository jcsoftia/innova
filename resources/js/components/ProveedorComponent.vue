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
                                Personas
                            </v-chip>
                            <button type="button" class="btn btn-danger waves-effect waves-light" @click="abrirModal('persona','registrar')"><i class="icon-plus mr-2"></i>Nuevo</button>


                        </div>
                        <div class="col-6">
                            <ol class="breadcrumb float-right">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Ventas</a></li>
                                <li class="breadcrumb-item active">Proveedores</li>
                            </ol>
                        </div>
                    </div>
                    <!-- end row -->
                </div>

                <div class="row">

                    <div class="col-12">
                        <div class="card m-b-30">
                            <div class="card-body grey lighten-4 black--text ">
                                <div class="form-group row container-fluid">
                                    <div class="input-group">
                                        <v-container fluid grid-list-xl>
                                        <v-layout wrap align-center justify-space-around>
                                            <v-flex xs12 sm2 >
                                                <v-select
                                                v-model="criterio"
                                                :items="busqueda"
                                                label="Criterio"
                                                @keyup="listarPersona(1,buscar,criterio)"
                                                ></v-select>
                                            </v-flex>
                                            <v-flex xs12 sm8>
                                                <v-text-field
                                                    @keyup="listarPersona(1,buscar,criterio)"
                                                    v-model="buscar"
                                                    label="Buscar"
                                                    clearable
                                                ></v-text-field>
                                            </v-flex>
                                            <v-flex xs12 sm1 >
                                                <v-btn @click="listarPersona(1,buscar,criterio)" depressed large color="primary">
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
                                                <th>Tipo y Nro de Documento</th>
                                                <th>Dirección</th>
                                                <th>Teléfono</th>
                                                <th>Email</th>
                                                <th>Contacto</th>
                                                <th>Opciones</th>
                                            </tr>
                                        </thead>


                                        <tbody>

                                            <tr class="table-dar" v-for="persona in arrayPersona" :key="persona.id">
                                                <td v-text="persona.nombre"></td>
                                                <td v-text="persona.tipo_documento + ': ' + persona.num_documento "></td>
                                                <td v-text="persona.direccion"></td>
                                                <td v-text="persona.telefono"></td>
                                                <td v-text="persona.email"></td>
                                                <td v-text="persona.contacto"></td>

                                                <td class="btn-block">

                                                    <button @click="abrirModal('persona','actualizar',persona)" type="button" class="btn btn-warning waves-effect waves-light"><i class="icon-pencil "></i></button>
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
                <div class="modal fade" :class="{'mostrar':modal}" tabindex="-1"  role="dialog" aria-labelledby="newProductModal" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
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
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="cerrarModal">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body purple lighten-5">
                                    <!-- Cuerpo de mdal -->
                                    <v-container grid-list-xl>
                                            <v-layout wrap>
                                                <v-flex xs12 sm12 >
                                                    <v-layout wrap>
                                                        <v-flex sm4>
                                                            <v-select
                                                                v-model="tipo_documento"
                                                                :items="tipos_doc"
                                                                filled
                                                                rounded
                                                                label="Tipo de documento"
                                                            ></v-select>
                                                        </v-flex>
                                                        <v-flex sm8>
                                                            <v-text-field
                                                                v-model="num_documento"
                                                                label="Número de documento"
                                                                type="number"
                                                                filled
                                                                rounded
                                                            ></v-text-field>
                                                        </v-flex>
                                                    </v-layout>



                                                </v-flex>
                                                <v-flex xs12 sm12>
                                                    <v-text-field
                                                        v-model="nombre"
                                                        label="Nombre Proveedor(*)"
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
                                                        v-model="email"
                                                        label="Email"
                                                        filled
                                                        rounded
                                                    ></v-text-field>
                                                </v-flex>
                                                <v-flex xs12 sm6>
                                                    <v-text-field
                                                        v-model="telefono"
                                                        label="Teléfono"
                                                        filled
                                                        rounded
                                                        type="number"
                                                    ></v-text-field>
                                                </v-flex>
                                                <v-flex xs12 sm6>
                                                    <v-text-field
                                                        v-model="contacto"
                                                        label="Nombre del Contacto"
                                                        filled
                                                        rounded
                                                        type="text"
                                                    ></v-text-field>
                                                </v-flex>
                                                <v-flex xs12 sm6>
                                                    <v-text-field
                                                        v-model="telefono_contacto"
                                                        label="Telefono del Contacto"
                                                        filled
                                                        rounded
                                                        type="number"
                                                    ></v-text-field>
                                                </v-flex>

                                                <v-flex xs12 md-6>
                                                    <div class="modal-footer">
                                                        <button type="button"  class="btn red accent-3 text-white" @click="cerrarModal()">Cerrar</button>
                                                        <button  type="button" v-if="tipoAccion==1" class="btn green accent-4 waves-effect waves-light text-white" @click="registrarPersona(); ">Guardar</button>
                                                        <button type="button" v-if="tipoAccion==2" class="btn green accent-4 waves-effect waves-light text-white" @click="actualizarPersona()">Actualizar</button>
                                                    </div>
                                                </v-flex>
                                                <v-flex xs12 >
                                                    <div v-if="errorPersona">
                                                        <v-alert type="error">

                                                                <div class="text-center py-2" v-for="error in errorMostrarMsjPersona" :key="error" v-text="error">

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
                persona_id : 0,
                tipos_doc : ['DNI','RUC'],
                nombre: '',
                tipo_documento:'',
                num_documento:'',
                telefono:'',
                email:'',
                direccion: '',
                busqueda: ['nombre','num_documento','telefono'],
                arrayPersona:[],
                modal:0,
                tituloModal:0,
                tipoAccion: 1,
                errorPersona : 0,
                errorMostrarMsjPersona : [],
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
                contacto: '',
                telefono_contacto:''
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
            listarPersona(page, buscar, criterio){

                let me = this;
                let url = me.ruta + '/proveedor?page='+page+'&buscar='+buscar+'&criterio='+criterio;
                axios.get(url)
                .then(function (response) {
                    var respuesta = response.data;
                    me.arrayPersona=respuesta.personas.data;
                    me.pagination=respuesta.pagination
                    console.log(me.arrayPersona);
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
                me.listarPersona(page, buscar , criterio);
            },
            registrarPersona(){
                let me = this;
                if (me.validarPersona()) {
                    return
                }else{
                    let url = me.ruta + '/proveedor/registrar';
                    axios.post(url, {
                        nombre: me.nombre,
                        tipo_documento : me.tipo_documento,
                        num_documento : me.num_documento,
                        direccion : me.direccion,
                        telefono : me.telefono,
                        email : me.email,
                        contacto : me.contacto,
                        telefono_contacto : me.telefono_contacto,
                    })
                    .then(function (response) {
                        me.nombre='';
                        me.tipo_documento='';
                        me.num_documento='';
                        me.telefono='';
                        me.email='';
                        me.direccion='';
                        console.log(response);
                        me.modal = 0;
                        me.contacto = '';
                        me.telefono_contacto = '';
                        me.listarPersona(1,'','nombre');
                        me.alerta('success','Registrado con exito');
                    })
                    .catch(function (error) {
                        console.log(error);
                        me.alerta('error','Algo ha fallado en el registro');
                        me.alerta('info','Probablemente el DNI ya está registrado');
                    });
                }
            },
            actualizarPersona(){
                let me = this;
                if (me.validarPersona()) {
                    return
                }else{
                    let url = me.ruta + '/proveedor/actualizar';
                    axios.put(url, {
                        id:me.persona_id,
                        nombre: me.nombre,
                        tipo_documento : me.tipo_documento,
                        num_documento : me.num_documento,
                        telefono : me.telefono,
                        email : me.email,
                        direccion : me.direccion,
                        contacto : me.contacto,
                        telefono_contacto : me.telefono_contacto
                    })
                    .then(function (response) {
                        me.nombre='';
                        me.tipo_documento='';
                        me.num_documento='';
                        me.telefono='';
                        me.email='';
                        me.direccion = ''
                        console.log(response);
                        me.contacto = '';
                        me.telefono_contacto = '';
                        me.modal=0;
                        me.listarPersona(me.pagination.current_page,me.buscar,'nombre');
                        me.alerta('info','Actualizado con éxito');

                    })
                    .catch(function (error) {
                        // console.log(error);
                        me.alerta('error','La actualizacion ha fallado');
                        me.alerta('info','Probablemente el DNI ya está registrado');
                    });
                }
            },
            abrirModal(modelo, accion, data=[]){
                var me = this;
                switch(modelo){
                    case "persona":{
                        switch (accion) {
                            case "registrar":
                                {
                                    me.modal = 1;
                                    me.tituloModal =  'Registrar Proveedor';
                                    me.nombre = '';
                                    me.tipo_documento = '';
                                    me.num_documento = '';
                                    me.telefono = '';
                                    me.email = '';
                                    me.direccion = '';
                                    me.tipoAccion = 1;
                                    break
                                }
                            case "actualizar":
                                {
                                    me.modal = 1;
                                    me.tituloModal = 'Actualzar Proveedor';
                                    me.persona_id = data.id;
                                    me.nombre = data.nombre;
                                    me.nombre=data.nombre;
                                    me.tipo_documento=data.tipo_documento;
                                    me.num_documento=data.num_documento;
                                    me.telefono=data.telefono;
                                    me.email=data.email;
                                    me.direccion=data.direccion;
                                    me.contacto=data.contacto;
                                    me.telefono_contacto=data.telefono_contacto;
                                    me.tipoAccion = 2;
                                    me.descripcion = data.descripcion;
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
                this.num_documento = '';
                this.telefono = '';
                this.email = '';
                this.direccion = '';
                this.contacto = '';
                this.telefono_contacto = '';
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
                                    axios.put(me.ruta + '/proveedor/activar', {
                                        'id' : id
                                    })
                                    .then(function (response) {
                                        me.alerta('success',outText);
                                        me.listarPersona(me.pagination.current_page,me.buscar,'nombre');
                                    })
                                    .catch(function (error) {
                                        console.log(error);
                                        me.alerta('error','Falla al activar el persona');
                                    });
                                    break;

                                case 'desactivar':
                                    axios.put(me.ruta + '/proveedor/desactivar', {
                                        'id' : id
                                    })
                                    .then(function (response) {
                                        me.alerta('success',outText);
                                        me.listarPersona(me.pagination.current_page,me.buscar,'nombre');
                                    })
                                    .catch(function (error) {
                                        console.log(error);
                                        me.alerta('error','Falla al desactivar el proveedor');
                                    });
                                    break;

                            }
                        }else{

                            result.dismiss
                        }

                    })
            },
            validarPersona(){
                this.errorPersona = 0;
                this.errorMostrarMsjPersona = [];
                if(!this.nombre) this.errorMostrarMsjPersona.push("El nombre del proveedor no puede estar vacio");
                if(this.tipo_documento == "") this.errorMostrarMsjPersona.push("Seleccione Documento");
                if(this.tipo_documento == "DNI" && this.num_documento.length != 8) this.errorMostrarMsjPersona.push("El DNI debe tener 8 digitos");
                if(this.tipo_documento == "RUC" && this.num_documento.length != 11) this.errorMostrarMsjPersona.push("El RUC debe tener 11 digitos");
                if(this.errorMostrarMsjPersona.length) this.errorPersona = 1;
                return this.errorPersona;
            }
        },
        mounted() {
            this.listarPersona(1,this.buscar,this.criterio);
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
        overflow-y: scroll !important;
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
    .text-error{
        color:red !important;
        font-weight:bold;

    }
</style>
