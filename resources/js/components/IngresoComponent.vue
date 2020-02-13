<template>
            <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">

            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="c           ard">
                    <div class="card-header">
                        <img width="20rem" src="../../assets/burger.svg" alt=""> Ingresos
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
                        <!-- <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control " v-model="criterio">
                                      <option value="tipo_comprobante">Tipo Comprobante</option>
                                      <option value="num_comprobante">Número Comprobante</option>
                                      <option value="fecha_hora">Fecha-Hora</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarIngreso(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarIngreso(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div> -->
                        <div class="form-group row container-fluid">
                            <div class="input-group">
                                <v-container fluid grid-list-xl>
                                <v-layout wrap align-center justify-space-around>
                                    <v-flex xs12 sm2 >
                                        <v-select
                                        v-model="criterio"
                                        :items="busqueda"
                                        label="Criterio"
                                        @keyup="listarIngreso(1,buscar,criterio)"
                                        ></v-select>
                                    </v-flex>
                                    <v-flex xs12 sm8>
                                        <v-text-field
                                            @keyup="listarIngreso(1,buscar,criterio)"
                                            v-model="buscar"
                                            label="Buscar"
                                            clearable
                                        ></v-text-field>
                                    </v-flex>
                                    <v-flex xs12 sm1 >
                                        <v-btn @click="listarIngreso(1,buscar,criterio)" depressed large color="primary">
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
                                        <th>Proveedor</th>
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
                                    <tr v-for="ingreso in arrayIngreso" :key="ingreso.id">
                                        <td>
                                            <button type="button" @click="verIngreso(ingreso.id)" class="btn btn-success btn-sm">
                                            <i class="icon-eye"></i>
                                            </button> &nbsp;
                                            <template v-if="ingreso.tipo_comprobante=='TICKET'">
                                                <button type="button" @click="pdfTicket(ingreso.id)" class="btn btn-warning btn-sm">
                                                <i class="far fa-file-alt"></i>
                                                </button> &nbsp;
                                            </template>
                                            <template v-else>
                                                <button type="button" @click="pdfIngreso(ingreso.id)" class="btn btn-info btn-sm">
                                                <i class="far fa-file-alt"></i>
                                                </button> &nbsp;
                                            </template>
                                            <template v-if="ingreso.estado=='Registrado'">
                                                <button type="button" class="btn btn-danger btn-sm" @click="desactivarIngreso(ingreso.id)">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </template>
                                        </td>
                                        <td v-text="ingreso.usuario"></td>
                                        <td v-text="ingreso.nombre"></td>
                                        <td v-text="ingreso.tipo_comprobante"></td>
                                        <td v-text="ingreso.serie_comprobante"></td>
                                        <td v-text="ingreso.num_comprobante"></td>
                                        <td v-text="ingreso.fecha_hora"></td>
                                        <td v-text="ingreso.total"></td>
                                        <td v-text="ingreso.impuesto"></td>
                                        <td v-text="ingreso.estado"></td>
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
                        <div class="form-group row border">
                                    <v-container fluid grid-list-xl>
                                        <v-layout wrap align-center justify-space-around>
                                            <v-flex xs12 sm9 >
                                                <v-autocomplete

                                                        label='Proveedor(*)'
                                                        v-model='proveedor'
                                                        :items='arrayProveedor'
                                                        item-value='id'
                                                        item-text='nombre'
                                                        placeholder="Buscar Proveedors..."


                                                        filled
                                                        rounded
                                                        return-object>
                                                    </v-autocomplete>
                                            </v-flex>
                                            <v-flex xs12 sm3>
                                                <v-text-field
                                                    v-model="impuesto"
                                                    label="Impuesto"
                                                    filled
                                                    rounded
                                                    type="text"
                                                ></v-text-field>
                                            </v-flex>
                                            <v-flex xs12 sm4 >
                                                <v-select
                                                    v-model="tipo_comprobante"
                                                    :items="tipo"
                                                    label="Tipo Comprobante(*)"
                                                    filled
                                                    rounded
                                                ></v-select>
                                            </v-flex>
                                            <v-flex xs12 sm4>
                                                <v-text-field
                                                    v-model="serie_comprobante"
                                                    label="Serie Comprobante"
                                                    placeholder="000xx"
                                                    filled
                                                    rounded
                                                    type="text"
                                                ></v-text-field>
                                            </v-flex>
                                            <v-flex xs12 sm4>
                                                <v-text-field
                                                    v-model="num_comprobante"
                                                    label="Número Comprobante(*)"
                                                    placeholder="000xx"
                                                    filled
                                                    rounded
                                                    type="text"
                                                ></v-text-field>
                                            </v-flex>
                                            <!-- <v-flex xs12 sm4>
                                                <v-text-field
                                                    v-model="lote"
                                                    label="Lote(*)"
                                                    placeholder="000xx"
                                                    filled
                                                    rounded
                                                    type="text"
                                                ></v-text-field>
                                            </v-flex> -->

                                        </v-layout>
                                    </v-container>

                        </div>
                        <div class="form-group row border">

                            <div class="col-md-12">
                                <div v-show="errorIngreso" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjIngreso" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--div class="col-md-2">
                                <div class="form-group">
                                    <button @click="agregarDetalle()" class="btn btn-success form-control btnagregar"><i class="icon-plus"></i></button>
                                </div>
                            </div-->
                            <div class="ingreso">
                                <div class="">
                                    <h4 class="modal-title" v-text="tituloModal"></h4>
                                    <!--button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                    </button-->
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
                                                <th>Precio Venta Actual</th>

                                                <th>Stock</th>
                                                <th>Estado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="med in arraymedicamento" :key="med.id">
                                                <td>
                                                    <button type="button" @click="agregarDetalleModal(med)" class="btn btn-success btn-sm">
                                                    <i class="icon-check"></i>
                                                    </button>
                                                </td>
                                                <td v-text="med.codigo"></td>
                                                <td v-text="med.nombre + ' '+ med.marca + ' '+med.presentacion"></td>
                                                <td v-text="med.precio_venta"></td>
                                                <td v-text="med.stock"></td>
                                                <td>
                                                    <div v-if="med.condicion">
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
                        </div>
                        </div>
                        <div class="form-group row border">
                            <div class="table-responsive col-md-12">
                                <table class="table table-bordered  table-sm">
                                    <thead>
                                        <tr>
                                            <th>Opciones</th>
                                            <th>Medicamento</th>
                                            <th>Precio Venta</th>
                                            <th>Costo</th>
                                            <th>Cantidad</th>
                                            <th>Lote</th>
                                            <th>Vencimiento</th>
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
                                                <input v-model="detalle.precio" type="number" style="width: 4.5rem;"  class="form-control">
                                            </td>
                                            <td>
                                                <input v-model="detalle.costo" type="number" style="width: 4.5rem;"  class="form-control">
                                            </td>
                                            <td>
                                                <input v-model="detalle.cantidad" type="number" style="width: 4.5rem;" class="form-control">
                                            </td>
                                            <td >
                                                <input v-model="detalle.lote" type="text" style="width: 9rem;" class="form-control">
                                            </td>
                                            <td>
                                                <input v-model="detalle.fecha_vencimiento" type="date" class="form-control">
                                            </td>
                                            <td>
                                                <span style="color:red;" v-show="detalle.descuento>(detalle.costo*detalle.cantidad)">Descuento superior</span>
                                                <input v-model="detalle.descuento" type="number" style="width: 8rem;" class="form-control">
                                            </td>
                                            <td>
                                                {{(detalle.costo*detalle.cantidad-detalle.descuento).toFixed(2)}}
                                            </td>
                                        </tr>
                                        <tr style="background-color: #ddd;">
                                            <td colspan="9" align="right"><strong>Total Parcial:</strong></td>
                                            <td>S/ {{totalParcial=(total-totalImpuesto).toFixed(2)}}</td>
                                        </tr>
                                        <tr style="background-color: #ddd;">
                                            <td colspan="9" align="right"><strong>Total Impuesto:</strong></td>
                                            <td>S/ {{totalImpuesto=((total*impuesto)/(1+impuesto)).toFixed(2)}}</td>
                                        </tr>
                                        <tr style="background-color: #ddd;">
                                            <td colspan="9" align="right"><strong>Total Neto:</strong></td>
                                            <td>S/ {{total=calcularTotal.toFixed(2)}}</td>
                                        </tr>
                                    </tbody>
                                    <tbody v-else>
                                        <tr>
                                            <td colspan="9">
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
                                <button type="button" class="btn btn-primary" @click="registrarIngreso()">Registrar Ingreso</button>
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
                                    <label for="">Proveedor</label>
                                    <p v-text="proveedor"></p>
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
                                            <td v-text="total">
                                                {{total=calcularTotal.toFixed(2)}}
                                            </td>
                                        </tr>
                                        <tr style="background-color: #CEECF5;">
                                            <td colspan="4" align="right"><strong>Total Parcial:</strong></td>
                                            <td>S/ {{totalParcial=(total-totalImpuesto).toFixed(2)}}</td>
                                        </tr>
                                        <tr style="background-color: #CEECF5;">
                                            <td colspan="4" align="right"><strong>Total Impuesto:</strong></td>
                                            <td>S/ {{totalImpuesto=((total*impuesto)).toFixed(2)}}</td>
                                        </tr>
                                        <tr style="background-color: #CEECF5;">
                                            <td colspan="4" align="right"><strong>Total Neto:</strong></td>
                                            <td >{{total=calcularTotal.toFixed(2)}}</td>
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
            <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body purple lighten-5">
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <select class="form-control " v-model="criterioA">
                                        <option value="nombre">Nombre</option>
                                        <option value="descripcion">Descripción</option>
                                        <option value="codigo">Código</option>
                                        </select>
                                        <input type="text" v-model="buscarA" @keyup.enter="listarmedicamento(buscarA,criterioA)" class="form-control" placeholder="Texto a buscar">
                                        <button type="submit" @click="listarmedicamento(buscarA,criterioA)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered  table-sm">
                                    <thead>
                                        <tr>
                                            <th>Opciones</th>
                                            <th>Código</th>
                                            <th>Nombre</th>
                                            <th>Categoría</th>
                                            <th>Precio Ingreso</th>
                                            <th>Stock</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="med in arraymedicamento" :key="med.id">
                                            <td>
                                                <button type="button" @click="agregarDetalleModal(med)" class="btn btn-success btn-sm">
                                                <i class="icon-check"></i>
                                                </button>
                                            </td>
                                            <td v-text="med.codigo"></td>
                                            <td v-text="med.nombre + ' '+ med.marca + ' '+med.presentacion"></td>
                                            <td v-text="med.nombre_categoria"></td>
                                            <td v-text="med.precio_ingreso"></td>
                                            <td v-text="med.stock"></td>
                                            <td>
                                                <div v-if="med.condicion">
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
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarPersona()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarPersona()">Actualizar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->
        </main>
</template>

<script>
    // import vSelect from 'vue-select';
    // import moment from 'vue-moment'
     import { format, formatDistance, formatRelative, subDays } from 'date-fns'

    export default {
        props: ['ruta'],
        props : ['ruta'],
        data (){
            return {
                date: new Date().toISOString().substr(0, 10),
                menu1: false,
                menu2: false,
                proveedor: {},
                ingreso_id: 0,
                idproveedor:0,
                proveedor:'',
                fecha_hora:'',
                tipo_comprobante : 'BOLETA',
                serie_comprobante : '',
                num_comprobante : '',
                impuesto: 0.18,
                total:0.0,
                totalImpuesto: 0.0,
                totalParcial: 0.0,
                arrayIngreso : [],
                arrayProveedor: [],
                arrayDetalle : [],
                listado:1,
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorIngreso : 0,
                errorMostrarMsjIngreso : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'num_comprobante',
                buscar : '',
                criterioA:'nombre',
                buscarA: '',
                arraymedicamento: [],
                idmedicamento: 0,
                codigo: '',
                medicamento: '',
                precio: 0,
                costo: 0,
                cantidad:1,
                descuento: 0,
                stock:0,
                tipo: ['BOLETA','FACTURA'],
                vencimiento: '',
                lote: '',
                busqueda: ['codigo','nombre'
                ],
                busqueda: ['num_comprobante','tipo_comprobante','nombre'],
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
                    resultado=resultado+(this.arrayDetalle[i].costo*this.arrayDetalle[i].cantidad-this.arrayDetalle[i].descuento)
                }
                return resultado;
            },
            // Parte de las fechas de vencimiento
            computedDateFormattedMomentjs () {
                return this.date ? moment(this.date).format('dddd, MMMM Do YYYY') : ''
            },
            computedDateFormattedDatefns () {
                return this.date ? format(this.date, 'dddd, MMMM Do YYYY') : ''
            },
        },
        methods : {
            listarIngreso (page,buscar,criterio){
                let me=this;
                let url = me.ruta +  '/ingreso?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayIngreso = respuesta.ingresos.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            cargarPdf(){
                window.open( '/ingreso/listarPdf','_blank');
            },
            selectProveedor(){
                let me=this;
                // loading(true)

                let url = me.ruta + '/proveedor/selectProveedor';
                axios.get(url).then(function (response) {
                    let respuesta = response.data;
                    // q: search
                    me.arrayProveedor=respuesta.proveedores;
                    // loading(false)
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            getDatosProveedor(val1){
                let me = this;
                me.loading = true;
                me.idproveedor = val1.id;
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
                        me.costo=me.arraymedicamento[0]['precio_ingreso'];
                        me.precio=me.arraymedicamento[0]['precio'];
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
            pdfIngreso(id){
                window.open( '/ingreso/pdf/'+ id );
            },
            pdfTicket(id){
                window.open( '/ingreso/pdfTicket/'+ id );
            },
            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarIngreso(page,buscar,criterio);
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
                if(me.idmedicamento==0 || me.cantidad==0 || me.precio==0 ){
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
                           me.arrayDetalle.push({
                                idmedicamento: me.idmedicamento,
                                medicamento: me.medicamento,
                                cantidad: me.cantidad,
                                precio: me.precio,
                                costo: me.costo,
                                descuento: me.descuento,
                                stock: me.stock,
                                fecha_vencimiento: me.date,
                                lote: me.lote
                            });
                            me.codigo="";
                            me.idmedicamento=0;
                            me.medicamento="";
                            me.cantidad=0;
                            me.precio=0;
                            me.descuento=0;
                            me.stock=0;
                            me.lote='';
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
                            costo: data['precio_ingreso'],
                            precio: data['precio'],
                            descuento:0,
                            stock:data['stock'],
                            fecha_vencimiento: data['fecha_vencimiento']
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
            registrarIngreso(){
                if (this.validarIngreso()){
                    return;
                }

                let me = this;
                let url = me.ruta + '/ingreso/registrar';
                axios.post( url ,{

                    'idproveedor': this.proveedor.id,
                    'tipo_comprobante': this.tipo_comprobante,
                    'serie_comprobante' : this.serie_comprobante,
                    'num_comprobante' : this.num_comprobante,
                    'impuesto' : this.impuesto,
                    'total' : this.total,

                    'data': this.arrayDetalle

                }).then(function (response) {
                    me.listado=1;
                    me.listarIngreso(1,'','num_comprobante');
                    me.idproveedor=0;
                    me.tipo_comprobante='BOLETA';
                    me.serie_comprobante='';
                    me.num_comprobante='';
                    me.impuesto=0.18;
                    me.total=0.0;
                    me.idarticulo=0;
                    me.articulo='';
                    me.cantidad=0;
                    me.precio=0;
                    me.arrayDetalle=[];

                }).catch(function (error) {
                    console.log(error);
                });
            },

            validarIngreso(){
                this.errorIngreso=0;
                this.errorMostrarMsjIngreso =[];

                if (this.proveedor=="") this.errorMostrarMsjIngreso.push("Seleccione un Proveedor");
                if (this.tipo_comprobante==0) this.errorMostrarMsjIngreso.push("Seleccione el comprobante");
                if (!this.num_comprobante) this.errorMostrarMsjIngreso.push("Ingrese el número de comprobante");
                if (!this.impuesto) this.errorMostrarMsjIngreso.push("Ingrese el impuesto de compra");
                if (this.arrayDetalle.length<=0) this.errorMostrarMsjIngreso.push("Ingrese detalles");

                if (this.errorMostrarMsjIngreso.length) this.errorIngreso = 1;

                return this.errorIngreso;
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
            verIngreso(id){
                let me=this;
                me.listado=2;

                //Obtener los datos del ingreso
                var arrayIngresoT=[];
                let url = me.ruta +  '/ingreso/obtenerCabecera?id=' + id;

                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    arrayIngresoT = respuesta.ingreso;

                    me.proveedor = arrayIngresoT[0]['nombre'];
                    me.fecha_hora = arrayIngresoT[0]['fecha_hora'];
                    me.tipo_comprobante=arrayIngresoT[0]['tipo_comprobante'];
                    me.serie_comprobante=arrayIngresoT[0]['serie_comprobante'];
                    me.num_comprobante=arrayIngresoT[0]['num_comprobante'];
                    me.impuesto=arrayIngresoT[0]['impuesto'];
                    me.total=arrayIngresoT[0]['total'];
                })
                .catch(function (error) {
                    console.log(error);
                });

                //Obtener los datos de los detalles
                var urld =  '/ingreso/obtenerDetalles?id=' + id;

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
            desactivarIngreso(id){
                var me = this;
               me.$swal({
                title: 'Esta seguro de anular esta ingreso?',
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
                    let url = me.ruta + '/ingreso/desactivar';
                    axios.put( url,{
                        'id': id
                    }).then(function (response) {
                        me.listarIngreso(1,'','num_comprobante');
                        me.$swal(
                        'Anulado!',
                        'La ingreso ha sido anulada con éxito.',
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
        },
        mounted() {
            this.listarIngreso(1,this.buscar,this.criterio);
            this.selectProveedor();
        }
    }
</script>
<style>
    .ingreso{
        width: 100% !important;
        /*position: relative !important;*/
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
