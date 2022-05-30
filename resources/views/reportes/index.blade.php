@extends('template.master')
@section('title', 'Reportes')
@section('contenidonoti')
    <notificaciones-component></notificaciones-component>
@endsection
@section('foto')

    @foreach ($perfiles as $row)
        @if ($row->user_id == Auth::user()->id)
            @if ($row->avatar == '')
                <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image" class="img-circle" width="80"
                    height="80">
            @endif
            @if ($row->avatar != '')
                <img src="images/profile/{{ $row->avatar }}" class="img-circle" width="80" height="80">
            @endif

        @endif
    @endforeach
@endsection
@section('menu')

    <li class="mt">
        <a href="home">
            <i class="fa fa-dashboard"></i>
            <span>Inicio</span>
        </a>
    </li>


    @foreach ($asignasiones as $row)
        @if ($row->user_id == Auth::user()->id)
            @if ($row->rol_asignacion == 'SuperAdmin' || $row->rol_asignacion == 'Admin')
                <li>
                    <a href="categorias">
                        <i class="fa fa-tasks"></i>
                        <span>Categorias</span>
                    </a>
                </li>
                <li>
                    <a href="productos">
                        <i class="fa fa-desktop"></i>
                        <span>Productos</span>
                    </a>
                </li>
            @endif
        @endif
    @endforeach
    @foreach ($asignasiones as $row)
        @if ($row->user_id == Auth::user()->id)
            @if ($row->rol_asignacion == 'SuperAdmin' || $row->rol_asignacion == 'Admin' || $row->rol_asignacion == 'Dist')
                <li>
                    <a href="biblioteca">
                        <i class="fa fa-picture-o"></i>
                        <span>Gallery</span>
                    </a>
                </li>
                <li>
                    <a href="inventarios">
                        <i class="fa fa-book"></i>
                        <span>Inventario</span>
                    </a>
                </li>
                <li>
                    <a href="ofertas">
                        <i class="fa fa-tags"></i>
                        <span>Ofertas Descuentos</span>
                    </a>
                </li>
                <li>
                    <a href="pedidos">
                        <i class="fa fa-shopping-cart"></i>
                        <span>Pedidos</span>
                    </a>
                </li>
                <li>
                    <a href="cuentas">
                        <i class="fa fa-dollar"></i>
                        <span>Pagos y Depositos</span>

                    </a>
                </li>
            @endif
        @endif
    @endforeach



    @foreach ($asignasiones as $row)
        @if ($row->user_id == Auth::user()->id)
            @if ($row->rol_asignacion == 'SuperAdmin' || $row->rol_asignacion == 'Admin')




                <li>
                    <a href="reportes">
                        <i class="fa fa-list-alt"></i>
                        <span>Reporte Ventas</span>

                    </a>
                </li>
                <li>
                    <a href="mercaderias">
                        <i class="fa fa-list-ol"></i>
                        <span>Entrada de Mercaderia</span>

                    </a>
                </li>
                <li>
                    <a href="kardex">
                        <i class="fa fa-file-text"></i>
                        <span>Kardex General</span>
                    </a>
                </li>
            @endif
        @endif
    @endforeach

    @foreach ($asignasiones as $row)
        @if ($row->user_id == Auth::user()->id)
            @if ($row->rol_asignacion == 'SuperAdmin' || $row->rol_asignacion == 'Admin' || $row->rol_asignacion == 'Dist')
                <li>
                    <a href="clientes">
                        <i class="fa fa-female"></i><i class="fa fa-male"></i>
                        <span>Clientes</span>

                    </a>
                </li>

                <li>
                    <a href="pagos">
                        <i class="fa fa-book"></i>
                        <span>Creditos Cancelados</span>

                    </a>
                </li>
                <li>
                    <a href="ventas">
                        <i class="fa fa-clipboard"></i>
                        <span>Facturas</span>

                    </a>
                </li>

                <li>
                    <a href="users">
                        <i class="fa fa-users"></i>
                        <span>Usuarios</span>
                    </a>
                </li>

            @endif
        @endif
    @endforeach

    @foreach ($asignasiones as $row)
        @if ($row->user_id == Auth::user()->id)
            @if ($row->rol_asignacion == 'SuperAdmin' || $row->rol_asignacion == 'Admin')
                <li>
                    <a href="sugerencias">
                        <i class="fa fa-envelope"></i>
                        <span>Sugerencias</span>

                    </a>
                </li>
            @endif
        @endif
    @endforeach

    @foreach ($asignasiones as $row)
        @if ($row->user_id == Auth::user()->id)
            @if ($row->rol_asignacion == 'SuperAdmin')

                <li>
                    <a href="bitacoras">
                        <i class="fa fa-keyboard-o"></i>
                        <span>Bitacora</span>
                    </a>
                </li>
            @endif
        @endif
    @endforeach

@endsection
@section('contenido')

    <div class="content">
        <reportes-component></reportes-component>
    </div>



@endsection
