

<!-- MENU Start -->
<div class="navbar-custom orange darken-3">
    <div class="container-fluid">

        <div id="navigation">

            <!-- Navigation Menu-->
            <ul class="navigation-menu orange darken-3">

                <li @click="menu=0" class="has-submenu orange darken-3">
                    <a href="#"><i class="icon-accelerator"></i> Escritorio</a>
                </li>

                <li class="has-submenu orange darken-3">
                    <a href="#"><i class="icon-todolist-check orange darken-3"></i> Almacen <i class="mdi mdi-chevron-down mdi-drop"></i></a>
                    <ul class="submenu">
                        <li @click="menu=1" class="orange darken-3">
                            <a href="#"><i class="icon-todolist-add mr-2"></i>Productos</a>
                        </li>
                        <li @click="menu=2" class="orange darken-3">
                            <a href="#"><i class="icon-todolist-add mr-2 "></i>Medicamentos</a>
                        </li>
                        
                    </ul>
                </li>

                <li class="has-submenu">
                    <a href="#"><i class="icon-life-buoy"></i> Gestion  <i class="mdi mdi-chevron-down mdi-drop"></i></a>
                    <ul class="submenu">
                        <li @click="menu=3" class="orange darken-3">
                           <a href="#"> Presentaciones </a>
                        </li>

                        <li @click="menu=4" class="orange darken-3">
                           <a href="#"> Concentraciones </a>
                        </li>
                        

                        <li @click="menu=5" class="orange darken-3">
                           <a href="#"> Laboratorio </a>
                        </li>

                    </ul>
                </li>
                <li class="has-submenu">
                    <a href="#"><i class="icon-paper-sheet"></i> Ingresos <i class="mdi mdi-chevron-down mdi-drop"></i></a>
                    <ul class="submenu">

                        <li @click="menu=10" class="orange darken-3">
                           <a href="#"> Ingreso </a>
                        </li>
                        <li @click="menu=11" class="orange darken-3">
                           <a href="#"> Proveedores </a>
                        </li>
                    </ul>
                </li>
                <li class="has-submenu">
                    <a href="#"><i class="icon-paper-sheet"></i> Reportes <i class="mdi mdi-chevron-down mdi-drop"></i></a>
                    <ul class="submenu">

                        <li @click="menu=7" class="orange darken-3">
                           <a href="#"> Ingreso </a>
                        </li>
                        <!-- {{-- <li  class="orange darken-3">
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
