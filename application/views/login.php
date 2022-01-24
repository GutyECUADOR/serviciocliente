<?php

?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Kao Sport | Login</title>

    <link href="<?php echo base_url()?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>assets/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="<?php echo base_url()?>assets/css/animate.css" rel="stylesheet">
    <link href="<?php echo base_url()?>assets/css/style.css" rel="stylesheet">

</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div>

            <img src="<?php echo base_url()?>assets/img/logo_dark.png" alt="logo">

            </div>
            <h3>Bienvenido</h3>
            <p>
                Sistema de tickets y servicio al cliente.
            </p>

           
            <?php 
            if($this->session->flashdata('errormassage')){
                echo '<div class="alert alert-danger alert-dismissable">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                        '.$this->session->flashdata('errormassage').'
                    </div>';
            }
            ?>
           

            <?php echo form_open('login/checklogin', array('id' => 'registerForm', 'autocomplete' => 'off', 'class'=> 'm-t',  'role'=> 'form' )); ?>
            
            <form class="m-t" role="form">

                <div class="form-group">
                    <select class="form-control m-b" id="tipoinstitucion" name="tipoinstitucion" required="">
                        <option value="">Seleccione empresa por favor</option>
                            <?php 
                                foreach ($databasesArray as $row) {
                                    echo "<option value='$row->Codigo'>$row->Nombre</option>";
                                }
                            ?>
                    </select>
                </div>
           
                <div class="form-group">
                    <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Username" required>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">Ingresar</button>
                <a href="http://196.168.1.202:8050/wssp" class="btn btn-danger block full-width m-b">Menú Principal</a>

                
               
            </form>
            <p class="m-t"> <small>Derechos reservados &copy; <?php echo date('Y')?></small> </p>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="<?php echo base_url()?>assets/js/jquery-2.1.1.js"></script>
    <script src="<?php echo base_url()?>assets/js/bootstrap.min.js"></script>

</body>

</html>
