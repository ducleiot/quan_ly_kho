<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>ĐOÀN KHÁNH - Đại Lý Lương Thực</title>
    <script type="text/javascript">
		var documentTitle = document.title + " - ";
        (function titleMarquee() {
            document.title = documentTitle = documentTitle.substring(1) + documentTitle.substring(0,1);
            setTimeout(titleMarquee, 500);
        })();
	</script>
    <link rel="stylesheet" href="{{asset('assets/assets_login/bootstrap_backend/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Aclonica">
    <link rel="stylesheet" href="{{asset('assets/assets_login/css/Login-Form-Clean.css')}}">
    <link rel="stylesheet" href="{{asset('assets/assets_login/css/Navigation-with-Button.css')}}">
    <link rel="stylesheet" href="{{asset('assets/assets_login/css/styles.css')}}">
</head>

<body>
    <div class="login-clean">
        @yield('content')
    </div>
    <script src="{{asset('assets/assets_login/js/jquery.min.js')}}"></script>
    <script src="{{asset('assets/assets_login/bootstrap_backend/js/bootstrap.min.js')}}"></script>
</body>
</html>