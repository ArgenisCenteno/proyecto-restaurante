<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark"> <!--begin::Sidebar Brand-->
    <div class="sidebar-brand"> <!--begin::Brand Link--> <a href="{{route('home')}}" class="brand-link">
            <!--begin::Brand Image--> <img src="{{asset('iconos/solicitud.png')}}" alt="FarmaGarca"
                class="brand-image opacity-75 shadow"> <!--end::Brand Image--> <!--begin::Brand Text--> <span
                class="brand-text fw-light">Farmagarca</span> <!--end::Brand Text--> </a> <!--end::Brand Link--> </div>
    <!--end::Sidebar Brand--> <!--begin::Sidebar Wrapper-->  
    <div class="sidebar-wrapper">
        <nav class="mt-2"> <!--begin::Sidebar Menu-->
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                <li class="nav-item "> <a href="#" class="nav-link ">
                        <img src={{asset('iconos/solicitud.png')}} width="20px" alt="clasificadores-tasas">
                        <p>
                            Clasificadores / Tasas
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"> <a href={{route('categorias.index')}} class="nav-link ">
                                <img src={{asset('iconos/aprobado.png')}} width="20px" alt="clasificadores-tasas">
                                <p>Categorías</p>
                            </a> </li>
                        <li class="nav-item"> <a href={{route('subcategorias.index')}} class="nav-link ">
                                <img src={{asset('iconos/etiqueta.png')}} width="20px" alt="clasificadores-tasas">
                                <p>Subcategorías</p>
                            </a> </li>

                        <li class="nav-item"> <a href="{{route('tasas.index')}}" class="nav-link">
                                <img src={{asset('iconos/impuesto.png')}} width="20px" alt="clasificadores-tasas">
                                <p>Tasas/Impuestos</p>
                            </a> </li>
                    </ul>
                </li>
                <li class="nav-item"> <a href="#" class="nav-link"> <img src={{asset('iconos/producto.png')}}
                            width="20px" alt="clasificadores-tasas">
                        <p>
                            Almacen
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"> <a href="{{route('almacen')}}" class="nav-link"> <i
                                    class="nav-icon bi bi-circle"></i>
                                <p>Productos</p>
                            </a> </li>
                        {{-- <li class="nav-item"> <a href="./widgets/info-box.html" class="nav-link"> <i
                                    class="nav-icon bi bi-circle"></i>
                                <p>info Box</p>
                            </a> </li>
                        <li class="nav-item"> <a href="./widgets/cards.html" class="nav-link"> <i
                                    class="nav-icon bi bi-circle"></i>
                                <p>Cards</p>
                            </a> </li> --}}
                    </ul>
                </li>
                <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-clipboard-fill"></i>
                        <p>
                            Ventas
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"> <a href={{route('ventas.vender')}} class="nav-link"> <i
                                    class="nav-icon bi bi-circle"></i>
                                <p>Generar Venta</p>
                            </a> </li>
                        <li class="nav-item"> <a href={{route('ventas.index')}} class="nav-link"> <i
                                    class="nav-icon bi bi-circle"></i>
                                <p>Ventas</p>
                            </a> </li>


                    </ul>
                </li>
                <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-tree-fill"></i>
                        <p>
                            Compras
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"> <a href={{route('compras.comprar')}} class="nav-link"> <i
                                    class="nav-icon bi bi-circle"></i>
                                <p>Generar Compra</p>
                            </a> </li>
                        <li class="nav-item"> <a href={{route('compras.index')}} class="nav-link"> <i
                                    class="nav-icon bi bi-circle"></i>
                                <p>Compras</p>
                            </a> </li>
                    </ul>
                </li>
             {{--    <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-pencil-square"></i>
                        <p>
                            Caja
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                   <ul class="nav nav-treeview">
                        <li class="nav-item"> <a href="{{route('cajas.index')}}" class="nav-link"> <i
                                    class="nav-icon bi bi-circle"></i>
                                <p>Cajas</p>
                            </a> </li>
                    </ul>
                </li> --}}
                <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-table"></i>
                        <p>
                            Proveedores
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"> <a href="{{route('proveedores.index')}}" class="nav-link"> <i
                                    class="nav-icon bi bi-circle"></i>
                                <p>Proveedores</p>
                            </a> </li>
                    </ul>
                </li>


                <li class="nav-item"> <a  href="{{route('pagos.index')}}" class="nav-link"> <i
                            class="nav-icon bi bi-download"></i>
                        <p>Pagos</p>
                    </a> </li>
                <li class="nav-item"> <a href="{{route('usuarios.index')}}" class="nav-link"> <i
                            class="nav-icon bi bi-grip-horizontal"></i>
                        <p>Usuarios</p>
                    </a> </li>
             
                <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-ui-checks-grid"></i>
                        <p>
                            Reportes
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"> <a href="./docs/components/main-header.html" class="nav-link"> <i
                                    class="nav-icon bi bi-circle"></i>
                                <p>Ventas</p>
                            </a> </li>
                        <li class="nav-item"> <a href="./docs/components/main-sidebar.html" class="nav-link"> <i
                                    class="nav-icon bi bi-circle"></i>
                                <p>Compras</p>
                            </a> </li>
                        <li class="nav-item"> <a href="./docs/components/main-sidebar.html" class="nav-link"> <i
                                    class="nav-icon bi bi-circle"></i>
                                <p>Recibos</p>
                            </a> </li>
                        <li class="nav-item"> <a href="./docs/components/main-sidebar.html" class="nav-link"> <i
                                    class="nav-icon bi bi-circle"></i>
                                <p>Pagos</p>
                            </a> </li>
                        <li class="nav-item"> <a href="./docs/components/main-sidebar.html" class="nav-link"> <i
                                    class="nav-icon bi bi-circle"></i>
                                <p>Inventario</p>
                            </a> </li>
                        <li class="nav-item"> <a href="./docs/components/main-sidebar.html" class="nav-link"> <i
                                    class="nav-icon bi bi-circle"></i>
                                <p>Caja</p>
                            </a> </li>
                        <li class="nav-item"> <a href="./docs/components/main-sidebar.html" class="nav-link"> <i
                                    class="nav-icon bi bi-circle"></i>
                                <p>Usuarios</p>
                            </a> </li>
                    </ul>
                </li>



            </ul> <!--end::Sidebar Menu-->
        </nav>
    </div> <!--end::Sidebar Wrapper-->
</aside> <!--end::Sidebar--> <!--begin::App Main-->