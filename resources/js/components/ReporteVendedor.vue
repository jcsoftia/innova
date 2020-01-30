<template>
    <main class="main">
            <!-- Breadcrumb -->
            <section class="content-header">

                    <ol class="breadcrumb mt-5">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Reportes</li>
                    </ol>
                </section>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="container">
                    <div class="datepicker">
                        <label class="fecha">Fecha</label>
                            <datepicker class="datepicker__date" v-model="date" name="fecha"
                                @opened="datepickerAbierto"
                                @selected="fechaSeleccionada"
                                @closed="datepickerCerrado"
                                :format="customFormatter"
                            ></datepicker>
                    </div>
                </div>
                <template v-if="arrayVentas.length" >
                    <div class="row" >
                        <div class="box col-md-6" v-for="userVenta in arrayVentas" :key="userVenta.idusuario">
                            <div class="box-header">
                            <p class="box-title"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Reporte de ingresos {{userVenta.usuario}}</font></font></p>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body no-padding  table-responsive">
                                <table class="table table-sm table-info">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Usuario</th>
                                            <th scope="col">Nombre </th>
                                            <!-- <th scope="col">Balones Vendidos</th> -->
                                            <th scope="col">Total a cobrar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr >
                                            <td scope="col" v-text="userVenta.idusuario"></td>
                                            <td scope="col" v-text="userVenta.usuario"></td>
                                            <td scope="col" v-text="userVenta.nombre"></td>

                                            <!-- <td scope="col" v-text="userVenta.CantVenta"></td> -->
                                            <td scope="col" class="label label-warning" v-text="'S/ '+userVenta.total"></td>
                                        </tr>
                                        <tr style="background-color: #CEECF5;">
                                            <td colspan="2" align="right"><strong>Total</strong></td>
                                            <td class="" >Ingresos</td>
                                            <td class="badge bg-green" v-text="'S/ '+userVenta.total"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.box-body -->
                        </div>
                    </div>
                </template>
                <template v-else>
                    <h2 class="alert alert-danger">No hay nada que mostrar en éste día</h2>
                </template>



                <!-- Fin ejemplo de tabla Listado -->
            </div>
    </main>
</template>

<script>
    import Toasted from 'vue-toasted';
    import { async } from 'q';
    import moment from "moment";

    export default {
        props: ["ruta"],
        data() {
            return{
                date: new Date(),
                arrayVentas:[]

            }
        },
        computed:{
            obtenerFech(){

                this.date = Math.round(Date.now() / 1000)
            }
        },
        methods:{
            obtenerDetalles(date){
                var me = this;
                axios.get(me.ruta + '/reporte/ventas/vendedor?fecha='+date)
                .then(function (response) {
                    // handle success
                    console.log('/reporte/ventas/vendedor?'+date);
                    let datos = response.data;
                    me.arrayVentas = response.data;
                    console.log('array ventas ',me.arrayVentas);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
                .then(function () {
                    // always executed
                });
            },
            customFormatter(date) {
                    return moment(date).format('DD MMM YYYY');
            },
            datepickerAbierto: function() {
                console.log('El datepicker ha sido abierto');
            },
            fechaSeleccionada: function() {
                var me = this;
                console.log(me.date);
            },
            datepickerCerrado: function() {
                console.log('El datepicker ha sido cerrado');

                this.obtenerDetalles(this.customFormatter(this.date))
                console.log(this.date);
            },
        },
        mounted(){
            this.obtenerDetalles(this.customFormatter(this.date));
        },

    }

</script>
<style>
*{
    box-sizing: border-box;
}
.box-header{
    text-align: center;
    background: #02698f;
    color: white;
    font-weight: bold !important;
    text-transform: uppercase;
    padding: 0.5rem;
    border-radius: 1rem 1rem 0 0 ;
}
.badge{
    margin-top: .3em;
    margin-bottom: .3em;
}
.label{
    display: inline-block;
    width: 90%
}
label.fecha{
    width: auto;
    display: inline-block;
    padding-right: 2rem;
}
.vdp-datepicker{
    display: inline-block
}
.datepicker{
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 2rem;
    margin-bottom: 2rem;


    position: relative;
}
.datepicker__date{
    background: rgb(255, 243, 243);
    opacity: 1 !important;
    color: #000 !important;
    padding: 1em;
     width: 10rem;
     display: flex;
     border-radius: .5em;
     /* cursor: pointer; */
}
.datepicker__date div input{
    cursor: pointer;
}

</style>

