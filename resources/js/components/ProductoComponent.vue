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
                                Productos
                            </v-chip>
                            <button type="button" class="btn btn-danger waves-effect waves-light" @click="abrirModal('producto','registrar')"><i class="icon-plus mr-2"></i>Nuevo</button>


                        </div>
                        <div class="col-6">
                            <ol class="breadcrumb float-right">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Almacen</a></li>
                                <li class="breadcrumb-item active">Productos</li>
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
                                                @keyup="listarProducto(1,buscar,criterio)"
                                                ></v-select>
                                            </v-flex>
                                            <v-flex xs12 sm8>
                                                <v-text-field
                                                    @keyup="listarProducto(1,buscar,criterio)"
                                                    v-model="buscar"
                                                    label="Buscar"
                                                    clearable
                                                ></v-text-field>
                                            </v-flex>
                                            <v-flex xs12 sm1 >
                                                <v-btn @click="listarProducto(1,buscar,criterio)" depressed large color="primary">
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
                                                <th>Descripcion</th>
                                                <th>Estado</th>
                                                <th>Opciones</th>
                                            </tr>
                                        </thead>


                                        <tbody>

                                            <tr class="table-dar" v-for="producto in arrayProducto" :key="producto.id">
                                                <td v-text="producto.nombre"></td>
                                                <td v-text="producto.descripcion"></td>
                                                <td class="text-center">
                                                    <div v-if="producto.condicion == 1">
                                                        <span class="badge badge-success">Activo</span>
                                                    </div>
                                                    <div v-else>
                                                        <span class="badge badge-danger">Desactivo</span>
                                                    </div>

                                                </td>
                                                <td class="btn-block">

                                                    <button @click="abrirModal('producto','actualizar',producto)" type="button" class="btn btn-warning waves-effect waves-light"><i class="icon-pencil "></i></button>
                                                    <template v-if="producto.condicion">
                                                        <button type="button" class="btn btn-danger waves-effect waves-light" @click="alertaConfirm('Desactivar','¿Seguro que desea Desactivar?','Desactivado', 'desactivar',producto.id)">
                                                            <i class="icon-trash-bin"></i>
                                                        </button>
                                                    </template>
                                                    <template v-else>
                                                        <button type="button" class="btn btn-primary waves-effect waves-light" @click="alertaConfirm('Activar','¿Seguro que desea Activar?','Activado', 'activar',producto.id)">
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
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="cerrarModal()">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body purple lighten-5">
                                    <!-- Cuerpo de mdal -->
                                    <v-container grid-list-xl>
                                            <v-layout wrap>
                                                <v-flex xs12 sm6>
                                                    <v-text-field
                                                        v-model="nombre"
                                                        label="Producto"
                                                        filled
                                                        rounded
                                                    ></v-text-field>
                                                </v-flex>
                                                <v-flex xs12 sm6>
                                                    <v-text-field
                                                        v-model="descripcion"
                                                        label="Descripcion"
                                                        filled
                                                        rounded
                                                    ></v-text-field>
                                                </v-flex>
                                                <v-flex xs12 md-6>
                                                    <div class="modal-footer">
                                                        <button type="button"  class="btn red accent-3 text-white" @click="cerrarModal()">Cerrar</button>
                                                        <button  type="button" v-if="tipoAccion==1" class="btn green accent-4 waves-effect waves-light text-white" @click="registrarProducto(); ">Guardar</button>
                                                        <button type="button" v-if="tipoAccion==2" class="btn green accent-4 waves-effect waves-light text-white" @click="actualizarProducto()">Actualizar</button>
                                                    </div>
                                                </v-flex>
                                                <v-flex xs12 >
                                                    <div v-if="errorProducto">
                                                        <v-alert type="error">

                                                                <div class="text-center py-2" v-for="error in errorMostrarMsjProducto" :key="error" v-text="error">

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
                producto_id : 0,
                nombre: '',
                descripcion:'',
                busqueda: ['nombre','descripcion'],
                arrayProducto:[],
                modal:0,
                tituloModal:0,
                tipoAccion: 1,
                errorProducto : 0,
                errorMostrarMsjProducto : [],
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
                buscar: ''
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
            listarProducto(page, buscar, criterio){

                let me = this;
                let url = me.ruta + '/producto?page='+page+'&buscar='+buscar+'&criterio='+criterio;
                axios.get(url)
                .then(function (response) {
                    var respuesta = response.data;
                    me.arrayProducto=respuesta.productos.data;
                    me.pagination=respuesta.pagination
                    console.log(me.arrayProducto);
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
                me.listarProducto(page, buscar , criterio);
            },
            registrarProducto(){
                let me = this;
                if (me.validarProducto()) {
                    return
                }else{
                    let url = me.ruta + '/producto/registrar';
                    axios.post(url, {
                        nombre: me.nombre,
                        descripcion: me.descripcion
                    })
                    .then(function (response) {
                        me.nombre='';
                        me.descripcion='';
                        console.log(response);
                        me.modal = 0;
                        me.listarProducto(1,'','nombre');
                        me.alerta('success','Registrado con exito');
                    })
                    .catch(function (error) {
                        console.log(error);
                        me.alerta('error','Algo ha fallado en el registro');
                    });
                }
            },
            actualizarProducto(){

                let me = this;
                if (me.validarProducto()) {
                    return
                }else{
                    let url = me.ruta +'/producto/actualizar';
                    axios.put(url, {
                        id:me.producto_id,
                        nombre: me.nombre,
                        descripcion: me.descripcion
                    })
                    .then(function (response) {
                        me.nombre='';
                        me.descripcion='';
                        console.log(response);
                        me.modal=0;
                        me.listarProducto(me.pagination.current_page,me.buscar,'nombre');
                        me.alerta('info','Actualizado con exito');
                    })
                    .catch(function (error) {
                        console.log(error);
                        me.alerta('error','La actualizacion ha fallado');
                    });
                }
            },
            abrirModal(modelo, accion, data=[]){
                switch(modelo){
                    case "producto":{
                        switch (accion) {
                            case "registrar":
                                {
                                    this.modal = 1;
                                    this.tituloModal =  'Registrar Producto'
                                    this.nombre = '';
                                    this.descripcion = '';
                                    this.tipoAccion = 1;
                                    break
                                }
                            case "actualizar":
                                {
                                    this.modal = 1;
                                    this.tituloModal =  'Actualziar Producto';
                                    this.producto_id = data.id;
                                    this.nombre = data.nombre;
                                    this.tipoAccion = 2;
                                    this.descripcion = data.descripcion;
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
                this.descripcion = '';
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
                                    axios.put(me.ruta + '/producto/activar', {
                                        'id' : id
                                    })
                                    .then(function (response) {
                                        me.alerta('success',outText);
                                        me.listarProducto(me.pagination.current_page,me.buscar,'nombre');
                                    })
                                    .catch(function (error) {
                                        console.log(error);
                                        me.alerta('error','Falla al activar el producto');
                                    });
                                    break;

                                case 'desactivar':
                                    axios.put(me.ruta + '/producto/desactivar', {
                                        'id' : id
                                    })
                                    .then(function (response) {
                                        me.alerta('success',outText);
                                        me.listarProducto(me.pagination.current_page,me.buscar,'nombre');
                                    })
                                    .catch(function (error) {
                                        console.log(error);
                                        me.alerta('error','Falla al desactivar el producto');
                                    });
                                    break;

                            }
                        }else{

                            result.dismiss
                        }

                    })
            },
            validarProducto(){
                this.errorProducto = 0;
                this.errorMostrarMsjProducto = [];
                if(!this.nombre) this.errorMostrarMsjProducto.push("El nombre del Producto no puede estar vacio");
                if(this.errorMostrarMsjProducto.length) this.errorProducto = 1;
                return this.errorProducto;
            }
        },
        mounted() {
            this.listarProducto(1,this.buscar,this.criterio);
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
</style>

