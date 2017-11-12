<!DOCTYPE html>
<html>
    <head>
    <meta charset="UTF-8">
    <title>Limbo - Home</title>
    <meta name="author" content="Benjamin Jenkins">
    <meta name="description" content="Limbo lost and found home page">
    <meta name="keywords" content="lost and found, limbo, home">
    <link rel="shortcut icon" href="favicon.ico" type="image/vnd.microsoft.icon">
    <link rel="stylesheet" href="/css/custom.css" type="text/css">
    </head>
    <body>
    <?php require"includes/header.php"; ?>
    <div class="content-container">
        <?php require('includes/sidebar.php'); ?>
        <div class="page-content">
            <div class="lf-buttons">
                <button type="button" class="lf-button">I lost something!</button>
                <button type="button" class="lf-button">I found something!</button>
            </div>
        </div>
    </div>
    <?php require('includes/footer.php'); ?>
    </body>
</html>