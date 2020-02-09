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
                        <div class="box col-md-6 shadow" v-for="userVenta in arrayVentas" :key="userVenta.idusuario">
                            <div class="box-header">
                            <p class="box-title">Reporte de ingresos {{userVenta.usuario}}</p>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body no-padding  table-responsive">
                                <table class="table table-sm bg-table no-p-m">
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
                                        <tr class="bg-footer">
                                            <td colspan="2" align="right"><strong>Total</strong></td>
                                            <td class="" >Ingresos</td>
                                            <td class="" v-text="'S/ '+userVenta.total"></td>
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
.no-p-m{
    margin: 0 !important;
    padding: 0 !important;
}
.box-title{
    margin: 0 !important;
    padding: .5rem !important;
}
.box-header{
    text-align: center;
   background-image: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
   font-weight: bold !important;
    text-transform: uppercase;
    padding: 0.5rem;
    border-radius: 1rem 1rem 0 0 ;
}
.box-body{
    border-radius: 0 0 1rem 1rem;
}

.shadow{
    border-radius: 1rem;
    box-shadow: 0 10px 20px rgba(0,0,0,0.19), 0 6px 6px rgba(0,0,0,0.23) !important;
    transition: all 0.3s cubic-bezier(.25,.8,.25,1) !important;
    padding: 0 !important;
    margin: 0 !important;

}
.shadow:hover{
    box-shadow: 0 19px 38px rgba(0,0,0,0.30), 0 15px 12px rgba(0,0,0,0.22) !important;
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
.bg-table{

    background-image: linear-gradient(to top, #dfe9f3 0%, white 100%);
}
.bg-footer{
    background-image: linear-gradient(to top, #0ba360 0%, #3cba92 100%);
}
p{

}
</style>

