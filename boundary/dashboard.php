<?php require_once "partials/header.php"; ?>

<body style="background-image: url(images/loginBackground.png); background-repeat:no-repeat;  background-attachment: fixed;
  background-size: cover;">
    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: white;">
    <h1 style="font-family: Copperplate, Arial, sans-serif; font-weight: bold;"> 
        Welcome back 
        <span style="color:black"><?php echo $loggedInUsername ?></span>
    </h1>
</div>

</body>
<?php require_once "partials/footer.php"; ?>