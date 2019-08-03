<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Sistema Informatica</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
<style type="text/css">
	body {
		color: #fff;
		background: #3598dc;
	}
	.form-control {
		min-height: 41px;
		background: #f2f2f2;
		box-shadow: none !important;
		border: transparent;
	}
	.form-control:focus {
		background: #e2e2e2;
	}
	.form-control, .btn {        
        border-radius: 2px;
    }
	.login-form {
		width: 500px;
		margin: 180px auto;
		text-align: center;
        
	}
	.login-form img {
         margin: 10px 0 25px; 
    }
    .login-form form {
		color: #7a7a7a;
		border-radius: 3px;
    	margin-bottom: 15px;
        background: #fff;
        box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
        padding: 30px;
    }
    
    .login-form .btn {        
        font-size: 16px;
        font-weight: bold;
		background: #201B59;
		border: none;
        outline: none !important;
    }
	.login-form .btn:hover, .login-form .btn:focus {
		background: #20196F;
	}
	.login-form a {
		color: #fff;
		text-decoration: underline;
	}
	.login-form a:hover {
		text-decoration: none;
	}
	.login-form form a {
		color: #7a7a7a;
		text-decoration: none;
	}
	.login-form form a:hover {
		text-decoration: underline;
	}
</style>
</head>
<body>
<div class="login-form">
    <form action="<?php echo base_url();?>index.php/cLogin/ingresar" method="post">
        <!-- <h2 class="text-center">Acceso</h2> -->   
        <img src="<?php echo base_url();?>assets/images/Logo-Upsin.png" alt="">
        <div class="form-group has-error">
        	<input type="text" class="form-control" name="txtUsuario" placeholder="Usuario" required="required">
        </div>
		<div class="form-group">
            <input type="password" class="form-control" name="txtContraseña" placeholder="Contraseña" required="required">
        </div>        
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-lg btn-block">Ingresar</button>
        </div>
        <p><a href="#">Olvido su contraseña?</a></p>
    </form>
</div>
</body>
</html>                            