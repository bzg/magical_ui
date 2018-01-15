<?php
function is_completed_step($step_name, $project_steps, $has_mini)
{
    $filename = str_replace('MINI__', '', key($project_steps));

    if($project_steps[$filename]['concat_with_init']==1){
        return true;
    }

    switch ($step_name) {
        case 'INIT':
            return true;
            break;

        case 'add_selected_columns':
        case 'replace_mvs':
        case 'recode_types':
            if($has_mini){
                return $project_steps['MINI__'.$filename][$step_name];
            }
            else{
                return $project_steps[$filename][$step_name];
            }

            break;
        default :
            return false;
    }
}// /is_completed_step()


function get_progress_html($bs_color, $ratio, $step, $project_id)
{
    $html = '<div
                class="progress-bar progress-bar-'.$bs_color.' step '.$step.'"
                role="progressbar"
                aria-valuenow="25"
                aria-valuemin="0"
                aria-valuemax="100"
                data-toggle="tooltip"
                style="width: '.$ratio.'%;">
            </div>';
    return $html;
}// /get_progress_html()


function get_internal_projects_html($internal_projects)
{
    # Renvoi un code HTML d'affichage des projets internes (publiques) dans la modale

    $html = '';

    // Récupération des informations depuis les métatdata des projets internes
    foreach ($internal_projects as $project){

        // $project['display_name']
        // $project['description']
        // $project['project_id']

        // Date de création
        $timestamp = $project['timestamp'];
        $created_date = date('d/m/Y', $timestamp);

        // Nombre de lignes
        $nrows = $project['files'][key($project['files'])]['nrows'];

        $html .= '<div class="bloc_project" onclick="select_internal_ref(\''.$project['project_id'].'\',\''.$project['display_name'].'\');">';
            $html .= '<div class="row">';
                $html .= '<div class="col-md-1 chk">';
                $html .= '<h3><span class="glyphicon glyphicon-ok"></span></h3>';
                $html .= '</div>';
                $html .= '<div class="col-md-11">';
                    // Nom di projet
                    $html .= '<div class="row">';
                        $html .= '<div class="col-md-12">';
                            $html .= '<h4 class="internal_ref_title">'.$project['display_name'].'<h4>';
                        $html .= '</div>';
                    $html .= '</div>';
                    // Nom du fichier
                    // $html .= '<div class="row">';
                    //     $html .= '<div class="col-md-12">';
                    //         $html .= $project['file'];
                    //     $html .= '</div>';
                    // $html .= '</div>';
                    // Description du projet
                    $html .= '<div class="row">';
                        $html .= '<div class="col-md-12">';
                            $html .= '<i>'.$project['description'].'</i>';
                        $html .= '</div>';
                    $html .= '</div>';
                    // Date de création
                    $html .= '<div class="row">';
                        $html .= '<div class="col-md-12">';
                            $html .= 'Création : '.$created_date;
                        $html .= '</div>';
                    $html .= '</div>';
                    // Nombre de ligne
                    $html .= '<div class="row">';
                        $html .= '<div class="col-md-12">';
                            $html .= 'Nombre de lignes : '.$nrows;
                        $html .= '</div>';
                    $html .= '</div>';
                $html .= '</div>'; // /col-md-11
            $html .= '</div>'; // /row
            $html .= '<hr>';
        $html .= '</div>';// / bloc_project


    }// /foreach

    echo $html;
}// /get_internal_projects_html()


function get_normalized_projects_html($id, $normalized_projects)
{
    $html = '';

    $tab_steps = ['add_selected_columns', 'replace_mvs', 'recode_types', 'concat_with_init'];
    $nb_steps = count($tab_steps);
    $ratio = 100/$nb_steps;

    foreach ($normalized_projects as $project){
        // On ne veut pas afficher les projets "publics" ici
        if($project['public']){
            continue;
        }
        // Si upload incomplet, le projet n'a pas de "file", on ne prend pas en compte
        if(empty($project['file'])){
            continue;
        }
        // Jauge
        $steps_html = '<div class="progress">';
        $found_step_todo = false;
        $step_todo = "";
        foreach ($tab_steps as $step) {
            $bs_color = (is_completed_step($step, $project['steps_by_filename'], $project['has_mini']))?"success2":"warning";
            $steps_html.= get_progress_html($bs_color, $ratio, $step, $project['project_id']);

            if(!$found_step_todo){
                if(!is_completed_step($step, $project['steps_by_filename'], $project['has_mini'])){
                    $step_todo = $step;
                    $found_step_todo = true;
                }
            }
        }
        $steps_html.= '</div>';
        // /Jauge

        // dates
        $timestamp = strtotime($project['created_tmp']);
        $created_date = date('d/m/Y', $timestamp);

        $timestamp = strtotime($project['modified_tmp']);
        $modified_date = date('d/m/Y h:m', $timestamp);
        // /dates

        $html .= '<div class="bloc_project" onclick="select_project(\''.$project['project_id'].'\',\''.$project['display_name'].'\');">';
            $html .= '<div class="row">';
                $html .= '<div class="col-md-1 chk">';
                $html .= '<h3><span class="glyphicon glyphicon-ok"></span></h3>';
                $html .= '</div>';
                $html .= '<div class="col-md-11">';
                    $html .= '<div class="row">';
                        $html .= '<div class="col-md-12">';
                            $html .= '<h4>'.$project['display_name'].'<h4>';
                        $html .= '</div>';
                    $html .= '</div>';

                    $html .= '<div class="row">';
                        $html .= '<div class="col-md-12" style="height: 5px;">';
                            $html .= $steps_html;
                        $html .= '</div>';
                    $html .= '</div>';
                    $html .= '<div class="row">';
                        $html .= '<div class="col-md-12">';
                            $html .= $project['file'];
                        $html .= '</div>';
                    $html .= '</div>';
                    $html .= '<div class="row">';
                        $html .= '<div class="col-md-12">';
                            $html .= '<i>'.$project['description'].'</i>';
                        $html .= '</div>';
                    $html .= '</div>';

                    $html .= '<div class="row">';
                        $html .= '<div class="col-md-12">';
                            $html .= 'Création : '.$created_date;
                        $html .= '</div>';
                    $html .= '</div>';
                    $html .= '<div class="row">';
                        $html .= '<div class="col-md-12">';
                            $html .= 'Dernière modification : '.$modified_date;
                        $html .= '</div>';
                    $html .= '</div>';
                $html .= '</div>';
            $html .= '</div>';
            $html .= '<hr>';
        $html .= '</div>';
    }

    echo $html;
}// /get_normalized_projects_html()

?>

<img src="<?php echo base_url('assets/img/poudre.png');?>" class="poudre poudre_pos_home">

<div class="container-fluid intro">
    <div class="row" style="padding-top: 20px;padding-bottom: 20px;">
        <div class="col-lg-6">
            	<h1>Jointure de fichiers</h1>
                <div class="page_explain">
                    La jointure ou l'appariement de fichiers permet de relier les lignes correspondantes dans 2 fichiers tabulaires.
                </div>
        </div> <!-- / col-12-->
        <div class="col-lg-6">
<!--
            <div class="row">
                <div class="col-lg-9">
                    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                      <ol class="carousel-indicators">
                        <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                      </ol>

                      <div class="carousel-inner" role="listbox">
                        <div class="item active">
                          <img src="..." alt="...">
                          <div class="carousel-caption">
                            ...
                          </div>
                        </div>
                        <div class="item">
                          <img src="..." alt="...">
                          <div class="carousel-caption">
                            ...
                          </div>
                        </div>
                        ...
                      </div>

                      <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                      </a>
                      <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                      </a>
                    </div>
                </div>
                <div class="col-lg-3 text-right">
                    <span class="btn btn-default btn-xl fileinput-button btn_2_3" onclick="javascript:introJs().setOption('showBullets', false).start();">
                        <img src="<?php echo base_url('assets/img/laptop.svg');?>"><br>Aide
                    </span>
                </div>
            </div>
-->

        </div><!-- /col-lg-6-->
    </div><!-- / row -->
</div>
<div class="container-fluid background_1" style="margin-top: 0px;">
    <div class="row">
        <div class="col-xs-12">
            <h2 style="display: inline;">
                <span class="step_numbers">1</span>
                &nbsp;Identité du projet
            </h2>
            <form class="form-horizontal" name="form_project" id="form_project" method="post">
                <div class="form-group" data-intro="Choisissez un nom pour vous y retrouver plus facilement">
                    <label for="project_name" class="col-sm-2 control-label">Nom du projet *</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="project_name" name="project_name" placeholder="Nom du projet" value="Projet_1">
                    </div>
                </div>
                <div class="form-group" data-intro="Ajoutez une description optionnelle">
                    <label for="project_description" class="col-sm-2 control-label">Description du projet</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" id="project_description" name="project_description" rows="3"></textarea>
                    </div>
                </div>
<!--
                <div class="col-md-offset-2 col-md-10">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" id="chk_cgu"> En cochant cette case vous acceptez les <a href="<?php echo base_url("index.php/Home/cgu");?>" target="_blank">conditions générales d'utilisation</a>
                        </label>
                    </div>
                </div>
                <div class="col-md-offset-2 col-md-10">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" id="chk_reuse" checked> En cochant cette case vous acceptez que vos données soient utilisées pour l'amélioration de l'application
                        </label>
                    </div>
                </div>
-->
            </form>
        </div> <!-- / col-12-->
    </div><!-- / row -->
</div>
<div class="container-fluid background_1" style="margin-top: 0px;">
    <hr>
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="col-xs-6">
                    <div data-intro="Choisissez ici votre fichier source (le fichier sale à auquel associer une référence)">
                        <h2 style="display: inline;">
                            <span class="step_numbers">2</span>
                            &nbsp;Sélection du fichier "source"
                            <i class="fa fa-table" aria-hidden="true"></i>
                        </h2>
                        <div>
                            Sélectionnez le fichier "source", c'est à dire le fichier auquel on veut associer des codes de référence.
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <h3>
                                    <i class="fa fa-file" aria-hidden="true"></i>
                                    &nbsp;Fichier "Source" sélectionné :
                                </h3>
                                <i class="fa fa-chevron-circle-right" aria-hidden="true"></i>
                                &nbsp;<i id="src_selection">Pas encore de sélection</i>
                                <div id="file_name_src" class="hidden"></div>
                                <div id="src_project_name" class="hidden"></div>
                            </div><!-- /col -->
                        </div><!-- /row -->
                        <hr>
                        <form class="form-horizontal" name="form_src_file" id="form_src_file" method="post" enctype="multipart/form-data">
                            <div class="row" data-intro="Vous pouvez uploader un nouveau fichier ...">
                                <div class="col-xs-1 text-right">
                                    <h3 class="hover_new_file_src_target">
                                        <span class="glyphicon glyphicon-ok"></span>
                                    </h3>
                                </div>
                                <div class="col-xs-8 hover_new_file_src" id="bt_new_file_src">
                                    <div>
                                        <h3>Nouveau fichier</h3>
                                        Tout nouveau fichier devra suivre au préalable un processus de normalisation afin de pouvoir être utilisé dans un projet de jointure.
                                        La normalisation rendra la jointure plus efficace. (<a href="#">Qu'est-ce que la normalisation ?</a>)
                                    </div>
                                </div>
                                <div class="col-xs-3 hover_new_file_src">
                                    <div class="text-center" style="margin-top: 40px;">

                                        <span class="btn btn-default btn-xl fileinput-button btn_2_3">
                                            <h4 class="glyphicon glyphicon-plus"></h4>
                                            <br>
                                            <h4>Nouveau</h4>
                                            <input id="fileupload_src" type="file" name="file">
                                        </span>
                                        <!--
                                        <div id="file_name_src"></div>
                                        -->
                                        <button id="envoyer_src" style="display: none;"></button>
                                    </div>
                                </div>
                            </div>

                            <div class="row" data-intro="... ou en reprendre un que vous avez déjà uploadé">
                                <div class="col-xs-1 text-right">
                                    <h3 class="hover_exist_file_src_target">
                                        <span class="glyphicon glyphicon-ok"></span>
                                    </h3>
                                </div>
                                <div class="col-xs-8 hover_exist_file_src" id="bt_exist_file_src">
                                    <div>
                                        <h3>Fichier déjà normalisé</h3>
                                        Si vous possédez un compte et que vous avez déjà normalisé le fichier souhaité, vous avez la possibilité de le sélectionner. Seuls les fichiers entièrement normalisés sont disponibles.
                                    </div>
                                </div>
                                <div class="col-xs-3 hover_exist_file_src" style="margin-top: 40px;">
                                    <div class="text-center">
                                    <?php
                                    if(!isset($_SESSION['user'])){
                                    ?>
                                    <a href="<?php echo base_url('index.php/User/login/link');?>">
                                        <span class="glyphicon glyphicon-lock"></span>
                                        M'identifier
                                    </a>
                                    <?php
                                    }
                                    else{
                                    ?>
                                    <a class="btn btn-xs btn-default btn_2_3" id="bt_select_project_src">
                                        <h4 class="glyphicon glyphicon-list-alt"></h4>
                                        <h4>Mes fichiers</h4>
                                    </a>
                                    <!--<div id="src_project_name"></div>-->
                                    <div id="src_project_id" style="display: none;"></div>
                                    <?php
                                    }
                                    ?>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>

                </div>
                <div class="col-xs-6" style="border-left: 3px dotted #ddd;">
                    <div data-intro="Choisissez ici votre fichier de référence">
                        <h2 style="display: inline;">
                            <span class="step_numbers">3</span>
                            &nbsp;Sélection du fichier "référentiel"
                            <i class="fa fa-database" aria-hidden="true"></i>
                        </h2>
                        <div>
                            Sélectionnez un fichier "référentiel", dans lequel nous chercherons les élements de la source.
                        </div>

                        <div class="row">
                            <div class="col-xs-12">
                                <h3>
                                    <i class="fa fa-file" aria-hidden="true"></i>
                                    &nbsp;Fichier "Référentiel" sélectionné :
                                </h3>
                                <i class="fa fa-chevron-circle-right" aria-hidden="true"></i>
                                &nbsp;<i id="ref_selection">Pas encore de sélection</i>
                                <div id="file_name_ref" class="hidden"></div>
                                <div id="ref_project_name" class="hidden"></div>
                                <div id="ref_internal_project_name" class="hidden"></div>
                            </div><!-- /col -->
                        </div><!-- /row -->
                        <hr>
                        <form class="form-horizontal" name="form_ref_file" id="form_ref_file" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-xs-1">
                                    <h3 class="hover_new_file_ref_target">
                                        <span class="glyphicon glyphicon-ok"></span>
                                    </h3>
                                </div>
                                <div class="col-xs-8 hover_new_file_ref" id="bt_new_file_ref">
                                    <div>
                                        <h3>Nouveau fichier</h3>
                                        Tout nouveau fichier devra suivre au préalable un processus de normalisation afin de pouvoir être utilisé dans un projet de jointure.
                                        La normalisation rendra la jointure plus efficace. (<a href="#">Qu'est-ce que la normalisation ?</a>)
                                    </div>
                                </div>
                                <div class="col-xs-3 hover_new_file_ref">
                                    <div class="text-center" style="margin-top: 40px;">
                                        <span class="btn btn-default btn-xl fileinput-button btn_2_3">
                                            <h4 class="glyphicon glyphicon-plus"></h4>
                                            <br>
                                            <h4>Nouveau</h4>
                                            <input id="fileupload_ref" type="file" name="file">
                                        </span>
                                        <!--<span id="file_name_ref"></span>-->
                                        <button id="envoyer_ref" style="display: none;"></button>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-1">
                                    <h3 class="hover_exist_file_ref_target">
                                        <span class="glyphicon glyphicon-ok"></span>
                                    </h3>
                                </div>
                                <div class="col-xs-8 hover_exist_file_ref" id="bt_exist_file_ref">
                                    <div>
                                        <h3>Fichier déjà normalisé</h3>
                                        Si vous possédez un compte et que vous avez déjà normalisé le fichier souhaité, vous avez la possibilité de le sélectionner. Seuls les fichiers entièrement normalisés sont disponibles.
                                    </div>
                                </div>
                                <div class="col-xs-3 hover_exist_file_ref" style="margin-top: 40px;">
                                    <div class="text-center">
                                    <?php
                                    if(!isset($_SESSION['user'])){
                                    ?>
                                    <a href="<?php echo base_url('index.php/User/login/link');?>">
                                        <span class="glyphicon glyphicon-lock"></span>
                                        M'identifier
                                    </a>
                                    <?php
                                    }
                                    else{
                                    ?>
                                    <a class="btn btn-xs btn-default btn_2_3" id="bt_select_project_ref">
                                        <h4 class="glyphicon glyphicon-list-alt"></h4>
                                        <h4>Mes fichiers</h4>
                                    </a>
                                    <!--<div id="ref_project_name"></div>-->
                                    <div id="ref_project_id" style="display: none;"></div>
                                    <?php
                                    }
                                    ?>
                                    </div>
                                </div>
                             </div>
                            <div class="row" data-intro="Vous pouvez aussi choisir un référentiel dans notre collection de référentiels publiques">
                                <div class="col-xs-1">
                                    <h3 class="hover_exist_ref_target">
                                        <span class="glyphicon glyphicon-ok"></span>
                                    </h3>
                                </div>
                                <div class="col-xs-8 hover_exist_ref">
                                    <div>
                                        <h3>Référentiels publics</h3>
                                        Vous avez la possibilité d'utiliser des référentiels publiques. Chacun de ces référentiels a déjà été normalisés. Une description de leur contenu est disponible pour chacun d'entre eux.
                                        <br><br>
                                        NB: Nous ne nous engageons pas sur la qualité des données.
                                    </div>
                                </div>
                                <div class="col-xs-3 hover_exist_ref">
                                    <div class="text-center" style="margin-top: 40px;">
                                        <a class="btn btn-xs btn-default btn_2_3" id="bt_modal_ref">
                                            <h4 class="glyphicon glyphicon-list-alt"></h4>
                                            <h4>Sélectionner</h4>
                                        </a>
                                        <!--<div id="ref_internal_project_name"></div>-->
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div><!-- /well-->
                </div>
            </div>

            <hr>

            <div class="row" style="padding-top: 20px;padding-bottom: 20px;">
                <div class="col-md-offset-6 col-md-6">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" id="chk_cgu"> En cochant cette case vous acceptez les <a href="<?php echo base_url("index.php/Home/cgu");?>" target="_blank">conditions générales d'utilisation</a>
                        </label>
                    </div>
                </div>
                <div class="col-md-offset-6 col-md-6">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" id="chk_reuse" checked> En cochant cette case vous acceptez que vos données soient utilisées pour l'amélioration de l'application
                        </label>
                    </div>
                </div>
            </div>
            <div class="row" style="padding-top: 20px;padding-bottom: 20px;">
                <div class="col-md-12 text-right">
                    <button class="btn btn-success" id="bt_new_project" style="width: 300px;">Créer le projet >></button>
                </div>
            </div>




            <div class="row background_2">
                <div class="col-md-12">
                    <div class="row" id="result" style="margin-top: 20px;color: #fff;">
                        <div id="steps" style="margin-left: 10px;margin-right: 10px;">
                            <div>
                                <span id="txt_create_merge_project">Création du projet de jointure</span>
                                <span id="create_merge_project_ok" class="glyphicon glyphicon-ok check_ok"></span>
                            </div>

                            <div style="margin-top: 20px;">
                                <span id="txt_init_nrz_src_project">Initialisation du projet de normalisation "SOURCE"</span>
                                <span id="init_nrz_src_project_ok" class="glyphicon glyphicon-ok check_ok"></span>
                            </div>
                            <div>
                                <span id="txt_send_src_file">Envoi du fichier "SOURCE" sur le serveur</span>
                                <span id="send_src_file_ok" class="glyphicon glyphicon-ok check_ok"></span>

                                <div id="progress_src" class="progress" style="margin-bottom: 5px;width:100%">
                                    <div class="progress-bar progress-bar-success progress-bar-striped active" style="height: 5px;width:0%"></div>
                                </div>
                            </div>
                            <div id="send_src_analyse">
                                <span>Analyse du fichier "SOURCE"</span>
                                <span id="send_src_analyse_wait">
                                    <img src="<?php echo base_url('assets/img/wait.gif');?>" style="width: 20px;">
                                </span>
                                <span id="send_src_analyse_ok" class="glyphicon glyphicon-ok check_ok"></span>
                            </div>

                            <div style="margin-top: 20px;">
                                <span id="txt_init_nrz_ref_project">Initialisation du projet de normalisation "REFERENTIEL"</span>
                                <span id="init_nrz_ref_project_ok" class="glyphicon glyphicon-ok check_ok"></span>
                            </div>
                            <div>
                                <span id="txt_send_ref_file">Envoi du fichier "REFERENTIEL" sur le serveur</span>
                                <span id="send_ref_file_ok" class="glyphicon glyphicon-ok check_ok"></span>

                                <div id="progress_ref" class="progress" style="margin-bottom: 5px;width:100%">
                                    <div class="progress-bar progress-bar-success progress-bar-striped active" style="height: 5px;width:0%"></div>
                                </div>
                            </div>
                            <div id="send_ref_analyse">
                                <span>Analyse du fichier "REFERENTIEL"</span>
                                <span id="send_ref_analyse_wait">
                                    <img src="<?php echo base_url('assets/img/wait.gif');?>" style="width: 20px;">
                                </span>
                                <span id="send_ref_analyse_ok" class="glyphicon glyphicon-ok check_ok"></span>
                            </div>

                            <div style="margin-top: 20px;">
                                <span id="txt_add_src_nrz_projects">Ajout du projet de normalisation "SOURCE" au projet de jointure</span>
                                <span id="add_src_nrz_projects_ok" class="glyphicon glyphicon-ok check_ok"></span>
                            </div>
                            <div>
                                <span id="txt_add_ref_nrz_projects">Ajout du projet de normalisation "REFERENTIEL" au projet de jointure</span>
                                <span id="add_ref_nrz_projects_ok" class="glyphicon glyphicon-ok check_ok"></span>
                            </div>
                        </div> <!--/steps-->
                    </div>

                    <div class="row" id="bloc_bt_next" style="padding-bottom: 20px;">
                        <div class="col-md-12 text-right">
                            <button class="btn btn-success" id="bt_next">Etape suivante : Association des colonnes >></button>
                        </div>
                    </div>
                </div>
            </div>



            <div id="files" class="files"></div>

        </div> <!-- / col-12-->
    </div><!-- / row -->
</div><!--/container-->

<!-- Modal des projets de normalisation de l'utilisateur-->
<div class="modal fade" id="modal_projects" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Sélection d'un projet de normalisation</h4>
      </div>
      <div class="modal-body" id="modal_projects_body">
        <?php
            get_normalized_projects_html("normalized_projects_ref", $normalized_projects);
        ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal des référentiels internes-->
<div class="modal fade" id="modal_ref" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Sélection d'un référentiel interne</h4>
      </div>
      <div class="modal-body">
        <?php
            get_internal_projects_html($internal_projects);
        ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal error-->
<div class="modal fade" id="modal_error" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #262626">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel" style="color: #ddd">Erreur(s) !</h4>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-xs-1">
                <h2 style="margin-top:0;color: #E00612;"><i class="fa fa-exclamation-circle" aria-hidden="true"></i></h2>
            </div>
            <div class="col-xs-11" id="errors">

            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">

    var err = false;

    function my_errors(direction, my_error) {
    	var div_error = $("#msg_danger");
    	console.log(my_error);
    	switch (my_error){
    		case "project_name_undefined":
    			div_error.html("<strong>Le nom du projet doit être renseigné.</strong>");
    		break;
            case "no_src_project":
                div_error.html("<strong>Veuillez seélectionner un fichier source</strong>");
            break;
            case "no_ref_project":
                div_error.html("<strong>Veuillez seélectionner un fichier référentiel</strong>");
            break;
            case "api_new_error":
                div_error.html("<strong>Création du projet impossible.</strong>");
            break;
    	}

        if(div_error.hasClass("my_hidden")){
            div_error.removeClass("my_hidden")
                     .addClass("my_show")
                     .slideToggle("slow");
        }
    }


    function save_project_sync(project_id, project_type) {
        $.ajax({
            type: 'post',
            url: '<?php echo base_url('index.php/Save_ajax/project');?>',
            data: 'project_id=' + project_id + '&project_type=' + project_type,
            async: false,
            success: function (result) {
                console.log("result : ",result);
            },
            error: function (result, status, error){
                console.log(result);
                console.log(status);
                console.log(error);
                return false;
            }
        });
    }// /save_project_sync()


	function save_session_sync(name, value) {
		$.ajax({
			type: 'post',
			url: '<?php echo base_url('index.php/Save_ajax/session');?>',
			data: 'name=' + name + '&val=' + value,
			//contentType: "application/json; charset=utf-8",
			//traditional: true,
			async: false,
			success: function (result) {
				if(!result){
					console.log("sauvegarde en sesion de " + 'name=' + name + '&val=' + value + ':' + result);
					return false;
				}
				else{
					console.log("sauvegarde en session de " + 'name=' + name + '&val=' + value + ':' + result);
					return true;
				}
			},
			error: function (result, status, error){
				show_api_error(result, "error - save_session");
				return false;
			}
		});
	}// /save_session_sync()


    function call_api_upload(form, project_id) {
        $.ajax({
            url: '<?php echo BASE_API_URL;?>' + '/api/normalize/upload/' + project_id,
            type: "POST",
            data: form,
            crossDomain: true,
            processData: false,
            contentType: false,
            async: true, // TODO: check this (to avoid next page before uplload)
            success: function(result){
                file_name = form.get('file').name;
                console.log("Uploaded file ".concat(file_name));
            },
            error: function(er){
                show_api_error(er, "error - upload");
            }
        });
    }// /call_api_upload()


    function save_id_normalized_project(file_role, project_id) {
        console.log("save_id_normalized_project");
        console.log(file_role+"/"+project_id);

        var tparams = {
            "file_role": file_role,
            "project_id": project_id
        }

        $.ajax({
            type: 'post',
            dataType: "json",
            contentType: "application/json; charset=utf-8",
            url: '<?php echo BASE_API_URL;?>' + '/api/link/select_file/' + link_project_id,
            data: JSON.stringify(tparams),
            async: false,
            success: function (result) {
                if(result.error){
                    show_api_error(result, "API error - select_file");
                }
                else{
                    console.log("success - select_file");
                    console.dir(result);

                    if(file_role == "source"){
                        $('#txt_add_src_nrz_projects').css('display', 'inline');
                        $('#add_src_nrz_projects_ok').css('display', 'inline');
                    }
                    if(file_role == "ref"){
                        $('#txt_add_ref_nrz_projects').css('display', 'inline');
                        $('#add_ref_nrz_projects_ok').css('display', 'inline');
                    }
                }
            },
            error: function (result, status, error){
                show_api_error(result, "error - select_file");
                err = true;
            }
        });// /ajax - select_file
    }// /save_id_normalized_project()


    function add_new_normalize_project_src(tparams) {
        console.log("add_new_normalize_project_src");

        $.ajax({
            type: 'post',
            url: '<?php echo BASE_API_URL;?>' + tparams["url"],
            data: JSON.stringify(tparams["params"]),
            contentType: "application/json; charset=utf-8",
            traditional: true,
            async: false,
            success: function (result) {
                console.dir(result);

                if(result.error){
                    show_api_error(result, "API error - new normalize project");
                }
                else{
                    console.log("success");

                    // Récupération de l'identifiant projet
                    src_project_id = result.project_id;

                    $('#txt_init_nrz_src_project').css('display', 'inline');
                    $('#init_nrz_src_project_ok').css('display', 'inline');
                }
            },
            error: function (result, status, error){
                show_api_error(result, "error - new normalize project");
            }
        });// /ajax
    }// /add_new_normalize_project_src()


    function add_new_normalize_project_ref(tparams) {
        console.log("add_new_normalize_project_ref");

        $.ajax({
            type: 'post',
            url: '<?php echo BASE_API_URL;?>' + tparams["url"],
            data: JSON.stringify(tparams["params"]),
            contentType: "application/json; charset=utf-8",
            traditional: true,
            async: false,
            success: function (result) {
                if(result.error){
                    show_api_error(result, "API error - new normalize project ref");
                }
                else{
                    console.log("success");

                    // Récupération de l'identifiant projet
                    ref_project_id = result.project_id;

                    $('#txt_init_nrz_ref_project').css('display', 'inline');
                    $('#init_nrz_ref_project_ok').css('display', 'inline');
                }
            },
            error: function (result, status, error){
                show_api_error(result, "error - new normalize project ref");
            }
        });// /ajax
    }// /add_new_normalize_project_ref()


    function requirements() {

        error = false;
        var tab_error = new Array();

        // Récupération des valeurs
        var project_name = $("#project_name").val();
        var project_description = $("#project_description").val();

        // Le champ project_name doit être renseigné
        if(project_name == ""){
            tab_error.push('Veuillez renseigner le nom du projet.');
        }

        if(!new_file_src && !exist_file_src){
            tab_error.push('Vous devez sélectionner un fichier SOURCE.');
        }

        if(!new_file_ref && !exist_file_ref && !exist_ref){
            tab_error.push('Vous devez sélectionner un fichier REFERENTIEL.');
        }

        if($("#src_selection").html() == $("#ref_selection").html()){
            tab_error.push('Le fichier SOURCE et le fichier REFERENTIEL doivent être différents.');
        }

        //  test CGU
        if(!$("#chk_cgu").is(':checked')){
            // Affichage de la modale d'erreur CGU
            tab_error.push('Vous devez valider les <a href="<?php echo base_url("index.php/Home/cgu");?>" target="_blank">conditions générales d\'utilisation</a> afin de pouvoir commencer la création d\'un projet.');
        }

        if(exist_file_src){
            // recuperation de l'id du projet
            src_project_id = $("#src_project_id").html();
            if(src_project_id == ''){
                tab_error.push('Vous devez sélectionner un fichier SOURCE.');
            }
        }

        if(exist_file_ref || exist_ref){
            // recuperation de l'id du projet
            ref_project_id = $("#ref_project_id").html();
            if(ref_project_id == ''){
                tab_error.push('Vous devez sélectionner un fichier référentiel.');
            }
        }

        $("#errors").html("");
        if(tab_error.length > 0){
            for (var i = 0; i < tab_error.length; i++) {
                $("#errors").html($("#errors").html() + tab_error[i] + '<br>');
            }

            $("#modal_error").modal("show");
        }
        else{
            return true;
        }
    }// /requirements()


    function treatment() {

        var ret = requirements();
        if(!ret){
            return false;
        }

        var project_name = $("#project_name").val();
        var project_description = $("#project_description").val();

        // desactivation du bouton
        $("#bt_new_project").css("display", "none");

        // Appels API ----------------------
            $('#result').css('display', 'inherit');
            go_to('result'); // auto scroll

            // creation du projet
            var tparams = {
                "url": "/api/new/link",
                "params": {
                    "display_name": project_name,
                    "description": project_description,
                    "internal": false
                }
            }

            $.ajax({
                type: 'post',
                url: '<?php echo BASE_API_URL;?>' + tparams["url"],
                data: JSON.stringify(tparams["params"]),
                contentType: "application/json; charset=utf-8",
                traditional: true,
                async: false,
                success: function (result) {
                    if(result.error){
                        show_api_error(result, "API error - new/link");
                    }
                    else{
                        console.log("success - new/link");

                        // Récupération de l'identifiant projet
                        //project_id = result.project_id;
                        link_project_id = result.project_id;
                        console.log("project_id" + link_project_id);

                        var result_save = "";

                        console.log("treatment/save_session_synch");
                        result_save = save_session_sync("link_project_id", link_project_id);

                        // Sauvegarde du projet bdd
                        console.log("treatment/save_project_synch");
                        save_project_sync(link_project_id, 'link');

                        //
                        $('#txt_create_merge_project').css('display', 'inline');
                        $('#create_merge_project_ok').css('display', 'inline');
                    }
                },
                error: function (result, status, error){
                    show_api_error(result, "error - new/link");
                }
            });// /ajax


            // Ajout des projets de normalisation
            // Traitement du fichier SOURCE
                if(new_file_src && !error){
                    console.log('Creation du projet de normalisation (SOURCE)');

                    // Creation du projet de normalisation
                      var tparams = {
                            "url": "/api/new/normalize",
                            "params": {
                                "display_name": project_name + ' Fichier source',
                                "description": project_description + '',
                                "internal": false
                            }
                        }
                        add_new_normalize_project_src(tparams);

                        console.log("treatment/save_session_synch");
                        result_save = save_session_sync("src_project_id", src_project_id);

                        // Sauvegarde du projet en base si user authentifié
                        console.log("treatment/save_project_synch");
                        save_project_sync(src_project_id, 'normalize');

                        //$("#create_project_ok").slideToggle();

                    // Upload du fichier
                    url_src = '<?php echo BASE_API_URL;?>/api/normalize/upload/' + src_project_id;

                    $('#txt_send_src_file').css('display', 'inline');
                    $('#fileupload_src').fileupload(
                        'option',
                        'url',
                        url_src
                    );

                    $("#envoyer_src").click();


                }
                else if(exist_file_src && !error){
                    // Ajout du projet de normalisation au projet de link
                    save_id_normalized_project("source", src_project_id);

                    $('#send_src_analyse_wait').css('display', 'none');
                    $('#send_src_analyse_ok').css('display', 'inline-block');

                    // Le fichier est déjà uploadé
                    UL_fic_src = true;
                }
                else{
                    error = true;
                    console.log('Pas de sélection de fichier source');
                    alert('Veuillez sélectionner un fichier source');
                }
            // /Traitement du fichier SOURCE

            // Traitement du fichier REF
                if(new_file_ref && !error){
                    console.log('Creation du projet de normalisation (REF)');

                    // Creation du projet de normalisation
                      var tparams = {
                            "url": "/api/new/normalize",
                            "params": {
                                "display_name": project_name + ' Fichier référentiel',
                                "description": project_description + '',
                                "internal": false
                            }
                        }
                        add_new_normalize_project_ref(tparams);

                        console.log("treatment/save_session_synch");
                        result_save = save_session_sync("ref_project_id", ref_project_id);

                        // Sauvegarde du projet en base si user authentifié
                        console.log("treatment/save_project_synch");
                        save_project_sync(ref_project_id, 'normalize');

                        //$("#create_project_ok").slideToggle();

                    // Upload du fichier
                    url_ref = '<?php echo BASE_API_URL;?>/api/normalize/upload/' + ref_project_id;

                    $('#txt_send_ref_file').css('display', 'inline');
                    $('#progress_ref').css('display', 'inline-bloc');
                    $('#fileupload_ref').fileupload(
                        'option',
                        'url',
                        url_ref
                    );

                    $("#envoyer_ref").click();
                }
                else if(exist_file_ref && !error){
                    // Ajout du projet de normalisation au projet de link
                    save_id_normalized_project("ref", ref_project_id);

                    $('#send_ref_analyse_wait').css('display', 'none');
                    $('#send_ref_analyse_ok').css('display', 'inline-block');

                    // Le fichier est déjà uploadé
                    UL_fic_ref = true;
                }
                else if(exist_ref && !error){
                    // Ajout du projet de normalisation au projet de link
                    save_id_normalized_project("ref", ref_project_id);

                    $('#send_ref_analyse_wait').css('display', 'none');
                    $('#send_ref_analyse_ok').css('display', 'inline-block');

                    // Le fichier est déjà uploadé
                    UL_fic_ref = true;
                }
                else{
                    error = true;
                    console.log('Pas de sélection de fichier ref');
                    alert('Veuillez sélectionner un fichier ref');
                }
            // /Traitement du fichier REF

        // /Appels API ----------------------
    }// /treatment


    function valid_project(){
        console.log('valid_project');
        // MAJ du statut

        // Appel de l'étape suivante
        window.location.href = "<?php echo base_url('index.php/Project/link/');?>" + link_project_id;
    }// /valid_project()


    function select_project(project_id, project_name) {
        if(target){
            $("#" + target + "_project_id").html(project_id);
            $("#" + target + "_project_name").html(project_name);

            $("#" + target + "_selection").html(project_name);
        }

        $("#modal_projects").modal('hide');
    }// /select_project()


    function select_internal_ref(project_id, project_name) {
        // Appelé sur validation d'un projet interne dans la modale
        $("#ref_project_id").html(project_id);
        $("#ref_internal_project_name").html(project_name);

        $("#" + target + "_selection").html(project_name);

        exist_ref = true;

        $("#modal_ref").modal('hide');
    }// /select_internal_ref()


    // Init - Ready
    $(function() {
        url_src = '';
        url_ref = '';
        UL_fic_src = false;
        UL_fic_ref =  false;
        target = ''; // Utilisé pour la sélection d'un projet dans la modale

        $("#bt_new_project").click(function(e){
            console.log("bt_new_project");
            e.preventDefault();

            treatment();
        });

        $("#bt_modal_ref").click(function(){
            $('#modal_ref').modal('show');
        });


        $("#bt_select_project_src").click(function(){
            target = "src";
            $('#modal_projects').modal('show');
        });

        $(".bloc_project").hover(
            function(){// over
                $(this).css("background", "#eee");
                $(this).find(".chk").css("visibility", 'visible');
            },
            function(){// out
                $(this).css("background", "white");
                $(this).find(".chk").css("visibility", 'hidden');
            }
        );

        $("#bt_select_project_ref").click(function(){
            target = "ref";
            $('#modal_projects').modal('show');
        });


        $("#bt_modal_projects_ref").click(function(){
            target = "ref";
            $('#modal_projects').modal('show');
        });


        $("#bt_next").click(function(){
            valid_project();
        });


        $(".fileinput-button").click(function(){
            $(".fileinput-button").prop("disabled", true);

            $("#bt_normalizer").prop("disabled", false);
        });


        // Upload du fichier SOURCE
        $('#fileupload_src').fileupload({
            url: url_src,
            type:"POST",
            autoUpload: false,
            add: function (e, data) {
                $('#file_name_src').html(data.files[0].name);
                $('#src_selection').html(data.files[0].name);

                data.context = $('#envoyer_src')
                    .click(function (e) {
                        e.preventDefault();
                        $("#progress_src").css('display', 'inline-block');
                        $("#send_src_analyse").css('display', 'inline-block');
                        data.submit();
                    });
            },
            done: function (e, data) {
                console.log("upload src done");
                $('#send_src_analyse_wait').css('display', 'none');
                $('#send_src_analyse_ok').css('display', 'inline-block');

                // Ajout du nouveau projet de normalisation au projet de link
                save_id_normalized_project("source", src_project_id);

                // On indique que l'upload est terminé afin d'afficher le bouton "suivant"
                UL_fic_src = true;
            },
            progressall: function (e, data) {
                console.log("upload src progressall");
                var progress = parseInt(data.loaded / data.total * 100, 10);
                console.log('progress src : ' + progress);
                $('#progress_src .progress-bar').css('width', progress + '%');
                if(progress == 100){
                    console.log('SOURCE : analyse en cours');
                    $("#progress_src").css('display', 'none');
                    $('#send_src_file_ok').css('display', 'inline-block');
                    $('#send_src_analyse_wait').css('display', 'inline-block');
                }
            },
            fail: function (e, data) {
                console.log("upload src fail");
                console.log(e);
                console.log(data);
                $('#progress .progress-bar').css('background-color', 'red');
            }
        }).prop('disabled', !$.support.fileInput)
          .parent().addClass($.support.fileInput ? undefined : 'disabled');
        // /#fileupload_src'.fileupload()


        // Upload du fichier REF
        $('#fileupload_ref').fileupload({
            url: url_ref,
            type:"POST",
            autoUpload: false,
            add: function (e, data) {
                $('#file_name_ref').html(data.files[0].name);
                $('#ref_selection').html(data.files[0].name);

                data.context = $('#envoyer_ref')
                    .click(function (e) {
                         e.preventDefault();
                        $("#progress_ref").css('display', 'inline-block');
                        $("#send_ref_analyse").css('display', 'inline-block');
                        data.submit();
                    });
            },
            done: function (e, data) {
                console.log("upload ref done");
                $('#send_ref_analyse_wait').css('display', 'none');
                $('#send_ref_analyse_ok').css('display', 'inline-block');

                // Ajout du nouveau projet de normalisation au projet de link
                save_id_normalized_project("ref", ref_project_id);

                // On indique que l'upload est terminé afin d'afficher le bouton "suivant"
                UL_fic_ref = true;
            },
            progressall: function (e, data) {
                console.log("upload ref progressall");
                var progress = parseInt(data.loaded / data.total * 100, 10);
                console.log('progress ref : ' + progress);
                $('#progress_ref .progress-bar').css('width', progress + '%');
                if(progress == 100){
                    console.log('REFERENTIEL : analyse en cours');
                    $("#progress_ref").css('display', 'none');
                    $('#send_ref_file_ok').css('display', 'inline-block');
                    $('#send_ref_analyse_wait').css('display', 'inline-block');
                }
            },
            fail: function (e, data) {
                $('#progress_ref .progress-bar').css('background-color', 'red');
                console.log("upload ref fail");
                console.log(e);
                console.log(data);
            }
        }).prop('disabled', !$.support.fileInput)
          .parent().addClass($.support.fileInput ? undefined : 'disabled');
        // /#fileupload_ref'.fileupload()


        // Test de la creation des projets pour afficher le bouton "suivant"
        var handle = setInterval(function(){
            console.log('Test fin de traitement ...');
            if(UL_fic_src && UL_fic_ref){
                console.log('Fin de traitement OK');
                clearInterval(handle);

                // Affichage du bouton "suivant"
                $('#bloc_bt_next').css('display', 'inherit');
            }
        }, 1000);

        // Tooltip des étapes
        $(".add_selected_columns").attr('title','Etape de sélection des colonnes à traiter.');
        $(".replace_mvs").attr('title','Etape de traitement des valeurs manquantes.');
        $(".recode_types").attr('title','Etape de traitement des types.');
        $(".concat_with_init").attr('title','Etape finale d\'enrichissement et de téléchargement du fichier normalisé.');
        $('[data-toggle="tooltip"]').tooltip();
	}); // / Ready

</script>

</body>
</html>
