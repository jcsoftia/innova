<template>
            <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">

            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <img width="20rem" src="../../assets/burger.svg" alt=""> Ventas
                        <button type="button" @click="mostrarDetalle()" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                        <button type="button" @click="cargarPdf()" class="btn btn-info">
                            <i class="far fa-file-alt"></i>&nbsp;Reporte
                        </button>
                    </div>
                    <!-- Listado-->
                    <template v-if="listado==1">
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
                                        @keyup="listarVenta(1,buscar,criterio)"
                                        ></v-select>
                                    </v-flex>
                                    <v-flex xs12 sm8>
                                        <v-text-field
                                            @keyup="listarVenta(1,buscar,criterio)"
                                            v-model="buscar"
                                            label="Buscar"
                                            clearable
                                        ></v-text-field>
                                    </v-flex>
                                    <v-flex xs12 sm1 >
                                        <v-btn @click="listarVenta(1,buscar,criterio)" depressed large color="primary">
                                            <img width="20em" src="http://innova.deliverygasperu.com/public/images/zoom.svg" alt="" srcset="">


                                        </v-btn>
                                    </v-flex>
                                </v-layout>
                                </v-container>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered  table-sm">
                                <thead>
                                    <tr>
                                        <th>Opciones</th>
                                        <th>Usuario</th>
                                        <th>Cliente</th>
                                        <th>Tipo Comprobante</th>
                                        <th>Serie Comprobante</th>
                                        <th>Número Comprobante</th>
                                        <th>Fecha Hora</th>
                                        <th>Total</th>
                                        <th>Impuesto</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="venta in arrayVenta" :key="venta.id">
                                        <td>
                                            <button type="button" class="btn btn-success waves-effect waves-light" @click="verVenta(venta.id)" >
                                                <i class="icon-eye"></i>

                                            </button>

                                            <template v-if="venta.tipo_comprobante=='TICKET'">
                                                <button type="button" @click="pdfTicket(venta.id)" class="btn btn-warning ">
                                                <i class="icon-paper-sheet"></i>
                                                </button> &nbsp;
                                            </template>
                                            <template v-else>
                                                <button type="button" @click="pdfVenta(venta.id)" class="btn btn-info waves-effect waves-light ">
                                                <i class="icon-paper-sheet"></i>
                                                </button> &nbsp;
                                            </template>
                                            <template v-if="venta.estado=='Registrado'">
                                                <button type="button" class="btn btn-danger " @click="desactivarVenta(venta.id)">
                                                    <i class="icon-trash-bin"></i>
                                                </button>
                                            </template>
                                        </td>
                                        <td v-text="venta.usuario"></td>
                                        <td v-text="venta.nombre"></td>
                                        <td v-text="venta.tipo_comprobante"></td>
                                        <td v-text="venta.serie_comprobante"></td>
                                        <td v-text="venta.num_comprobante"></td>
                                        <td v-text="venta.fecha_hora"></td>
                                        <td v-text="venta.total"></td>
                                        <td v-text="venta.impuesto"></td>
                                        <td v-text="venta.estado"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    </template>



                    <!--Fin Listado-->
                    <!-- Detalle-->
                    <template v-else-if="listado==0">
                    <div class="card-body grey lighten-4 black--text">
                        <div class="form-group row border pt-5 mt-5">
                                    <v-container fluid grid-list-xl>
                                        <v-layout wrap align-center justify-space-around>
                                            <v-flex xs12 sm7 >
                                                <v-autocomplete

                                                    label='Cliente(*)'
                                                    v-model='cliente'
                                                    :items='arrayCliente'
                                                    item-value='id'
                                                    item-text='nombre'
                                                    placeholder="Buscar Clientes..."
                                                    hide-details
                                                     outlined
                                                    filled
                                                    rounded
                                                    return-object>
                                                </v-autocomplete>
                                            </v-flex>
                                            <v-flex xs12 sm2>
                                                <v-btn

                                                    @click="abrirModalCliente('persona','registrar')"

                                                    class="teal darken-2"
                                                    filled
                                                     outlined
                                                    rounded
                                                    dark
                                                    >  <i class="icon-plus mr-2"></i> Nuevo
                                                </v-btn>

                                            </v-flex>
                                            <v-flex xs12 sm3>
                                                <v-text-field
                                                    v-model="impuesto"
                                                    label="Impuesto"
                                                    filled
                                                    rounded
                                                    hide-details
                                                     outlined
                                                    type="text"
                                                ></v-text-field>
                                            </v-flex>
                                            <v-flex xs12 sm4 >
                                                <v-select
                                                    v-model="tipo_comprobante"
                                                    :items="tipo"
                                                    label="Tipo Comprobante(*)"
                                                    filled
                                                     outlined
                                                    rounded
                                                ></v-select>
                                            </v-flex>
                                            <v-flex xs12 sm4>
                                                <v-text-field
                                                    v-model="serie_comprobante"
                                                    label="Serie Comprobante"
                                                    placeholder="000xx"
                                                    filled
                                                     outlined
                                                    rounded
                                                    value="0001"
                                                    type="text"
                                                ></v-text-field>
                                            </v-flex>
                                            <v-flex xs12 sm4>
                                                <v-text-field
                                                    v-model="num_comprobante"
                                                    label="Número Comprobante(*)"
                                                    placeholder="000xx"
                                                    filled
                                                     outlined
                                                    rounded
                                                    type="text"
                                                ></v-text-field>
                                            </v-flex>

                                        </v-layout>
                                    </v-container>
                            <div class="col-md-12">
                                <div v-show="errorVenta" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjVenta" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-body purple lighten-5">
                            <div class="form-group row container-fluid">
                                <div class="input-group">

                                    <v-container fluid grid-list-xl>
                                        <v-layout wrap align-center justify-space-around>
                                            <v-flex xs12 sm2 >
                                                <v-select
                                                v-model="criterioA"
                                                :items="busqueda"
                                                label="Criterio"
                                                @keyup="listarmedicamento(buscarA,criterioA)"
                                                ></v-select>
                                            </v-flex>
                                            <v-flex xs12 sm8>
                                                <v-text-field
                                                    @keyup="listarmedicamento(buscarA,criterioA)"
                                                    v-model="buscarA"
                                                    label="Buscar"
                                                    clearable
                                                ></v-text-field>
                                            </v-flex>
                                            <v-flex xs12 sm1 >
                                                <v-btn @click="listarmedicamento(buscarA,criterioA)" depressed large color="primary">
                                                    <img width="20em" src="http://innova.deliverygasperu.com/public/images/zoom.svg" alt="" srcset="">
                                                </v-btn>
                                            </v-flex>
                                        </v-layout>
                                    </v-container>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered  table-sm">
                                    <thead>
                                        <tr>
                                            <th>Opciones</th>
                                            <th>Código</th>
                                            <th>Nombre</th>
                                            <th>Precio Venta</th>
                                            <th>Stock</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="medicamento in arraymedicamento" :key="medicamento.id">
                                            <td>
                                                <button type="button" @click="agregarDetalleModal(medicamento)" class="btn btn-success btn-sm">
                                                <i class="icon-check"></i>
                                                </button>
                                            </td>
                                            <td v-text="medicamento.codigo"></td>
                                            <td v-text="medicamento.nombre + ' '+ medicamento.marca + ' ' + medicamento.laboratorio + ' - '+medicamento.presentacion "></td>
                                            <td v-text="medicamento.precio_venta"></td>
                                            <td v-text="medicamento.stock"></td>
                                            <td>
                                                <div v-if="medicamento.condicion">
                                                    <span class="badge badge-success">Activo</span>
                                                </div>
                                                <div v-else>
                                                    <span class="badge badge-danger">Desactivado</span>
                                                </div>

                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="form-group row border">
                            <div class="table-responsive col-md-12">
                                <table class="table table-bordered  table-sm">
                                    <thead>
                                        <tr>
                                            <th>Opciones</th>
                                            <th>Artículo</th>
                                            <th>Precio</th>
                                            <th>Cantidad</th>
                                            <th>Descuento</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="arrayDetalle.length">
                                        <tr v-for="(detalle,index) in arrayDetalle" :key="detalle.id">
                                            <td>
                                                <button @click="eliminarDetalle(index)" type="button" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-times-circle"></i>
                                                </button>
                                            </td>
                                            <td v-text="detalle.medicamento">
                                            </td>
                                            <td>
                                                <input v-model="detalle.precio" type="number" class="form-control" readonly>
                                            </td>
                                            <td>
                                                <span style="color:red !important" v-show="(warnStock(detalle.cantidad,detalle.stock))">Stock: {{detalle.stock}}</span>
                                                <input v-model="detalle.cantidad" type="number" class="form-control" >
                                            </td>
                                            <td>
                                                <span style="color:red;" v-show="detalle.descuento>(detalle.precio*detalle.cantidad)">Descuento superior</span>
                                                <input v-model="detalle.descuento" type="number" class="form-control">
                                            </td>
                                            <td>
                                                {{detalle.precio*detalle.cantidad-detalle.descuento}}
                                            </td>
                                        </tr>
                                        <tr style="background-color: #ddd">
                                            <td colspan="5" align="right"><strong>Total Parcial:</strong></td>
                                            <td>S/ {{totalParcial=(total-totalImpuesto).toFixed(2)}}</td>
                                        </tr>
                                        <tr style="background-color: #ddd">
                                            <td colspan="5" align="right"><strong>Total Impuesto:</strong></td>
                                            <td>S/ {{totalImpuesto=((total*impuesto)/(1+impuesto)).toFixed(2)}}</td>
                                        </tr>
                                        <tr style="background-color: #ddd">
                                            <td colspan="5" align="right"><strong>Total Neto:</strong></td>
                                            <td>S/ {{total=calcularTotal}}</td>
                                        </tr>
                                    </tbody>
                                    <tbody v-else>
                                        <tr>
                                            <td colspan="6">
                                                NO hay artículos agregados
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <button type="button" @click="ocultarDetalle()" class="btn btn-secondary">Cerrar</button>
                                <button type="button" class="btn btn-primary" @click="registrarVenta()">Registrar Venta</button>
                            </div>
                        </div>
                    </div>
                    </template>
                    <!-- Fin Detalle-->
                    <!-- Ver ingreso -->
                    <template v-else-if="listado==2">
                    <div class="card-body grey lighten-4 black--text">
                        <div class="form-group row border">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Cliente</label>
                                    <p v-text="cliente"></p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Fecha</label>
                                    <p v-text="fecha_hora"></p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="">Impuesto</label>
                                <p v-text="impuesto"></p>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tipo Comprobante</label>
                                    <p v-text="tipo_comprobante"></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Serie Comprobante</label>
                                    <p v-text="serie_comprobante"></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Número Comprobante</label>
                                    <p v-text="num_comprobante"></p>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row border">
                            <div class="table-responsive col-md-12">
                                <table class="table table-bordered  table-sm">
                                    <thead>
                                        <tr>
                                            <th>Artículo</th>
                                            <th>Precio</th>
                                            <th>Cantidad</th>
                                            <th>Descuento</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="arrayDetalle.length">
                                        <tr v-for="detalle in arrayDetalle" :key="detalle.id">
                                            <td v-text="detalle.medicamento">
                                            </td>
                                            <td v-text="detalle.precio">
                                            </td>
                                            <td v-text="detalle.cantidad">
                                            </td>
                                            <td v-text="detalle.descuento">
                                            </td>
                                            <td>
                                                {{detalle.precio*detalle.cantidad-detalle.descuento}}
                                            </td>
                                        </tr>
                                        <tr style="background-color: #ddd">
                                            <td colspan="4" align="right"><strong>Total Parcial:</strong></td>
                                            <td>S/ {{totalParcial=(total-totalImpuesto).toFixed(2)}}</td>
                                        </tr>
                                        <tr style="background-color: #ddd">
                                            <td colspan="4" align="right"><strong>Total Impuesto:</strong></td>
                                            <td>S/ {{totalImpuesto=((total*impuesto)).toFixed(2)}}</td>
                                        </tr>
                                        <tr style="background-color: #ddd">
                                            <td colspan="4" align="right"><strong>Total Neto:</strong></td>
                                            <td>S/ {{total}}</td>
                                        </tr>
                                    </tbody>
                                    <tbody v-else>
                                        <tr>
                                            <td colspan="5">
                                                NO hay artículos agregados
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <button type="button" @click="ocultarDetalle()" class="btn btn-secondary">Cerrar</button>

                            </div>
                        </div>
                    </div>
                    </template>
                    <!-- fin ver ingreso -->
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!-- El modal cLIENTE -->
            <div class="modal fade" :class="{'mostrar':modalCliente}" tabindex="-1"  role="dialog" >
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
                            <button type="button" class="close" data-dismiss="modalCliente" aria-label="Close" @click="cerrarModal()">
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

                                        <v-flex xs12 md-6>
                                            <div class="modal-footer">
                                                <button type="button"  class="btn red accent-3 text-white" @click="cerrarModalCliente()">Cerrar</button>
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
        </main>
</template>

<script>
    import vSelect from 'vue-select';
    export default {
        props: ['ruta'],
        props : ['ruta'],
        data (){
            return {
                cliente: {},
                venta_id: 0,
                idcliente:0,
                cliente:'',
                fecha_hora:'',
                tipo_comprobante : 'BOLETA',
                serie_comprobante : '',
                num_comprobante : '',
                impuesto: 0.18,
                total:0.0,
                totalImpuesto: 0.0,
                totalParcial: 0.0,
                arrayVenta : [],
                arrayCliente: [],
                arrayDetalle : [],
                listado:1,
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorVenta : 0,
                errorMostrarMsjVenta : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : '',

                busqueda: ['tipo_comprobante','num_comprobante','nombre'],
                buscar : '',
                criterioA:'nombre',
                buscarA: '',
                arraymedicamento: [],
                idmedicamento: 0,
                codigo: '',
                medicamento: '',
                precio: 0,
                cantidad:1,
                descuento: 0,
                stock:0,
                tipo: ['BOLETA','FACTURA','TICKET'],
                // busqueda: ['codigo','nombre','descripcion'],

                persona_id : 0,
                tipos_doc : ['DNI','RUC'],
                nombre: '',
                tipo_documento:'',
                num_documento:'',
                telefono:'',
                email:'',
                direccion: '',
                modalCliente:0,
                tituloModal:0,
                tipoAccion: 1,
                errorPersona : 0,
                errorMostrarMsjPersona : [],
            }
        },
        components: {

        },
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            //Calcula los elementos de la paginación
            pagesNumber: function() {
                if(!this.pagination.to) {
                    return [];
                }

                var from = this.pagination.current_page - this.offset;
                if(from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2);
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }

                var pagesArray = [];
                while(from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;
            },
            calcularTotal: function(){
                var resultado=0.0;
                for(var i=0;i<this.arrayDetalle.length;i++){
                    resultado=resultado+(this.arrayDetalle[i].precio*this.arrayDetalle[i].cantidad-this.arrayDetalle[i].descuento)
                }
                return resultado;
            }
        },
        methods : {
            listarVenta (page,buscar,criterio){
                let me=this;
                let url = me.ruta +  '/venta?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayVenta = respuesta.ventas.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            cargarPdf(){
                window.open(me.ruta + '/venta/listarPdf','_blank');
            },
            selectCliente(){
                let me=this;
                // loading(true)
                me.arrayCliente = [];
                let url = me.ruta +  '/cliente/selectCliente?';
                axios.get(url).then(function (response) {
                    let respuesta = response.data;
                    // q: search
                    me.arrayCliente=respuesta.clientes;
                    // loading(false)
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            getDatosCliente(val1){
                let me = this;
                me.loading = true;
                me.idcliente = val1.id;
            },
            buscarmedicamento(){
                let me=this;
                let url = me.ruta +  '/medicamento?criterio=codigo&buscar=' + me.codigo;

                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arraymedicamento = respuesta.medicamentos.data;

                    if (me.arraymedicamento.length>0){
                        me.medicamento=me.arraymedicamento[0]['nombre']+me.arraymedicamento[0]['marca']+me.arraymedicamento[0]['presentacion'];
                        me.idmedicamento=me.arraymedicamento[0]['id'];
                        me.precio=me.arraymedicamento[0]['precio_venta'];
                        me.stock=me.arraymedicamento[0]['stock'];
                    }
                    else{
                        me.medicamento='No existe artículo';
                        me.idmedicamento=0;
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            pdfVenta(id){
                window.open(this.ruta + '/venta/pdf/'+ id );
            },
            pdfTicket(id){
                window.open(this.ruta + '/venta/pdfTicket/'+ id );
            },
            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarVenta(page,buscar,criterio);
            },
            encuentra(id){
                var sw=0;
                for(var i=0;i<this.arrayDetalle.length;i++){
                    if(this.arrayDetalle[i].idmedicamento==id){
                        sw=true;
                    }
                }
                return sw;
            },
            eliminarDetalle(index){
                let me = this;
                me.arrayDetalle.splice(index, 1);
            },
            agregarDetalle(){
                let me=this;
                if(me.idmedicamento==0 || me.cantidad==0 || me.precio==0){
                }
                else{
                    if(me.encuentra(me.idmedicamento)){
                        me.$swal({
                            type: 'error',
                            title: 'Error...',
                            text: 'Ese artículo ya se encuentra agregado!',
                            })
                    }
                    else{
                       if(me.cantidad>me.stock){
                           me.$swal({
                            type: 'error',
                            title: 'Error...',
                            text: 'NO hay stock disponible!',
                            })
                       }
                       else{
                           me.arrayDetalle.push({
                                idmedicamento: me.idmedicamento,
                                medicamento: me.medicamento,
                                cantidad: me.cantidad,
                                precio: me.precio,
                                descuento: me.descuento,
                                stock: me.stock
                            });
                            me.codigo="";
                            me.idmedicamento=0;
                            me.medicamento="";
                            me.cantidad=0;
                            me.precio=0;
                            me.descuento=0;
                            me.stock=0
                       }
                    }

                }



            },
            agregarDetalleModal(data =[]){
                let me=this;
                if(me.encuentra(data['id'])){
                        me.$swal({
                            type: 'error',
                            title: 'Error...',
                            text: 'Ese artículo ya se encuentra agregado!',
                            })
                    }
                    else{
                       me.arrayDetalle.push({
                            idmedicamento: data['id'],
                            medicamento: data['nombre'] +' '+ data['marca'] +' '+ data['presentacion'],
                            cantidad: 1,
                            precio: data['precio_venta'],
                            descuento:0,
                            stock:data['stock']
                        });
                    }
            },
            listarmedicamento (buscar,criterio){
                let me=this;
                let url = me.ruta +  '/medicamento?buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arraymedicamento = respuesta.medicamentos.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            registrarVenta(){
                if (this.validarVenta()){
                    return;
                }

                let me = this;
                let url = me.ruta + '/venta/registrar'
                axios.post(url,{
                    'idcliente': this.cliente.id,
                    'tipo_comprobante': this.tipo_comprobante,
                    'serie_comprobante' : this.serie_comprobante,
                    'num_comprobante' : this.num_comprobante,
                    'impuesto' : this.impuesto,
                    'total' : this.total,
                    'data': this.arrayDetalle
                }).then(function (response) {
                    if (me.tipo_comprobante==='TICKET') {

                        window.open(me.ruta + '/venta/pdfTicket/'+ response.data.id);
                    }
                    if (me.tipo_comprobante==='BOLETA' || me.tipo_comprobante === 'FACTURA') {

                        window.open(me.ruta + '/venta/pdf/'+ response.data.id);
                    }
                    me.listado=1;
                    me.listarVenta(1,'','num_comprobante');
                    me.cliente=[];
                    me.tipo_comprobante='BOLETA';
                    me.serie_comprobante='';
                    me.num_comprobante='';
                    me.impuesto=0.18;
                    me.total=0.0;
                    me.idmedicamento=0;
                    me.medicamento='';
                    me.cantidad=0;
                    me.precio=0;
                    me.stock=0;
                    me.codigo='';
                    me.descuento=0;
                    me.arrayDetalle=[];


                }).catch(function (error) {
                    console.log(error);
                });
            },
            validarVenta(){
                let me=this;
                me.errorVenta=0;
                me.errorMostrarMsjVenta =[];
                var art;

                me.arrayDetalle.map(function(x){
                    if (me.warnStock(x.cantidad, x.stock)){
                        art=x.medicamento + " con stock insuficiente";
                        me.errorMostrarMsjVenta.push(art);
                    }
                });
                console.log(me.arrayDetalle)
                if (me.cliente=="") me.errorMostrarMsjVenta.push("Seleccione un Cliente");
                if (me.tipo_comprobante==0) me.errorMostrarMsjVenta.push("Seleccione el comprobante");
                if (!me.num_comprobante) me.errorMostrarMsjVenta.push("Ingrese el número de comprobante");
                if (!me.impuesto) me.errorMostrarMsjVenta.push("Ingrese el impuesto de compra");
                if (me.arrayDetalle.length<=0) me.errorMostrarMsjVenta.push("Ingrese detalles");

                if (me.errorMostrarMsjVenta.length) me.errorVenta = 1;

                return me.errorVenta;
            },
            mostrarDetalle(){
                let me=this;
                me.listado=0;

                me.idproveedor=0;
                me.tipo_comprobante='BOLETA';
                me.serie_comprobante='';
                me.num_comprobante='';
                me.impuesto=0.18;
                me.total=0.0;
                me.idmedicamento=0;
                me.medicamento='';
                me.cantidad=0;
                me.precio=0;
                me.arrayDetalle=[];
            },
            ocultarDetalle(){
                this.listado=1;
            },
            verVenta(id){
                let me=this;
                me.listado=2;

                //Obtener los datos del ingreso
                var arrayVentaT=[];
                let url = me.ruta +  '/venta/obtenerCabecera?id=' + id;

                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    arrayVentaT = respuesta.venta;

                    me.cliente = arrayVentaT[0]['nombre'];
                    me.fecha_hora = arrayVentaT[0]['fecha_hora'];
                    me.tipo_comprobante=arrayVentaT[0]['tipo_comprobante'];
                    me.serie_comprobante=arrayVentaT[0]['serie_comprobante'];
                    me.num_comprobante=arrayVentaT[0]['num_comprobante'];
                    me.impuesto=arrayVentaT[0]['impuesto'];
                    me.total=arrayVentaT[0]['total'];
                })
                .catch(function (error) {
                    console.log(error);
                });

                //Obtener los datos de los detalles
                var urld=  '/venta/obtenerDetalles?id=' + id;

                axios.get(urld).then(function (response) {
                    //console.log(response);
                    var respuesta= response.data;
                    me.arrayDetalle = respuesta.detalles;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
            },
            abrirModal(){
                this.arraymedicamento=[];
                this.modal = 1;
                this.tituloModal = 'Seleccione uno o varios artículos';
            },
            desactivarVenta(id){
                var me = this;
               me.$swal({
                title: 'Esta seguro de anular esta venta?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;
                    let url = me.ruta + '/venta/desactivar';
                    axios.put(url,{
                        'id': id
                    }).then(function (response) {
                        me.listarVenta(1,'','num_comprobante');
                        me.$swal(
                        'Anulado!',
                        'La venta ha sido anulada con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });


                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {

                }
                })
            },
            abrirModalCliente(modelo, accion, data=[]){
                switch(modelo){
                    case "persona":{
                        switch (accion) {
                            case "registrar":
                                {
                                    this.modalCliente = 1;
                                    this.tituloModal =  'Registrar Persona';
                                    this.nombre = '';
                                    this.tipo_documento = '';
                                    this.num_documento = '';
                                    this.telefono = '';
                                    this.email = '';
                                    this.direccion = '';
                                    this.tipoAccion = 1;
                                    break
                                }
                            case "actualizar":
                                {
                                    this.modalCliente = 1;
                                    this.tituloModal = 'Actualzar Persona';
                                    this.persona_id = data.id;
                                    this.nombre = data.nombre;
                                    this.nombre=data.nombre;
                                    this.tipo_documento=data.tipo_documento;
                                    this.num_documento=data.num_documento;
                                    this.telefono=data.telefono;
                                    this.email=data.email;
                                    this.direccion=data.direccion;
                                    this.tipoAccion = 2;
                                    this.descripcion = data.descripcion;
                                    break
                                }

                        }
                    }
                }
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
            },
            registrarPersona(){
                let me = this;
                if (me.validarPersona()) {
                    return
                }else{
                    let url = me.ruta + '/cliente/registrar';
                    axios.post(url, {
                        nombre: me.nombre,
                        tipo_documento : me.tipo_documento,
                        num_documento : me.num_documento,
                        direccion : me.direccion,
                        telefono : me.telefono,
                        email : me.email,

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
                        me.selectCliente()
                        // me.listarPersona(1,'','nombre');
                        me.alerta('success','Registrado con exito');
                        me.modalCliente = 0;
                    })
                    .catch(function (error) {
                        console.log(error);
                        me.alerta('error','Algo ha fallado en el registro');
                        me.alerta('info','Probablemente el DNI ya está registrado');
                    });
                }
            },
            cerrarModalCliente(){
                this.modalCliente = 0;
                this.tituloModal = '';
                this.nombre = '';
                this.tipo_documento = '';
                this.num_documento = '';
                this.telefono = '';
                this.email = '';
                this.direccion = '';
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
            warnStock(cantidad, stock){
                Number(cantidad)
                Number(stock)
                console.log('cantidad=>',cantidad);
                console.log('stock=>',stock);
                if (Number(cantidad)>Number(stock)) {
                    return true
                }
                return false
            },
            warnDescuento(descuento, precio, costo){

                console.log('descuento=>',descuento);
                console.log('precio=>',precio);
                console.log('precio=>',precio);
                if (parseFloat(descuento)>(parseFloat(precio)-parseFloat(costo))) {
                    return true
                }
                return false
            }
        },
        mounted() {
            this.listarVenta(1,this.buscar,this.criterio);
            this.selectCliente();
        }
    }
</script>
<style>
    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a !important;
    }
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }
    @media (min-width: 600px) {
        .btnagregar {
            margin-top: 2rem;
        }
    }

</style>
