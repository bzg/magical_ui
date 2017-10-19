<style type="text/css">
	#panel_comment{
		border-radius:  5px 5px 0 0;
		position: fixed;
		bottom: -350px;
		left: 20px;
		width: 350px;
		border: 1px solid #777;
		background-color: #262626;
	}
	#panel_comment .row{
		margin-bottom: 10px;
		margin-top: 10px;
	}
	#panel_comment .panel-title{
		color: #fff;
		cursor: pointer;
	}

	#panel_comment .title_comment{
		font-weight: bolder;
		display: inline-block;
		margin-right: 15px;
		margin-left: 15px;
	}
	#panel_comment .txt_comment{
		color: #fff;
		font-weight: bolder;
		font-style: italic;
	}
	#bt_comment{
		background-color: #25368C;
		border-bottom-width: 0;
	}
	body{
		height: 100%;
	}

	footer{
		background-color: #262626;
		padding-top: 20px;
		padding-bottom: 20px;
		height: 200px;
	}
		footer .txt{
			color: #aaa;
			/*font-weight: bolder;*/
		}
		footer .title{
			text-transform: uppercase;
			display: inline-block;
			padding-bottom: 10px;
		}
		footer li{
			list-style: none;
		}
		footer .col-right{
			border-left: 1px dotted #777;
		}
		footer a,a:hover{
			color: #aaa;	
			text-decoration: none;	
		}
</style>

<footer class="container-fluid" style="padding-top: 20px;">
    <div class="row">
		<div class="col-md-4 txt">
			<div class="row">
				<div class="col-md-12 text-center">
					<span class="title">plan du site</span>        			
				</div>
			</div>
		</div>
        <div class="col-md-4 txt">
			<div class="row">
				<div class="col-md-12 text-center">
					<span class="title">partenaires</span>        			
				</div>
			</div><!-- / col-md-4-->
        	<div class="row">
        		<div class="col-md-6 col-left">
					<ul>
						<li>
							<a href="#">Programme EIG</a>
						</li>
						<li>
							<a href="#">MESRI</a>
						</li>
						<li>
							<a href="#">ABES</a>
						</li>
					</ul>
        		</div>
        		<div class="col-md-6 col-right">
        			<ul>
						<li>
							<a href="#">Agro</a>
						</li>
						<li>
							<a href="#">Etalab</a>
						</li>
						<li>
							<a href="#">...</a>
						</li>
					</ul>
        		</div>
        	</div>
        </div><!-- / col-md-4-->
		<div class="col-md-4 txt">
			<ul>
				<li>
					<a href="#">A propos</a>
				</li>
				<li>
					<a href="<?php echo base_url("index.php/Home/cgu");?>" target="_blank">Conditions générales d'utilisation</a>
				</li>
				<li>
					<a href="#">API</a>
				</li>
			</ul>
			<ul>
				<li>
					<a href="#">
						<i class="fa fa-envelope" aria-hidden="true"></i>
						Contact
					</a>
				</li>
			</ul>
		</div><!-- / col-md-4-->
    </div><!-- / row -->
</footer>



<div class="panel panel-default" id="panel_comment">
  <div class="panel-heading" id="bt_comment">
    <h3 class="panel-title text-center">
		<span class="glyphicon glyphicon-chevron-up"></span>
	    <span class="title_comment">Commentaires ?</span>
		<span class="glyphicon glyphicon-chevron-up"></span>
	</h3>
  </div>
  <div class="panel-body">
  <form name="form_comment">
  	<div class="row">
  		<div class="col-md-12">
  			<span class="txt_comment">Un bug, un comportement inatendu, une suggestion...</span>
  		</div>
  	</div>
    <div class="row">
  		<div class="col-md-12">
  			<input type="text" class="form-control" placeholder="Votre nom">
  		</div>
  	</div>
    <div class="row">
  		<div class="col-md-12">
  			<input type="email" class="form-control" placeholder="Votre email">
  		</div>
  	</div>
    <div class="row">
  		<div class="col-md-12">
  			<textarea class="form-control" rows="4" placeholder="Votre message"></textarea>
  		</div>
  	</div>
    <div class="row">
  		<div class="col-md-12 text-right">
  			<button type="submit" class="btn btn-success2" id="bt_submit">Envoyer</button>
  		</div>
  	</div>
  	</form>
  </div>
</div>

<script type="text/javascript">
	$("#bt_comment").click(function(){
		if($('#panel_comment').hasClass("maximised")){
			panel_minimize();
		}
		else{
			panel_maximize();
		}
	});

	$("#bt_submit").click(function(e){
		e.preventDefault();
		send_comment();

		// on replie
		panel_minimize();
	});

	function send_comment() {
		alert("envoi du commentaire")
	}

	function panel_minimize() {
		$('#panel_comment')
			.removeClass("maximised")
			.addClass("minimised")
			.css('bottom','-20px')
			.animate({
			  bottom : '-350px'
		});
		ch = '<span class="glyphicon glyphicon-chevron-up"></span><span class="title_comment">Commentaires ?</span><span class="glyphicon glyphicon-chevron-up"></span>';
		$("#panel_comment .panel-title").html(ch);
	}

	function panel_maximize() {
		$('#panel_comment')
			.removeClass("minimised")
			.addClass("maximised")
			.css('bottom','-350px')
			.animate({
				bottom : '-20px'
		});
		ch = '<span class="glyphicon glyphicon-chevron-down"></span><span class="title_comment">Commentaires ?</span><span class="glyphicon glyphicon-chevron-down"></span>';
		$("#panel_comment .panel-title").html(ch);
	}
</script>
