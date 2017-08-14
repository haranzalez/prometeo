<?php
     require 'src/dbcred.php';
     $conf = (isset($_GET['conf']))?$_GET['conf']:false;
     $email = (isset($_GET['email']))?$_GET['email']:false;

     if($conf && $email)
     {
        $sql = "SELECT * FROM users_web WHERE client_email = '$email' LIMIT 1";
        $result = $db->query($sql);
     
        $row = $result->fetch(PDO::FETCH_ASSOC);
        $name = $row['client_name'];
        
     }else{
         echo 'NOT SET';
     }
     

?>
<?php include 'includes/header.inc.php';?>
<style>
    .mainCon
    {
        text-align:center;
        background-color:#ffcc66;
        padding:30px 0px;
    }
    .content
    {
        text-align:center;
        border-top:solid 1px #ccc;
        border-bottom:solid 1px #ccc;
        padding:50px 0px;
    }
</style>
<body>

    <div class="contenedor">
        <div class="row mainCon">
            <div class="col-md-12"><img src="img/logo_ppal.png" alt=""></div>
        </div>
    </div>

        <!--MAIN CONTENT BEGINS -->
        <div class="content">
            <h1 style="color:green;">CONFIRMADO!</h1>
            <p>Gracias <?php echo $name; ?> por confirmar su email. Para usar sus nuevas credenciales e ingresar al portal haga click <a href="http://70.35.196.223/promTest/login.php">aqui</a></p>
            
        </div>
        <!--MAIN CONTENT ENDS-->
    </div>
    <footer style="text-align:center;padding:15px;width:50%;margin:auto;">
        <p style="color: #C0C5CB">&copy;2017 Prometeo.</p>
    </footer>
    

   

<?php include 'includes/footer.inc.php';?>
