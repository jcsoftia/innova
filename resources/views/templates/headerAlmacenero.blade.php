

<!-- MENU Start -->
<div class="navbar-custom ">
    <div class="container-fluid">

        <div id="navigation">

            <!-- Navigation Menu-->
            <ul class="navigation-menu ">

                <li @click="menu=0" class="has-submenu ">
                    <a href="#"><i class="icon-accelerator"></i> Escritorio</a>
                </li>

                <li class="has-submenu ">
                    <a href="#"><i class="icon-todolist-check "></i> Almacen <i class="mdi mdi-chevron-down mdi-drop"></i></a>
                    <ul class="submenu">
                        <li @click="menu=1" class="">
                            <a href="#"><i class="icon-todolist-add mr-2"></i>Productos</a>
                        </li>
                        <li @click="menu=2" class="">
                            <a href="#"><i class="icon-todolist-add mr-2 "></i>Medicamentos</a>
                        </li>

                    </ul>
                </li>

                <li class="has-submenu">
                    <a href="#"><i class="icon-life-buoy"></i> Gestion  <i class="mdi mdi-chevron-down mdi-drop"></i></a>
                    <ul class="submenu">
                        <li @click="menu=3" class="">
                           <a href="#"> Presentaciones </a>
                        </li>

                        <li @click="menu=4" class="">
                           <a href="#"> Marca </a>
                        </li>


                        <li @click="menu=5" class="">
                           <a href="#"> Laboratorio </a>
                        </li>

                    </ul>
                </li>
                <li class="has-submenu">
                    <a href="#"><i class="icon-paper-sheet"></i> Ingresos <i class="mdi mdi-chevron-down mdi-drop"></i></a>
                    <ul class="submenu">

                        <li @click="menu=10" class="">
                           <a href="#"> Ingreso </a>
                        </li>
                        <li @click="menu=11" class="">
                           <a href="#"> Proveedores </a>
                        </li>
                    </ul>
                </li>
                <li class="has-submenu">
                    <a href="#"><i class="icon-paper-sheet"></i> Reportes <i class="mdi mdi-chevron-down mdi-drop"></i></a>
                    <ul class="submenu">

                        <li @click="menu=7" class="">
                           <a href="#"> Ingreso </a>
                        </li>
                        <!-- {{-- <li  class="">
                           <a href="http://127.0.0.1:8000/excelIngreso"> Reporte </a>
                        </li> --}} -->
                    </ul>
                </li>

            </ul>
            <!-- End navigation menu -->
        </div>
        <!-- end #navigation -->
    </div>
    <!-- end container -->
</div>
<!-- end navbar-custom -->
