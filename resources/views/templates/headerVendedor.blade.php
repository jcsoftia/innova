

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
                        <li @click="menu=2" class="">
                            <a href="#"><i class="icon-todolist-add mr-2 "></i>Medicamentos</a>
                        </li>

                    </ul>
                </li>

                <li class="has-submenu">
                    <a href="#"><i class="icon-paper-sheet"></i> Ventas <i class="mdi mdi-chevron-down mdi-drop"></i></a>
                    <ul class="submenu">

                        <li @click="menu=8" class="">
                           <a href="#"> Venta </a>
                        </li>
                        <li @click="menu=9" class="">
                           <a href="#"> Clientes </a>
                        </li>
                    </ul>
                </li>
                <li class="has-submenu">
                    <a href="#"><i class="icon-paper-sheet"></i> Reportes <i class="mdi mdi-chevron-down mdi-drop"></i></a>
                    <ul class="submenu">
                        <li @click="menu=17" class="">
                           <a href="#"> Venta </a>
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
