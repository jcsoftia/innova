<template>
<main class="main">
    <!-- Breadcrumb -->

    <div class="container-fluid mb-12">
        <div class="contenido card mt-12">
            <div class="table-bordered mt-12 ">
                <template >
                    <v-card class="card">
                        <v-layout wrap align-center justify-space-around class="">
                            <v-flex xs6>
                                <v-card-title>
                                 Alerta De Vencimiento
                                </v-card-title>

                            </v-flex>
                            <v-flex xs6>
                                <v-text-field
                                    v-model="search"
                                    label="Search"
                                    clearable
                                ></v-text-field>
                            </v-flex>
                            <v-flex xs12>
                                <v-data-table
                                :headers="headers"
                                :items="arrayVencimineto"
                                :search="search"
                                class="elevation-1 grey lighten-4 red--text"
                                ></v-data-table>
                            </v-flex>
                        </v-layout>


                    </v-card>
                </template>
            </div>
        </div>

        <!-- Los graficos  -->
        <div class="card m-4">
            <div class="car-body grey lighten-4">
                <div class="row px-4">
                    <div class="col-md-6 ">
                        <div class="card card-chart ">
                            <div class="card-header ">
                                <h4>Ingresos - Mes<span ></span></h4>
                            </div>
                            <div class="card-content">
                                <div class="ct-chart">
                                    <canvas id="ingresos">
                                    </canvas>
                                </div>
                            </div>
                            <div class="card-footer">
                                <p>Compras de los últimos meses.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-chart ">
                            <div class="card-header ">
                                <h4>Ventas - Mes</h4>
                            </div>
                            <div class="card-content">
                                <div class="ct-chart">
                                    <canvas id="ventas">
                                    </canvas>
                                </div>
                            </div>
                            <div class="card-footer">
                                <p>Ventas de los últimos meses.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row px-4">
                    <div class="col-md-6">
                        <div class="card card-chart ">
                            <div class="card-header ">
                                <h4>Ingresos Diarios</h4>
                            </div>
                            <div class="card-content">
                                <div class="ct-chart">
                                    <canvas id="ingresosLine">
                                    </canvas>
                                </div>
                            </div>
                            <div class="card-footer">
                                <p>Compras de los últimos días.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-chart grey lighten-4 black--text">
                            <div class="card-header ">
                                <h4>Ventas Diarias</h4>
                            </div>
                            <div class="card-content">
                                <div class="ct-chart">
                                    <canvas id="ventasLine">
                                    </canvas>
                                </div>
                            </div>
                            <div class="card-footer">
                                <p>Ventas de los últimos días.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>
</template>
<script>
    export default {
        props: ["ruta"],
        data (){
            return {
                search: '',
                varIngreso:null,
                charIngreso:null,
                ingresos:[],
                varTotalIngreso:[],
                varMesIngreso:[],

                varVenta:null,
                charVenta:null,
                ventas:[],
                varTotalVenta:[],
                varMesVenta:[],


                varIngresoDay:null,
                charIngresoDay:null,
                varTotalDayIngreso:[],
                varDayIngreso:[],
                ingresosDay:[],

                varVentaDay:null,
                charVentaDay:null,
                varTotalDayVenta:[],
                varDayVenta:[],
                ventasDay:[],

                offset:3,
                headers: [
                {
                    text: 'Lote',
                    align: 'left',
                    sortable: false,
                    value: 'lote',
                },
                { text: 'Descripcion', value: 'medicamento' },
                { text: 'Cantidad', value: 'cantidad' },
                { text: 'Precio', value: 'precio' },
                { text: 'Fecha', value: 'fecha_vencimiento' },
                { text: 'Total', value: 'total' },
                ],
                arrayVencimineto: [],
                // buscar: '',
                // busqueda: ['codigo','nombre','descripcion'],
                // criterio:'nombre',
            }
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
                for(var i=0;i<this.arrayVencimineto.length;i++){
                    resultado=resultado+(this.arrayVencimineto[i].costo*this.arrayVencimineto[i].cantidad-this.arrayVencimineto[i].descuento)
                }
                return resultado;
            }
        },
        methods : {
            listarVencimiento (page,buscar,criterio){
                let me=this;
                let url = me.ruta +  '/reporte/vencimiento?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    console.log(ingresos);
                    me.arrayVencimineto = respuesta.ingresos.data;
                    console.log(url);
                    console.log(me.arrayVencimineto);
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            getIngresos(){
                let me=this;
                let url = me.ruta + '/dashboard';
                console.log('Aqui va l aurl ' + url);
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.ingresos = respuesta.ingresos;
                    //cargamos los datos del chart
                    me.loadIngresosBar();
                })
                .catch(function (error) {
                    console.log(error);
                });
                var url2= me.ruta + '/dashboardDay';
                axios.get(url2).then(function (response) {
                    var respuesta= response.data;
                    me.ingresosDay = respuesta.ingresosD;
                    //cargamos los datos del chart

                    me.loadIngresosLine();
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            getVentas(){
                let me=this;
                let url = me.ruta + '/dashboard';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.ventas = respuesta.ventas;
                    //cargamos los datos del chart
                     me.loadVentasBar();
                })
                .catch(function (error) {
                    console.log(error);
                });
                var urld= me.ruta + '/dashboardDay';
                axios.get(urld).then(function (response) {
                    var respuesta= response.data;
                    me.ventasDay = respuesta.ventasD;
                    me.loadVentasLine();
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            loadIngresosBar(){
                let me=this;
                me.ingresos.map(function(x){
                    me.varMesIngreso.push(x.mes);
                    me.varTotalIngreso.push(x.total);
                });
                me.varIngreso=document.getElementById('ingresos').getContext('2d');

                me.charIngreso = new Chart(me.varIngreso, {
                    type: 'bar',
                    data: {
                        labels: me.varMesIngreso,
                        datasets: [{
                            label: 'Ingresos',
                            data: me.varTotalIngreso,
                            backgroundColor: 'rgba(0, 189, 82, 0.6)',
                            borderColor: 'rgba(0, 189, 82, 0.6)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero:true
                                }
                            }]
                        }
                    }
                });
            },
            loadVentasBar(){
                let me=this;
                me.ventas.map(function(x){
                    me.varMesVenta.push(x.mes);
                    me.varTotalVenta.push(x.total);
                });
                me.varVenta=document.getElementById('ventas').getContext('2d');

                me.charVenta = new Chart(me.varVenta, {
                    type: 'bar',
                    data: {
                        labels: me.varMesVenta,
                        datasets: [{
                            label: 'Ventas',
                            data: me.varTotalVenta,
                            backgroundColor: 'rgba(54, 162, 235, 0.6)',
                            borderColor: 'rgba(54, 162, 235, 0.6)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero:true
                                }
                            }]
                        }
                    }
                });
            },
            loadIngresosLine(){
                let me=this;
                me.ingresosDay.map(function(x){
                    me.varDayIngreso.push(x.dia);
                    me.varTotalDayIngreso.push(x.total);
                });
                me.varIngresoDay=document.getElementById('ingresosLine').getContext('2d');

                me.charIngresoDay = new Chart(me.varIngresoDay, {
                    type: 'line',
                    data: {
                        labels: me.varDayIngreso,
                        datasets: [{
                            label: 'Ingresos',
                            data: me.varTotalDayIngreso,
                            backgroundColor: 'rgba(220, 19, 82, 0.6)',
                            borderColor: 'rgba(220, 19, 82, 0.6)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero:true
                                }
                            }]
                        }
                    }
                });
            },
            loadVentasLine(){
                let me=this;
                me.ventasDay.map(function(x){
                    me.varDayVenta.push(x.dia);
                    me.varTotalDayVenta.push(x.total);
                });
                me.varVentaDay=document.getElementById('ventasLine').getContext('2d');

                me.charVentaDay = new Chart(me.varVentaDay, {
                    type: 'line',
                    data: {
                        labels: me.varDayVenta,
                        datasets: [{
                            label: 'Ventas',
                            data: me.varTotalDayVenta,
                            backgroundColor: 'rgba(224, 162, 5, 0.6)',
                            borderColor: 'rgba(224, 162, 5, 0.6)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero:true
                                }
                            }]
                        }
                    }
                });
            }
        },
        mounted() {
            this.getIngresos();
            this.getVentas();
            this.listarVencimiento(1,this.buscar,this.criterio);
        }
    }
</script>
<style lang="scss">
    // .theme--dark.v-data-table  { background-color: #00f !important; }
</style>
