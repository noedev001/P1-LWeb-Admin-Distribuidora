@extends('template.master')
@section('title', 'Usuarios')
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
        <div class="row mt">
            <div class="col-lg-12">
                <div class="row content-panel">
                    <!-- /col-md-4 -->
                    <div class="col-md-4 profile-text">
                        <h3>{{ Auth::user()->name }}</h3>

                        @foreach ($asignasiones as $row)
                            @if ($row->user_id == Auth::user()->id)
                                @if ($row->rol_asignacion == 'SuperAdmin')
                                    <h6>Administrado 1</h6>
                                @endif
                                @if ($row->rol_asignacion == 'Admin')
                                    <h6>Administrado</h6>
                                @endif
                                @if ($row->rol_asignacion == 'Dist')
                                    <h6>Distribuidor</h6>
                                @endif
                            @endif
                        @endforeach

                        <br>
                        <p>
                            @foreach ($asignasiones as $row)
                                @if ($row->user_id == Auth::user()->id)
                                    @if ($row->rol_asignacion == 'SuperAdmin')
                                        <button class="btn btn-theme" data-toggle="modal" data-target="#myModalRegistro"><i
                                                class="fa fa-plus"></i>&nbsp Nuevo Usuario</button>
                                    @endif
                                @endif
                            @endforeach
                        </p>
                    </div>




                    <!-- /col-md-4 -->
                    <div class="col-md-4 centered">
                        <div class="profile-pic">
                            @foreach ($perfiles as $row)
                                @if ($row->user_id == Auth::user()->id)
                                    @if ($row->avatar == '')
                                        <p><img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image"
                                                class="img-circle"></p>
                                    @endif
                                    @if ($row->avatar != '')
                                        <p><img src="images/profile/{{ $row->avatar }}" class="img-circle"></p>
                                    @endif

                                @endif
                            @endforeach
                        </div>
                    </div>

                    <!-- /col-md-4 -->
                </div>
                <!-- /row -->
            </div>
            <!-- /col-lg-12 -->
            <div class="col-lg-12 mt">
                <div class="row content-panel">
                    <div class="panel-heading">
                        <ul class="nav nav-tabs nav-justified blue">


                            <li class="active ">
                                <a data-toggle="tab" href="#overview">Información Personal</a>
                            </li>
                            @foreach ($asignasiones as $row)
                                @if ($row->user_id == Auth::user()->id)
                                    @if ($row->rol_asignacion == 'SuperAdmin')
                                        <li>
                                            <a data-toggle="tab" href="#contact">Lista de Usuarios</a>
                                        </li>
                                    @endif
                                @endif
                            @endforeach



                        </ul>
                    </div>
                    <!-- /panel-heading -->
                    <div class="panel-body">
                        <div class="tab-content">
                            <div id="overview" class="tab-pane active">
                                <div class="row">
                                    <user-show-component :user_id="'{{ Auth::user()->id }}'"></user-show-component>
                                </div>
                                <!-- /OVERVIEW -->
                            </div>
                            <!-- /tab-pane -->

                            @foreach ($asignasiones as $row)
                                @if ($row->user_id == Auth::user()->id)
                                    @if ($row->rol_asignacion == 'SuperAdmin')
                                        <div id="contact" class="tab-pane">
                                            <div class="row">
                                                <users-component></users-component>
                                            </div>
                                            <!-- /row -->
                                        </div>
                                    @endif
                                @endif
                            @endforeach

                            <!-- /tab-pane -->

                            <!-- /tab-pane -->
                        </div>
                        <!-- /tab-content -->
                    </div>
                    <!-- /panel-body -->
                </div>
                <!-- /col-lg-12 -->
            </div>
            <!-- /row -->
        </div>


        <div class="modal fade" id="myModalRegistro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Registrar Nuevo Usuario</h4>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('guardar') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nombre') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text"
                                        class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name"
                                        value="{{ old('name') }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-right">{{ __('E-Mail') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                                        value="{{ old('email') }}" required>

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                        name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Roles De Usuario') }}</label>
                                <div class="col-md-6">

                                    <select id="roles" class="form-control" name="roles" required>
                                        <option value="" selected>Seleccione uno de los Roles...</option>
                                        <option value="SuperAdmin">Super Administrador</option>
                                        <option value="Admin">Administrador</option>
                                        <option value="Dist">Distribuidor</option>
                                    </select>
                                </div>

                            </div>




                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>

                        </form>


                    </div>

                </div>
            </div>
        </div>

    </div>
@endsection
