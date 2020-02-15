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
                                Medicamentos
                            </v-chip>
                            <button type="button" class="btn btn-danger waves-effect waves-light" @click="abrirModal('medicamento','registrar')"><i class="icon-plus mr-2"></i>Nuevo</button>
                        </div>
                        <div class="col-6">
                            <ol class="breadcrumb float-right">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Gestion</a></li>
                                <li class="breadcrumb-item active">Medicamentos</li>
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
                                                @keyup="listarMedicamento(1,buscar,criterio);listarMedicamentoStock(1,buscar,criterio)"
                                                ></v-select>
                                            </v-flex>
                                            <v-flex xs12 sm8>
                                                <v-text-field
                                                    @keyup="listarMedicamento(1,buscar,criterio);listarMedicamentoStock(1,buscar,criterio)"
                                                    v-model="buscar"
                                                    label="Buscar"
                                                    clearable
                                                ></v-text-field>
                                            </v-flex>
                                            <v-flex xs12 sm1 >
                                                <v-btn @click="listarMedicamento(1,buscar,criterio);listarMedicamentoStock(1,buscar,criterio)" depressed large color="primary">
                                                    <img width="20em" src="http://innova.deliverygasperu.com/public/images/zoom.svg" alt="" srcset="">


                                                </v-btn>
                                            </v-flex>
                                        </v-layout>
                                        </v-container>

                                    </div>
                                </div>



                                        <div class="table-responsive-md table-responsive">
                                                <table id="datatable" class="table table-bordered  " >
                                                <thead>
                                                    <tr>
                                                        <th>Codigo</th>
                                                        <th>Nombre</th>
                                                        <th>marca</th>
                                                        <th>Presentacion</th>
                                                        <th>Laboratorio</th>
                                                        <th>Stock</th>
                                                        <th>Precio Venta</th>
                                                        <th>Estado</th>
                                                        <th>Accion</th>
                                                    </tr>
                                                </thead>


                                                <tbody>

                                                    <tr class="table-dar" v-for="medicamento in arrayMedicamento" :key="medicamento.id">
                                                        <td v-text="medicamento.codigo"></td>
                                                        <td v-text="medicamento.nombre"></td>
                                                        <td v-text="medicamento.marca"></td>
                                                        <td v-text="medicamento.presentacion"></td>
                                                        <td v-text="medicamento.laboratorio"></td>
                                                        <td class="f-high font-weight-bold blue--text" v-text="medicamento.stock"></td>
                                                        <td class="f-high font-weight-bold teal--text" v-text="'S/'+medicamento.precio_venta"></td>
                                                        <td class="text-center">
                                                            <div v-if="medicamento.condicion == 1">
                                                                <span class="badge badge-success">Activo</span>
                                                            </div>
                                                            <div v-else>
                                                                <span class="badge badge-danger">Desactivo</span>
                                                            </div>

                                                        </td>
                                                        <td class="btn-block">

                                                            <button @click="abrirModal('medicamento','actualizar',medicamento)" type="button" class="btn btn-warning waves-effect waves-light"><i class="icon-pencil "></i></button>
                                                            <template v-if="medicamento.condicion">
                                                                <button type="button" class="btn btn-danger waves-effect waves-light" @click="alertaConfirm('Desactivar','¿Seguro que desea Desactivar?','Desactivado', 'desactivar',medicamento.id)">
                                                                    <i class="icon-trash-bin"></i>
                                                                </button>
                                                            </template>
                                                            <template v-else>
                                                                <button type="button" class="btn btn-primary waves-effect waves-light" @click="alertaConfirm('Activar','¿Seguro que desea Activar?','Activado', 'activar',medicamento.id)">
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
                                    <div class="col-12">
                                        <div class="table-responsive-md table-responsive">
                                                <table id="datatable" class="table table-bordered  " >
                                                <thead>
                                                    <tr>
                                                        <th>Lote</th>
                                                        <th>Codigo</th>
                                                        <th>Nombre</th>
                                                        <th>Stock</th>
                                                        <th>Precio</th>
                                                        <th>Laboratorio</th>
                                                        <th>Vencimiento</th>
                                                    </tr>
                                                </thead>


                                                <tbody>

                                                    <tr class="table-dar" v-for="medicamento in arrayMedicamentoStock" :key="medicamento.miID">
                                                        <td v-text="medicamento.lote"></td>
                                                        <td v-text="medicamento.codigo"></td>
                                                        <td v-text="medicamento.nombre + ' ' + medicamento.presentacion"></td>
                                                        <td v-text="medicamento.cantidad"></td>
                                                        <td v-text="medicamento.precio"></td>
                                                        <td v-text="medicamento.laboratorio"></td>
                                                        <td v-text="medicamento.fecha_vencimiento"></td>


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
                                                    <li class="paginate_button page-item previous" v-if="pagination2.current_page > 1" >
                                                        <a href="#" class="page-link" @click.prevent="cambiarPagina2(pagination2.current_page - 1, buscar, criterio)">
                                                            Anterior
                                                        </a>
                                                    </li>
                                                    <li class="paginate_button page-item active" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active':'']">
                                                        <a href="#" class="page-link" @click.prevent="cambiarPagina2(page, buscar, criterio)" v-text="page"></a>
                                                    </li>
                                                    <li class="paginate_button page-item " v-if="pagination2.current_page < pagination2.last_page">
                                                        <a href="#" class="page-link" @click.prevent="cambiarPagina2(pagination2.current_page + 1, buscar, criterio)">
                                                            Siguiente
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
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
                                <div class="modal-body purple lighten-5 purple lighten-5">
                                    <!-- Cuerpo de mdal -->
                                    <v-form>
                                        <v-container grid-list-xl>
                                            <v-layout wrap>
                                                <v-flex xs12 sm6>
                                                    <v-text-field
                                                        v-model="codigo"
                                                        label="Codigo"
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
                                                <v-flex xs12 sm6>
                                                    <v-text-field
                                                        v-model="precio_venta"
                                                        label="Precio"
                                                        type="number"
                                                        :precision="2"
                                                        :step="0.1"
                                                        :min="0"
                                                        filled
                                                        rounded
                                                    ></v-text-field>
                                                </v-flex>
                                                <v-flex xs12 sm6>
                                                    <v-text-field
                                                        v-model="stock"
                                                        label="Stock"
                                                        type="number"
                                                        :precision="2"
                                                        :step="0.1"
                                                        :min="0"
                                                        filled
                                                        rounded
                                                    ></v-text-field>
                                                </v-flex>
                                                <v-flex xs12 sm6>
                                                    <v-autocomplete

                                                        label='Seleccione Producto'
                                                        v-model='producto'
                                                        :filter="activeFilter"
                                                        :items='arrayProducto'
                                                        item-value='id'
                                                        item-text='nombre'
                                                        filled
                                                        rounded
                                                        return-object>
                                                    </v-autocomplete>

                                                </v-flex>
                                                <v-flex xs12 sm6>
                                                    <v-autocomplete
                                                        label='Seleccione Presentacion'
                                                        v-model='presentacion'
                                                        :filter="activeFilter"
                                                        :items='arrayPresentacion'
                                                        item-value='id'
                                                        item-text='nombre'
                                                        filled
                                                        rounded
                                                        return-object>
                                                    ></v-autocomplete>

                                                </v-flex>
                                                <v-flex xs12 sm6>
                                                    <v-autocomplete
                                                        label='Seleccione Laboratorio'
                                                        v-model='laboratorio'
                                                        :filter="activeFilter"
                                                        :items='arrayLaboratorio'
                                                        item-value='id'
                                                        item-text='nombre'
                                                        filled
                                                        rounded
                                                        return-object>
                                                    ></v-autocomplete>
                                                </v-flex>
                                                <v-flex xs12 sm6>
                                                    <v-autocomplete
                                                        label='Seleccione marca'
                                                        v-model='marca'
                                                        :filter="activeFilter"
                                                        :items='arrayMarca'
                                                        item-value='id'
                                                        item-text='nombre'
                                                        filled
                                                        rounded
                                                        return-object>
                                                    ></v-autocomplete>

                                                </v-flex>

                                                <v-flex xs12 md-6>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn red accent-3 text-white" @click="cerrarModal()">Cerrar</button>
                                                        <button  type="button" v-if="tipoAccion==1" class="btn green accent-4 waves-effect waves-light" @click="registrarMedicamento(); ">Guardar</button>
                                                        <button type="button" v-if="tipoAccion==2" class="btn green accent-4 waves-effect waves-light" @click="actualizarMedicamento()">Actualizar</button>
                                                    </div>
                                                </v-flex>
                                                <v-flex xs12 >
                                                    <div v-if="errorMedicamento">
                                                        <v-alert type="error">

                                                                <div class="text-center py-2" v-for="error in errorMostrarMsjMedicamento" :key="error" v-text="error">

                                                                </div>

                                                        </v-alert>
                                                    </div>

                                                </v-flex>
                                            </v-layout>

                                        </v-container>
                                    </v-form>

                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->



    </div>


</template>

<script>
    // import Vuetify from 'vuetify';
    // Vue.use(Vuetify);
    export default {
        props: ['ruta'],

        data(){
            return {
                model: null,
                medicamento_id : 0,
                codigo: '',
                nombre: '',
                busqueda: ['codigo','nombre','descripcion'],
                precio_venta: 0.0,
                producto: {},
                marca: {},
                presentacion: {},
                laboratorio: {},
                descripcion: {},
                arrayMedicamento:[],
                arrayMedicamentoStock:[],
                arrayPresentacion:[],
                arrayMarca:[],
                arrayLaboratorio:[],
                arrayProducto:[],
                modal:0,
                tituloModal:0,
                tipoAccion: 1,
                errorMedicamento : 0,
                errorMostrarMsjMedicamento : [],
                arrayCodigo : [],
                pagination: {
                    'total':0,
                    'current_page':0,
                    'per_page':0,
                    'last_page':0,
                    'from':0,
                    'to':0
                },
                pagination2: {
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
                buscarStock: '',
                stock: 0
            }
        },
        computed:{
            activeFilter (array = []) {
                if (this.model == null) return undefined
                return array[this.model].fn
            },
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
            listarMedicamento(page, buscar, criterio){

                let me = this;
                let url = me.ruta + '/medicamento?page='+page+'&buscar='+buscar+'&criterio='+criterio;
                axios.get(url)
                .then(function (response) {
                    var respuesta = response.data;
                    me.arrayMedicamento=respuesta.medicamentos.data;
                    me.pagination=respuesta.pagination
                    console.log(me.arrayMedicamento);

                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
                .finally(function () {
                    // always executed
                });

            },
            listarMedicamentoStock(page, buscar, criterio){

                let me = this;
                let url = me.ruta + '/medicamento/indexStock?page='+page+'&buscar='+buscar+'&criterio='+criterio;
                axios.get(url)
                .then(function (response) {
                    var respuesta = response.data;
                    me.arrayMedicamentoStock=respuesta.medicamentos.data;
                    me.pagination2=respuesta.pagination
                    // console.log(me.arrayMedicamento);

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
                me.listarMedicamento(page, buscar , criterio);
            },
            cambiarPagina2(page, buscar , criterio){
                let me = this;
                me.pagination2.current_page = page;
                me.listarMedicamentoStock(page, buscar , criterio);
            },
            registrarMedicamento(){
                let me = this;
                me.nombre=me.producto.nombre;
                if (me.validarMedicamento()) {
                    return
                }else{
                    let url = me.ruta + '/medicamento/registrar';
                    console.log(me.producto.id,
                        me.presentacion.id,
                        me.marca.id,
                        me.laboratorio.id,);
                    axios.post(url, {
                        codigo: me.codigo,
                        precio: parseFloat(me.precio_venta),
                        descripcion: me.descripcion,
                        producto_id: me.producto.id,
                        presentacion_id: me.presentacion.id,
                        concentracion_id: me.marca.id,
                        laboratorio_id: me.laboratorio.id,
                    })
                    .then(function (response) {
                        me.nombre='';
                        me.descripcion='';
                        console.log(response);
                        me.modal = 0;
                        me.listarMedicamento(1,'','nombre');
                        me.alerta('success','Registrado con exito');
                    })
                    .catch(function (error) {
                        console.log(error);
                        me.alerta('error','Algo ha fallado en el registro');
                    });
                }
            },
            actualizarMedicamento(){

                let me = this;
                if (me.validarMedicamento()) {
                    return
                }else{
                    let url = me.ruta + '/medicamento/actualizar';
                    axios.put(url, {
                        id:me.medicamento_id,
                        codigo: me.codigo,
                        precio: parseFloat(me.precio_venta),
                        descripcion: me.descripcion,
                        producto_id: me.producto.id,
                        presentacion_id: me.presentacion.id,
                        concentracion_id: me.marca.id,
                        laboratorio_id: me.laboratorio.id,
                        stock: me.stock
                    })
                    .then(function (response) {
                        me.nombre='';
                        me.descripcion='';
                        console.log(response);
                        me.modal=0;
                        me.listarMedicamento(me.pagination.current_page,me.buscar,'nombre');
                        me.alerta('info','Actualizado con exito');
                    })
                    .catch(function (error) {
                        console.log(error);
                        me.alerta('error','La actualizacion ha fallado');
                    });
                }
            },
            abrirModal(modelo, accion, data=[]){
                let me = this;
                me.selectMedic();
                me.selectProducto();
                me.selectPresentacion();
                me.selectMarca();
                me.selectLaboratorio();
                for (let i = 0; i < me.arrayMedicamento.length; i++) {
                    // const element = array[i];

                    me.arrayCodigo.push(me.arrayMedicamento[i].codigo);
                }
                switch(modelo){
                    case "medicamento":{
                        switch (accion) {
                            case "registrar":
                                {
                                    me.modal = 1;
                                    me.tituloModal =  'Registrar Medicamento'
                                    me.nombre = '';
                                    me.descripcion = '';
                                    me.tipoAccion = 1;
                                    me.codigo = '';
                                    me.precio_venta = 0.0;
                                    me.descripcion = '';
                                    me.producto = {};
                                    me.presentacion = {};
                                    me.marca = {};
                                    me.laboratorio = {};
                                    break
                                }
                            case "actualizar":
                                {
                                    me.modal = 1;
                                    me.tituloModal =  'Actualizar Medicamento';
                                    me.medicamento_id = data.id;
                                    me.nombre = data.nombre;
                                    me.tipoAccion = 2;
                                    me.descripcion = data.descripcion;
                                    me.codigo = data.codigo;
                                    me.precio_venta = data.precio_venta;
                                    me.producto = {'id':data.producto_id, 'nombre':data.producto};
                                    me.presentacion = {'id':data.presentacion_id, 'nombre':data.presentacion};
                                    me.marca = {'id':data.concentracion_id, 'nombre':data.marca};
                                    me.laboratorio = {'id':data.laboratorio_id, 'nombre':data.laboratorio};
                                    me.stock = data.stock;
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
                                    axios.put( me.ruta+'/medicamento/activar', {
                                        'id' : id
                                    })
                                    .then(function (response) {
                                        me.alerta('success',outText);
                                        me.listarMedicamento(me.pagination.current_page,me.buscar,'nombre');
                                    })
                                    .catch(function (error) {
                                        console.log(error);
                                        me.alerta('error','Falla al activar el medicamento');
                                    });
                                    break;

                                case 'desactivar':
                                    axios.put( me.ruta+'/medicamento/desactivar', {
                                        'id' : id
                                    })
                                    .then(function (response) {
                                        me.alerta('success',outText);
                                        me.listarMedicamento(me.pagination.current_page,me.buscar,'nombre');
                                    })
                                    .catch(function (error) {
                                        console.log(me.ruta);
                                        console.log(error);
                                        me.alerta('error','Falla al desactivar el medicamento');
                                    });
                                    break;

                            }
                        }else{

                            result.dismiss
                        }

                    })
            },
            validarMedicamento(){
                this.errorMedicamento = 0;
                this.errorMostrarMsjMedicamento = [];
                if(!this.codigo) this.errorMostrarMsjMedicamento.push("El codigo del Medicamento no puede estar vacio");
                if(!this.nombre) this.errorMostrarMsjMedicamento.push("El nombre del Producto no puede estar vacio");
                if(!this.precio_venta) this.errorMostrarMsjMedicamento.push("El precio del Medicamento debe ser mayor a cero");
                if(!this.presentacion.id) this.errorMostrarMsjMedicamento.push("La presentacion del Medicamento no puede estar vacio");
                if(!this.laboratorio.id) this.errorMostrarMsjMedicamento.push("El laboratorio del Medicamento no puede estar vacio");
                if(!this.marca.id) this.errorMostrarMsjMedicamento.push("La marca del Medicamento no puede estar vacio");
                if(this.errorMostrarMsjMedicamento.length) this.errorMedicamento = 1;
                return this.errorMedicamento;
            },
            selectPresentacion(){
                let me=this;
                me.arrayPresentacion = [];
                let url = me.ruta + '/presentacion/getAll';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    console.log('aqui abajo');
                    console.log(respuesta);
                    for (let i = 0; i < respuesta.length; i++) {

                        me.arrayPresentacion.push({'id':respuesta[i].id, 'nombre':respuesta[i].nombre});
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectProducto(){
                let me=this;
                me.arrayProducto = [];
                let url = me.ruta + '/producto/getAll';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    for (let i = 0; i < respuesta.length; i++) {

                        me.arrayProducto.push({'id':respuesta[i].id, 'nombre':respuesta[i].nombre});
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectMarca(){
                let me=this;
                me.arrayMarca=[];
                let url = me.ruta + '/marca/getAll';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    for (let i = 0; i < respuesta.length; i++) {

                        me.arrayMarca.push({'id':respuesta[i].id, 'nombre':respuesta[i].nombre});
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectLaboratorio(){
                let me=this;
                me.arrayLaboratorio=[];
                let url = me.ruta + '/laboratorio/getAll';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    for (let i = 0; i < respuesta.length; i++) {
                        me.arrayLaboratorio.push({'id':respuesta[i].id, 'nombre':respuesta[i].nombre});
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectMedic(){
                let me=this;
                me.arrayMedic = [];
                let url = me.ruta + '/producto/getAll';
                axios.get(url).then(function (response) {
                    console.log(response.data);
                    let respuesta = response.data;
                    // me.arrayMedic=respuesta.medicamentos.data;
                    console.log(me.arrayMedic);
                })
                .catch(function (error) {
                    console.log(error);
                });
            }
        },
        mounted() {
            this.listarMedicamento(1,this.buscar,this.criterio);
            this.listarMedicamentoStock(1,this.buscar,this.criterio)
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
    .f-high{
        font-size: 1.25rem;
    }
</style>

