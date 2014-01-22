<html>
<head>
    <title>BSSB Administrator</title>
    <link rel="stylesheet" href="css/bssb_admin.css" type="text/css">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="css/admin/css/bootstrap.css" type="text/css">
    <!-- Latest compiled and minified JavaScript -->
    <script src="js/admin/js/jquery.js"></script>
    <script src="js/admin/js/bootstrap.js"></script>
</head>
<body>
    <div id="admin-main">
        <div id="admin-login">
            <p class="header1">Bayelsa State Scholarship Board</p>
            <form role="form" method="post" action="admin/auth">
                <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input name="email" type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                </div>
                <button id="loginButton" type="submit" class="btn btn-primary btn-lg btn-block" data-loading-text="Autheticating...">Log in</button>
            </form>
        </div>
    </div>
<script>
    $('#loginButton')
        .click(function () {
            var btn = $(this)
            btn.button('loading')
            setTimeout(function () {
                btn.button('reset')
            }, 3000)
        });
</script>
</body>
</html>