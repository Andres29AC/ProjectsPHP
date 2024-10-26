<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Inicio</div>
                <a class="nav-link" href="{{route('panel')}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Panel
                </a>
                <div class="sb-sidenav-menu-heading">Modulos</div>
                @can('ver-compra')
                <!-- Compras -->
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-store"></i></div>
                    Compras
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ route('compras.index') }}">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-glasses"></i></div>
                            Ver
                        </a>
                        <a class="nav-link" href="{{ route('compras.create') }}">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-cart-plus"></i></div>
                            Crear
                        </a>
                    </nav>
                </div>
                @endcan
                @can('ver-venta')
                <!-- Ventas -->
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseVentas" aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-cart-shopping"></i></div>
                    Ventas
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseVentas" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ route('ventas.index') }}">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-glasses"></i></div>
                            Ver
                        </a>
                        <a class="nav-link" href="{{ route('ventas.create') }}">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-cart-arrow-down"></i></div>
                            Crear
                        </a>
                    </nav>
                </div>
                @endcan
                @can('ver-categoria')
                <!-- Categorias -->
                <a class="nav-link" href="{{ route('categorias.index') }}">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-tags"></i></div>
                    Categorias
                </a>
                @endcan
                @can('ver-marca')
                <!-- Marcas -->
                <a class="nav-link" href="{{ route('marcas.index') }}">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-thumbtack"></i></div>
                    Marcas
                </a>
                @endcan
                @can('ver-presentacion')
                <!-- Presentaciones -->
                <a class="nav-link" href="{{ route('presentaciones.index') }}">
                    <div class="sb-nav-link-icon"><i class="fa-regular fa-clone"></i></div>
                    Presentaciones
                </a>
                @endcan
                @can('ver-producto')
                <!-- Productos -->
                <a class="nav-link" href="{{ route('productos.index') }}">
                    <div class="sb-nav-link-icon"><i class="fa-brands fa-shopify"></i></div>
                    Productos
                </a>
                @endcan
                @can('ver-cliente')
                <!-- Clientes -->
                <a class="nav-link" href="{{ route('clientes.index') }}">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-users"></i></div>
                    Clientes
                </a>
                @endcan
                @can('ver-proveedore')
                <!-- Proveedores -->
                <a class="nav-link" href="{{ route('proveedores.index') }}">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-truck-field-un"></i></div>
                    Proveedores
                </a>
                @endcan
                <div class="sb-sidenav-menu-heading">OTROS</div>
                @can('ver-user')
                <!-- Usuarios -->
                <a class="nav-link" href="{{ route('users.index') }}">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-user"></i></div>
                    Usuarios
                </a>
                @endcan
                @can('ver-role')
                <!-- Roles -->
                <a class="nav-link" href="{{ route('roles.index') }}">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-person-circle-plus"></i></div>
                    Roles
                </a>
                @endcan
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Bienbenido:</div>
            {{ auth()->user()->name }}
        </div>
    </nav>
</div>
