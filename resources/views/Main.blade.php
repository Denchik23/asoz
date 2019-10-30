<!DOCTYPE html>
<!-- saved from url=(0041)http://bootstrap-3.ru/examples/dashboard/ -->
<html lang="ru">
<head>
    <base href="/">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="<?php echo csrf_token(); ?>">
    <link rel="shortcut icon" href="http://bootstrap-3.ru/assets/ico/favicon.ico">

    <title>{{ isset($title) ? $title:'АС обработки заявок' }}</title>
    <!-- Bootstrap core CSS -->
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{asset('css/dashboard.css')}}" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/MainScript.js')}}"></script>
    <style id="holderjs-style" type="text/css"></style>
    @yield('head')
</head>

<body>
<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            {!! link_to_route('main', 'AC - обработки заявок', null, ['class' => 'navbar-brand'])!!}
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li>{!! link_to_route('Calculator', 'Калькулятор заправки')!!}</li>
                <li><a href="javascript:SetingModal()" >Настройки</a></li>
                <li><a href="/">Profile</a></li>
                <li><a href="https://www.google.ru/">Помощь</a></li>
            </ul>
            {!! Form::open(['route'=>'search', 'class'=>'navbar-form navbar-right', 'name'=>'search']) !!}
                {!! Form::input('text', 'searchId', Input::old('searchId'), ['class'=>'form-control', 'placeholder'=>'№ заявки']) !!}
                {!! Form::submit('Поиск', ['class'=>'btn btn-default', 'id'=>'search']) !!}
            {!! Form::Close() !!}
        </div>
    </div>
</div>

<div class="container-fluid">
    <div id="Seating" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Заголовок модального окна -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Ностройки web-проложения</h4>
                </div>
                <!-- Основной текст сообщения -->
                <div class="modal-body">
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <ul class="nav nav-sidebar">
                @for ($i =0; $i < 3; $i++)
                    @if (Request::is($data[$i][1]))
                        <li class="active">{!! link_to_route($data[$i][2], $data[$i][0])!!}</li>
                    @else
                        <li>{!! link_to_route($data[$i][2], $data[$i][0])!!}</li>
                    @endif
                @endfor
            </ul>
            <ul class="nav nav-list">
                <li class="nav-header">Ремонт техники</li>
                @for ($i =3; $i < 6; $i++)
                    @if (Request::is($data[$i][1]))
                        <li class="active">{!! link_to_route($data[$i][2], $data[$i][0])!!}</li>
                    @else
                        <li>{!! link_to_route($data[$i][2], $data[$i][0])!!}</li>
                    @endif
                @endfor
            </ul>
            <ul class="nav nav-list">
                <li class="nav-header">Заправка картриджей</li>
                @for ($i =6; $i < 9; $i++)
                    @if (Request::is($data[$i][1]))
                        <li class="active">{!! link_to_route($data[$i][2], $data[$i][0])!!}</li>
                    @else
                        <li>{!! link_to_route($data[$i][2], $data[$i][0])!!}</li>
                    @endif
                @endfor
            </ul>
            <ul class="nav nav-list">
                <li class="nav-header">Запросы на запчатси</li>
                @for ($i =9; $i < 11; $i++)
                    @if (Request::is($data[$i][1]))
                        <li class="active">{!! link_to_route($data[$i][2], $data[$i][0])!!}</li>
                    @else
                        <li>{!! link_to_route($data[$i][2], $data[$i][0])!!}</li>
                    @endif
                @endfor
            </ul>
            <ul class="nav nav-list">
                <li class="nav-header">Архив</li>
                @for ($i =11; $i < count($data); $i++)
                    @if (Request::is($data[$i][1]))
                        <li class="active">{!! link_to_route($data[$i][2], $data[$i][0])!!}</li>
                    @else
                        <li>{!! link_to_route($data[$i][2], $data[$i][0])!!}</li>
                    @endif
                @endfor
            </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h1 class="page-header">
                {{-- $pagetitle --}}
                @if((!empty($title)) and (!empty($pagetitle)))
                    {!! $title !!} - {!! $pagetitle !!}
                @else АС обработки заявок
                @endif
            </h1>
            @yield('content')
        </div>
    </div>
</div>
</body>
</html>