<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel='stylesheet' href="css/ho.css" />
</head>
<body>

<div class="home">

    <div class='navbar'>
        <?php
            require('navbar.php');
        ?>
    </div>
    
    <?php
        require('imageslider.php');
    ?>
       
    <?php
        require('footer.php');
    ?>
</div>
</body>
</html>