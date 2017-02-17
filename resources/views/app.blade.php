<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="_token" content="{!! csrf_token() !!}"/>
    <!-- TYPEKIT FONT -->
    <script src="https://use.typekit.net/vmf4hnn.js"></script>
    <script>try {
            Typekit.load({async: true});
        } catch (e) {
        }</script>
    <!--// FONT -->

    <meta charset="UTF-8">
    <title>Laddder | Started from the bottom now we're here.</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <!-- Optional theme -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('/css/normalize.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('/css/style-myprofile.css') }}">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    @yield('style')
    @include('includes.googleAnalytics')
</head>

<body>

@yield('navigation')

@yield('header')

@yield('content')

@yield('footer')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script type="text/javascript">
  $(function() {
    $( "#startDate" ).datepicker({
      dateFormat: "yy/mm/dd",
      changeMonth: true,
      changeYear: true
    });
    $( "#endDate" ).datepicker({
      dateFormat: "yy/mm/dd",
      changeMonth: true,
      changeYear: true
    });
  });
  </script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script src="{{ URL::asset('/js/search.js') }}"></script>
<script type="text/javascript">
$.ajaxSetup({
   headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
});
</script>
</body>

</html>