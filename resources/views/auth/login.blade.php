
<!DOCTYPE html>
<html lang="ru">
<head>
    <base href="/">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
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
    <style type="text/css">
        body {
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #f5f5f5;
        }
    </style>
</head>

<body>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header" style="text-align: center">
                Автоматизированная система учета заявок
            </h1>
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <h4>Предупреждение!</h4>
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif
            {!! Form::open(['route'=>'auth', 'class'=>'form-signin', 'name'=>'auth']) !!}
            <h2 class="form-signin-heading">Авторизуйтесь</h2>
            <input type="text" name="email" class="input-block-level" placeholder="Email address">
            <input type="password" name="password" class="input-block-level" placeholder="Password">
            <label class="checkbox">
                <input type="checkbox" value="Запомнить меня">Запомнить меня
            </label>
            {!! Form::submit('войти', ['class'=>'btn btn-lg btn-primary btn-block']) !!}
            {!! Form::Close() !!}
        </div>
    </div>
</div>


</body>
</html>