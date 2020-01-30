

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
                        <li @click="menu=2" class="orange darken-3">
                            <a href="#"><i class="icon-todolist-add mr-2 "></i>Medicamentos</a>
                        </li>
                        
                    </ul>
                </li>

                <li class="has-submenu">
                    <a href="#"><i class="icon-paper-sheet"></i> Ventas <i class="mdi mdi-chevron-down mdi-drop"></i></a>
                    <ul class="submenu">

                        <li @click="menu=8" class="orange darken-3">
                           <a href="#"> Venta </a>
                        </li>
                        <li @click="menu=9" class="orange darken-3">
                           <a href="#"> Clientes </a>
                        </li>
                    </ul>
                </li>
                <li class="has-submenu">
                    <a href="#"><i class="icon-paper-sheet"></i> Reportes <i class="mdi mdi-chevron-down mdi-drop"></i></a>
                    <ul class="submenu">
                        <li @click="menu=17" class="orange darken-3">
                           <a href="#"> Venta </a>
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
