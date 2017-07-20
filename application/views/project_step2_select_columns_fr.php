<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Normalisation</title>

	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/bootstrap-3.3.7-dist/css/bootstrap.min.css');?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/jquery.dataTables.min.css');?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/style.css');?>">

    <link rel="stylesheet" href="<?php echo base_url('assets/style_fu.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/jquery.fileupload.css');?>">

    <style type="text/css">
        #msg_danger, #create_project_ok, #upload_file_progress, #report{
            /*On masque par défaut*/
            display: none;
        }
        #show_report_ok, #upload_file_ok, #check_file_ok{
            visibility: hidden;
        }
		@media (min-width: 992px) {
		    .modal-lg {
		        width: 1100px;
		    }
		}
    </style>
</head>
<body>

<img src="<?php echo base_url('assets/img/poudre.png');?>" class="poudre poudre_pos_home">

<div class="container">
	<div class="row">
		<div class="col-xs-2" style="margin-top: 20px;">
			<img src="<?php echo base_url('assets/img/logo-RF-3@2x.png');?>" class="img-responsive">
		</div>
		<div class="col-xs-8 text-center">
			<h1>Magical_ui</h1>
		</div>
		<div class="col-xs-2 text-right" style="margin-top: 20px;">
            <div class="dropdown">
                <a href="#" data-toggle="dropdown" class="dropdown-toggle" style="font-size: 22px; color: #000;">
                    <span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo base_url("index.php/Home");?>"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>&nbsp;&nbsp;Accueil</a></li>
                    <li role="separator" class="divider"></li>
                    <?php
                    if(isset($_SESSION['user'])){
                        echo "<li><a href='".base_url("index.php/User/dashboard")."'><span class='glyphicon glyphicon-th' aria-hidden='true'></span>&nbsp;&nbsp;Tableau de bord</a></li>";
                        echo "<li><a href='".base_url("index.php/User/logout")."'><span class='glyphicon glyphicon-off' aria-hidden='true'></span>&nbsp;&nbsp;Déconnexion</a></li>";
                    }
                    else{
                        echo "<li><a href='".base_url("index.php/User/login/normalize")."'><span class='glyphicon glyphicon-lock' aria-hidden='true'></span>&nbsp;&nbsp;S'identifier</a></li>";
                    }
                    ?>
                    <li role="separator" class="divider"></li>
                    <li><a href="#"><span class="glyphicon glyphicon-flag" aria-hidden="true"></span>&nbsp;&nbsp;English</a></li>
                </ul>
            </div><!-- /dropdown-->
		</div>
	</div>

	<hr>

    <div class="text-center">
        <div class="breadcrumb flat">
            <!--<a href="#" class="done">Sélection du fichier</a>-->
            <a href="<?php echo base_url("index.php/Project/normalize");?>" class="done">Sélection du fichier</a>
            <a href="#" class="active">Sélection des colonnes</a>
            <a href="#" class="todo">Valeurs manquantes</a>
            <a href="#" class="todo">Détection des types</a>
            <a href="#" class="todo">Téléchargement</a>
        </div>
    </div>

	<div class="well">
		<h2><span id="project_name"></span> : <i>Sélection des colonnes</i></h2>
		<p>
			Proin est neque, mattis a venenatis et, accumsan sagittis dui. Proin vitae lectus erat. Nunc nec eros luctus, malesuada nulla quis, molestie felis. Morbi iaculis non mi a lacinia. Proin eros mi, tempor in ex in, sagittis consequat urna. Pellentesque quis faucibus mi. Praesent vel leo congue, porttitor ipsum eget, euismod felis. 
		</p>

		<div class="row">
			<div class="col-xs-6 well" style="background-color: #fff">
				<h3>Extrait aléatoire des données</h3>
				Vous avez la possibilité d'afficher un extrait aléatoire du fichier en cours. Cet extrait affichera un maximum de 50 lignes. A chaque clic sur le bouton ci-dessous, un nouvel extrait sera généré.
				<br><br>
				<button class="btn btn-success2" id="bt_view" data-toggle="modal" data-target="#modal-dataview_all"><span class='glyphicon glyphicon-eye-open'></span>&nbsp;Apperçu aléatoire des données</button>

				<div class="modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="modal-dataview_all">
				  <div class="modal-dialog modal-lg" role="document">
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				        <h4 class="modal-title">Aperçu des données</h4>
				      </div>
				      <div class="modal-body" id="data_all" style=" overflow-x:scroll">
				        
				      </div>
				      <div class="modal-footer">
				        <button type="button" class="btn btn-success2" id="bt_generate_sample"><span class="glyphicon glyphicon-refresh"></span>&nbsp;Regénérer</button>
				        <button type="button" class="btn btn-warning" data-dismiss="modal">Fermer</button>
				      </div>
				    </div>
				  </div>
				</div>

			</div>
			<div class="col-xs-6">
				<div id="result"></div>
			</div>
		</div>
    </div><!-- /well-->
</div><!--/container-->

<div class="container">
    <div class="row">
        <div class="col-md-12 text-right">
            <button class="btn btn btn-success" id="bt_next">Etape suivante : Détection des valeurs manquantes >></button>
        </div>
    </div><!-- /row-->
</div><!--/container-->


	<?php 
	if(isset($this->session->project_type)){
		$project_type = $this->session->project_type;
	}
	?>

    <script type="text/javascript" src="<?php echo base_url('assets/jquery-3.2.1.min.js');?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/bootstrap-3.3.7-dist/js/bootstrap.min.js');?>"></script>

    <script type="text/javascript" src="<?php echo base_url('assets/jquery.ui.widget.js');?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/jquery.iframe-transport.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/jquery.fileupload.js');?>"></script>
	
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/functions.js');?>"></script>

<script type="text/javascript">


		// Init - Ready
		$(function() {
		

			err = false;

			function select_all(){
				$( ".columns" ).each(function( index ) {
				  //console.log( index + ": " + $( this ).val() );
				  $(this).prop('checked', true);
				});
			}

			function unselect_all(){
				$( ".columns" ).each(function( index ) {
				  //console.log( index + ": " + $( this ).val() );
				  $(this).prop('checked', false);
				});
			}

			function select_checked_columns(){
				var tab_columns = new Array();
				$( ".columns" ).each(function( index ) {
					if( $(this).prop('checked') == true){
						tab_columns.push($(this).val());
						console.log( index + ": " + $( this ).val() );
					}
				});

				//var ch = tab_columns.join(",");

				return tab_columns;
			}

			function chargement(err) {
				console.log("chargement");
				/*
				Recupération des colonnes
				*/
				$.ajax({
					type: 'get',
					url: '<?php echo BASE_API_URL;?>' + '/api/metadata/normalize/<?php echo $_SESSION['project_id'];?>',
					success: function (result) {

						if(result.error){
							console.log("API error");
							console.log(result.error);
						}
						else{
	                        console.log("success");
	                        console.dir(result.metadata.column_tracker.original);

							metadata = result.metadata;

	                        $("#project_name").html(metadata.display_name);

	                        var bt = "<button class='btn btn-xs btn-success2' onClick='select_all();'>&nbsp;Tout sélectionner</button>&nbsp;<button class='btn btn-xs btn-warning' onClick='unselect_all();'>&nbsp;Tout désélectionner</button>\n";
	                        var ch = bt;

	                        columns = metadata.column_tracker.original;
							$.each(columns, function( i, name) {
							  ch = ch + "<div class='checkbox'><label><input type='checkbox' class='columns' checked value='" + name + "'>&nbsp;" + name + "&nbsp;(<a href='#'>voir</a>)</label></div>\n";
							});

							ch = ch + bt;

							$("#result").html(ch);


	                    }
	                },
	                error: function (result, status, error){
	                    console.log(result);
	                    console.log(status);
	                    console.log(error);
	                    err = true;
	                }
	            });// /ajax metadata



				generate_sample();



	        } // /Chargement


	        function generate_sample() {
				console.log("Sample");
	            var tparams = {
	                "module_name": "INIT"
	            }
				$.ajax({
					type: 'post',
					dataType: "json",
					contentType: "application/json; charset=utf-8",
					url: '<?php echo BASE_API_URL;?>' + '/api/last_written/normalize/<?php echo $_SESSION['project_id'];?>',
					data: JSON.stringify(tparams),
					success: function (result) {

						if(result.error){
							console.log("API error");
							console.log(result.error);
						}
						else{
	                        console.log("success");
	                        console.dir(result);
							
				            tparams = {
				            	"data_params": {
				                	"module_name": result.module_name,
				                	"file_name": result.file_name
				                },
				                "module_params":{
				                	"sampler_module_name": "standard",
					                "sample_params": {
					                	"num_rows": 20
					                }
				                }
				            }
							console.log("appel sample");
							
							$.ajax({
								type: 'post',
								dataType: "json",
								contentType: "application/json; charset=utf-8",
								url: '<?php echo BASE_API_URL;?>/api/sample/normalize/<?php echo $_SESSION['project_id'];?>',
								data: JSON.stringify(tparams),
								success: function (result) {

									if(result.error){
										console.log("API error");
										console.dir(result.error);
									}
									else{
				                        console.log("success sample");
				                        console.dir(result.sample);

				                        // Remplissage de la modale
				                        var ch = '<table class="table table-responsive table-condensed table-striped" id="sample_table">';

				                        ch += "<thead><tr>";
										$.each(columns, function( j, name) {
											  ch += '<th>' + name + "</th>";
											});
				                        ch += "</tr></thead><tbody>";
				                        console.dir(columns);
										$.each(result.sample, function( i, obj) {
											ch += "<tr>";
											$.each(columns, function( j, name) {
												ch += "<td>" + obj[name] + "</td>";
											});
											ch += "</tr>";
										});
										ch += "</tbody></table>";

					                    $("#data_all").html(ch);
					                	
					                    $("#sample_table").DataTable({
														        "language": {
														           "paginate": {
																        "first":      "Premier",
																        "last":       "Dernier",
																        "next":       "Suivant",
																        "previous":   "Précédent"
														    		},
														    		"search":         "Rechercher:",
														    		"lengthMenu":     "Voir _MENU_ enregistrements par page"
														        },
														        "lengthMenu": [5,20,"ALL"],
														        "responsive": true
														    });
										

				                    }
				                },
				                error: function (result, status, error){
				                    console.log("error");
				                    console.log(result);
				                    err = true;
				                }
				            });// /ajax
	                    }
	                },
	                error: function (result, status, error){
	                    console.log("error");
	                    console.log(result);
	                    err = true;
	                }
	            });// /ajax
	        }


	        function treatment(project_type) {
	            console.log("treatment");

	            // Appels API ----------------------
	            chargement(err);
	            // /Appels API ----------------------
			}








	        function valid(){
	            // Appel de l'étape suivante
	            window.location.href = "<?php echo base_url('index.php/Project/replace_mvs/'.$_SESSION['project_id']);?>";
	        }


			$("#bt_next").click(function(){
				var columns = select_checked_columns();

			    var tparams = {
			        "columns": columns
			    }

				console.log(JSON.stringify(tparams));

				$.ajax({
					type: 'post',
					url: '<?php echo BASE_API_URL;?>' + '/api/normalize/select_columns/<?php echo $_SESSION['project_id'];?>',
					data: JSON.stringify(tparams),
					contentType: "application/json; charset=utf-8",
					traditional: true,
					async: false,
					success: function (result) {
						console.dir(result);

						if(result.error){
							console.log("API error");
							
						}
						else{
			                console.log("success");

			                valid();
			            }
			        },
			        error: function (result, status, error){
			            console.log(result);
			            console.log(status);
			            console.log(error);
			            err = true;
			        }
			    });// /ajax
			});


			$("#bt_generate_sample").click(function(){
				$("#data_all").html("");
				generate_sample();
			});


			treatment();

		});

	</script>






</body>
</html>
