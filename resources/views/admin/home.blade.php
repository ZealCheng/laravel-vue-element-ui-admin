<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Laravel-Vue-ElementUI-Admin</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
<div id="app">

</div>
<script type="text/javascript">
  var $userInfo = {!! json_encode($data['userInfo']) !!};
</script>
<script src="{{ asset('js/admin.js') }}"></script>
<!-- built files will be auto injected -->
</body>

</html>