<template>
    <main class="main mt-3 mb-5" mb-5>
        <!-- <div class="ventas-hoy">
                <div class="card">
                    <div class="card-heading p-4">
                        <div class="mini-stat-icon text-center">
                            <i class="far fa-money-bill-alt bg-success text-white"></i>
                            <h5 class="font-20 text-center" v-text="'Total: '+ventaPrecioTotal"></h5>
                        </div>
                    </div>
                </div>
            </div> -->
        <div class="report text-center ">
            <!-- <a href="innova_dent/public/excelVenta" class="btn black--text bold btn-warning">Descargar Excel</a> -->
            <template>
                <button
                    type="primary"
                    @click="exportExcel"
                    class="btn black--text bold btn-warning"
                >
                    descargar Excel
                </button>
            </template>
        </div>
        <span style="font-size:2rem">Ventas</span>
        <template>
            <v-data-table
                class="elevation-1 test"
                :headers="headers"
                :items="arrayVenta"
                :items-per-page="10"
                :footer-props="{
                    'items-per-page-options': [5, 10]
                }"
            ></v-data-table>
        </template>
        <!-- <div class="row" >
                <div class="col-6 col-sm-4 col-md-3 col-xl-2" v-for="Venta in arrayVenta" :key="Venta.miIdVenta">
                    <div class="card">
                        <div class="card-heading p-4">
                            <div class="mini-stat-icon float-right">
                                <i class="mdi mdi-briefcase-check bg-warning text-white"></i>
                            </div>
                            <div>
                                <h5 class="font-20 text-center" v-text="'VENTA NRO  '+Venta.lote"></h5>
                            </div>
                            <p class="cyan--text mt-4">Medicamento: <span class="lime--text" v-text="Venta.medicamento"></span></p>
                            <p class="cyan--text mt-4">Descuento: <span class="lime--text" v-text="Venta.descuento"></span></p>
                            <p class="cyan--text mt-4">Cantidad: <span class="lime--text" v-text="Venta.cantidad"></span></p>
                            <p class="cyan--text mt-4">Precio: <span class="lime--text" v-text="Venta.precio"></span></p>
                            <p class="cyan--text mt-4">Total: <span class="light-green--text font-20" v-text="'S/ ' + Venta.precio * Venta.cantidad"></span></p>
                        </div>
                    </div>
                </div>
            </div> -->
    </main>
</template>

<script>
import XLSX from "xlsx";

export default {
    props: ["ruta"],

    props: ["ruta"],
    data() {
        return {
            loading: false,
            arrayVenta: [],
            // arrayventa:[],
            ventaPrecioTotal: 0,
            headers: [
                { text: "id", value: "id" },
                {
                    text: "Descripcion",
                    align: "left",
                    sortable: false,
                    value: "descripcion"
                },
                { text: "Comprobante", value: "num_com" },
                { text: "Cantidad", value: "cantidad" },
                { text: "Precio", value: "precio" },
                { text: "Descuento", value: "descuento" },
                { text: "Total", value: "total" }
            ],
            header: {
                header: [
                    "id",
                    "descripcion",
                    "num_com",
                    "cantidad",
                    "precio",
                    "descuento",
                    "total"
                ]
            }
        };
    },
    watch: {
        // pagination: {
        // handler () {
        //     this.loading = true
        //     this.$store.dispatch('queryItems')
        //     .then(result => {
        //         this.loading = false
        //     })
        // },
        // deep: true
        // }
    },
    components: {},
    computed: {
        // pagination: {
        //     get: function () {
        //         return this.$store.getters.pagination
        //     },
        //     set: function (value) {
        //         this.$store.commit('setPagination', value)
        //     }
        //     },
        //     items () {
        //     return this.$store.getters.items
        // }
    },
    methods: {
        listarReporteVentas() {
            var me = this;
            let url = me.ruta + "/reporte/ventas";
            axios
                .get(url)
                .then(function(response) {
                    // handle success
                    console.log(response);
                    me.arrayVenta = response.data;
                })
                .catch(function(error) {
                    // handle error
                    console.log(error);
                })
                .finally(function() {
                    // always executed
                });
        },
        getVentaTotal() {
            var me = this;
            let url = me.ruta + "/reporte/ventas/cantidad";
            axios
                .get(url)
                .then(function(response) {
                    // handle success
                    console.log(response);
                    me.ventaPrecioTotal = response.data[0].suma;
                    // me.arrayVenta=response.data;
                })
                .catch(function(error) {
                    // handle error
                    console.log(error);
                })
                .finally(function() {
                    // always executed
                });
        },
        //   Export excel data
        handleDownload() {
            //     const tHeader = this.header
            //     const data = this.arrayVenta // all list data
            //     this.xportExcel.export_json_to_excel({
            //     header: tHeader, //Header Required
            //     data, //Specific data Required
            //     filename: 'excel-list', //Optional
            //     autoWidth: true, //Optional
            //     bookType: 'xlsx' //Optional
            // })
        },
        exportExcel: function() {
            let data = XLSX.utils.json_to_sheet(this.arrayVenta, this.header);
            const workbook = XLSX.utils.book_new();
            const filename = "ReporteVentas";
            XLSX.utils.book_append_sheet(workbook, data, filename);
            XLSX.writeFile(workbook, `${filename}.xlsx`);
        }
        // excel(){
        //     const tHeader = this.headers
        //     const data = this.arrayVenta
        //     XLSX.utils.export_json_to_excel({
        //         header: tHeader, //Header Required
        //         data, //Specific data Required
        //         filename: 'excel-list', //Optional
        //         autoWidth: true, //Optional
        //         bookType: 'xlsx' //Optional
        //     })
        // }
    },
    mounted() {
        this.listarReporteVentas();
        // this.excel();
        this.getVentaTotal();
    }
};
</script>
<style>
.theme--dark.v-data-table {
    background-color: #222437 !important;
    color: #fff;
}
</style>
<style lang="scss" scoped>
.table-header {
    thead {
        background-color: black;
    }
}
// .test .theme--dark.v-table { background-color: #00f !important; }
</style>
