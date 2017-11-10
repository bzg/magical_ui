<img src="<?php echo base_url('assets/img/poudre.png');?>" class="poudre poudre_pos_home">

<div class="container" style="margin-top: 20px;margin-bottom: 20px;">
	<div class="well">
		<h2>Créer un compte</h2>
		
		<div class="row">
			<div class="col-xs-6">
				<h3>Pourquoi s'inscrire</h3>
				<p>
					Proin est neque, mattis a venenatis et, accumsan sagittis dui. Proin vitae lectus erat. Morbi iaculis non mi a lacinia. Proin eros mi, tempor in ex in, sagittis consequat urna. Pellentesque quis faucibus mi. Praesent vel leo congue, porttitor ipsum eget, euismod felis. Nullam imperdiet posuere volutpat. Fusce dolor erat, pulvinar non faucibus sit amet, faucibus vitae tellus. Suspendisse consequat tellus dui, quis fermentum urna pulvinar at. Nunc lacus eros, varius sit amet sapien vulputate, viverra vestibulum magna. Donec sed enim velit.
				</p>
				<a href='<?php echo base_url("index.php/User/login");?>' class="btn btn-success">Déjà inscrit</a>
			</div><!--/col-xs-6-->
			<div class="col-xs-6">
				<?php 
				if($msg){
					echo "<div class='alert alert-danger'>".$msg."</div>";
				}
				?>
				<form name="my_form" method="post" action="<?php echo base_url("index.php/User/new_save");?>">
				  <div class="form-group">
				    <label for="email">Adresse email</label>
				    <input type="email" class="form-control" id="email" name="usr_email" placeholder="Email">
				  </div>
				  <div class="form-group">
				    <label for="pwd">Mot de passe</label>
				    <input type="password" class="form-control" id="pwd" name="usr_pwd" placeholder="Mot de passe">
				    <label for="pwd_àconf">Confirmation</label>
				    <input type="password" class="form-control" id="pwd_conf" placeholder="Mot de passe">
				  </div>
				  <div class="text-right">
				  	<button type="submit" class="btn btn-success">S'inscrire</button>
				  </div>
				</form>
			</div><!--/col-xs-6-->

		</div><!--/row-->
	</div><!--/well-->
</div><!--/container-->

<script type="text/javascript">
	$("body").css("height", $(window).height()) ;
</script>

</body>
</html>