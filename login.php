<!DOCTYPE html>
<html>
    <head>
    <meta charset="UTF-8">
    <title>Limbo - Report an item you found</title>
    <meta name="author" content="Benjamin Jenkins">
    <meta name="description" content="Limbo lost and found report an item you found">
    <meta name="keywords" content="lost and found, limbo, found, report">
    <link rel="shortcut icon" href="favicon.ico" type="image/vnd.microsoft.icon">
    <link rel="stylesheet" href="/css/custom.css" type="text/css">
    </head>
    <body>
    <header>
        <a href="/index.php">
        <div class="site-title">
            <div class="title-limbo"><b>Limbo</b></div>
            <div class="title-lostandfound"><i>&nbsp;lost & found</i></div>
        </div>
        </a>
        <div class="account-buttons">
            <button type="button" class="account-button">Placeholder</button>
        </div>
    </header>
    <div class="content-container">
        <div class="sidebar">
            <div class="sidebar-login">
            </div>
            <div class="sidebar-lost">
            </div>
            <div class="sidebar-found">
            </div>
        </div>
        <div class="page-content">
            <h1>Log In</h1>
            <div class="form-container">
            <form class="login-form" action="/login.php" method="post">
                Email: <br><input class="login-field" type="text" name="email"> <br>
                Password: <br><input class="login-field" type="password" name="password"><br>
                <input class="login-submit" type="submit" value="Log in"><br>
                <p><a href="/changepassword.php">Change password</a></p>
            </form>
            </div>
        </div>
    </div>
    <footer>
        <div class="footer-author">By Benjamin Jenkins</div>
    </footer>
    </body>
</html>