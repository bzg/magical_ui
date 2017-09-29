<img src="<?php echo base_url('assets/img/poudre.png');?>" class="poudre poudre_pos_home">

<div class="container" id="entete" style="margin-top: 20px;">
    <div class="well">
        <div class="row">
            <div class="col-sm-8">
                <h2 class="page_title"><span id="project_name1"></span> : <i>Apprentissage</i></h2>
            </div>
            <div class="col-sm-4 text-right">
                <a href="<?php echo base_url('index.php/Project/load_step4_infer_types');?>">Passer cette étape</a>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 page_explain">
                L'étape d'apprentissage va permettre à la machine de s'adapter au mieux à vos données. Des exemples vont vous être présentés,il vous suffira de répondre par "OUI" ou par "NON" en fonction de leur concordance.
                <br><br>
                Plusieurs indices vous donneront le taux de réussite estimé du traitement finale.
                <br>
                Indice de pécision :
                <br>
                Indice de rappel : Pourcentage de lignes considérée justes par rapport au nombre de lignes totales du fichier
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center">
                <button class="btn btn-success" id="bt_start">Commencer l'apprentissage</button>
            </div>
        </div>
    </div><!-- /well-->
</div><!--/container-->

<div class="container work" style="margin-top: 20px;">
    <div class="well">
        <div class="row">
            <div class="col-xs-12">
                <div class="row">
                    <div class="col-md-9">
                        <h2 style="margin-top: 0;display: inline-block;">
                            <span id="project_name2"></span> : <i>Apprentissage</i>
                        </h2>
                    </div>
                    <div class="col-md-3 text-right">
                        <a href="#" onclick="javascript:introJs().setOption('showBullets', false).start();">Didacticiel</a>
                        &nbsp;|&nbsp;
                        <a href="<?php echo base_url('index.php/Project/link');?>">Passer cette étape</a>
                    </div>
                </div><!-- / row-->
                <div class="row"  data-intro="Les filtres (sur le référentiel) permettent de rendre obligatoires ou d'interdire certains mots. Cela permet d'obtenir de meilleurs résultats sur le match. Cependant, le raffraichissement peut être un peu long.">
                    <div class="col-xs-12">
                        <h2>
                            <span class="step_numbers">1</span>
                            &nbsp;Filtres sur le référentiel
                        </h2>
                    </div>
                </div>
                <div class="row" data-intro="Spécifiez par colonne les termes obligatoires. TOUS les termes indiqués devront être présents dans les lignes du réfentiel proposées.">
                    <div class="col-xs-offset-1 col-xs-2" style="padding-top: 5px;">
                        Termes obligatoires
                    </div>
                    <div class="col-xs-9">
                        <input type="text" id="filter_plus" data-role="tagsinput" value="">
                        <button class="btn btn-default" id="bt_add_filter_plus">
                            <span class="glyphicon glyphicon-plus"></span>
                        </button>
                    </div>
                </div>
                <div class="row" data-intro="Spécifiez par colonne les termes interdits. AUCUN des termes indiqués ne devront devront être présents dans les lignes du réfentiel proposées.">
                    <div class="col-xs-offset-1 col-xs-2" style="padding-top: 5px;">
                        Termes à exclures
                    </div>
                    <div class="col-xs-9">
                        <input type="text" id="filter_minus" data-role="tagsinput" value="">
                        <button class="btn btn-default" id="bt_add_filter_minus">
                            <span class="glyphicon glyphicon-plus"></span>
                        </button>
                    </div>
                </div><!-- / row-->
<hr>
                <div class="row" data-intro="Indiquez nous si le match proposé est correct. La machine tente d'apprendre de ses erreurs; plus vous labellisez, meilleurs seront les résultats.">
                    <div class="col-xs-12">
                        <h2>
                            <span class="step_numbers">2</span>
                            &nbsp;Labellisation
                        </h2>
                        <div class="row">
                            <div class="col-xs-offset-1 col-xs-5 well">
                                La labellisation permet à la machine d'apprendre comment apparier les lignes entre elles. Vous devez indiquer si les paires proposées concordent (OUI) ou diffèrent (NON), ou si la ligne de la source n'a pas besoin d'être cherchée dans le référentiel (Oublier cette ligne (source)). La machine propose alternativemement les matchs les plus probables et des matchs qu'elle voit comme faux.
                                <div>
                                    Taux de précision souhaité : 
                                    <select>
                                        <option>Tout apparier</option>
                                        <option>Précision élevée (plus de résultats)</option>
                                        <option>Précision 100% (moins de résultats)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div id="message">
                                    <img src="<?php echo base_url('assets/img/wait.gif');?>" style="width: 50px;">
                                </div>
                                <div class="q_label">
                                    Ces informations sont-elle identiques ?
                                </div>
                                <div>
                                    <button class="btn btn-default btn-xl btn_2_3 yes_color" 
                                            onclick="socket_answer('y');" 
                                            id="bt_yes">
                                        <h2>OUI</h2>
                                    </button>
                                    <button class="btn btn-default btn-xl btn_2_3 no_color" 
                                            onclick="socket_answer('n');" 
                                            id="bt_no">
                                        <h2>NON</h2>
                                    </button>
                                    <button class="btn btn-default btn-xl btn_2_3 forgot_color" 
                                            onclick="socket_answer('n');" 
                                            id="bt_no">
                                        <h2>Oublier</h2>
                                    </button>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- / row-->
<hr>
                <div class="row" data-intro="Suivez ici les performances estimées. Quand celles çi sont satisfaisantes, passez à l'étape suivante">
                    <div class="col-xs-12">
                        <h2>
                            <span class="step_numbers">3</span>
                            &nbsp;Statistiques
                        </h2>
                    </div>
                    <div class="row">
                        <div class="col-xs-2">
                            <div class="stat">
                                <span class="title">Précision estimée</span>
                                <span class="number" id="stat_estimated_precision">0 %</span>
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <div class="stat">
                                <span class="title">Couverture estimée</span>
                                <span class="number" id="stat_estimated_recall">0 %</span>
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <div class="stat">
                                <span class="title">Avancement</span>
                                <span class="number" id="stat_real_ratio">0</span>
                            </div>
                        </div>

                        <div class="col-xs-6">
                            <div class="stat">
                                <span class="title">Historique des réponses</span>
                                <div class="history" id="stat_history">
                                    <table class="table">
                                        <tr class="history_yes">
                                            <th class="title">OUI</th>

                                            <td id="yes_1"></td>
                                            <td id="yes_2"></td>
                                            <td id="yes_3"></td>
                                            <td id="yes_4"></td>
                                            <td id="yes_5"></td>
                                            <td id="yes_6"></td>
                                            <td id="yes_7"></td>
                                            <td id="yes_8"></td>
                                            <td id="yes_9"></td>
                                            <td id="yes_10"></td>
                                            <td id="yes_11"></td>
                                            <td id="yes_12"></td>
                                            <td id="yes_13"></td>
                                            <td id="yes_14"></td>
                                            <td id="yes_15"></td>
                                            <th class="total" id="stat_yes">0</th>

                                            <th rowspan="2" class="history_all" id="stat_all">0</th>                                        
                                        </tr>
                                        <tr class="history_no">
                                            <th class="title">NON</th>

                                            <td id="no_1"></td>
                                            <td id="no_2"></td>
                                            <td id="no_3"></td>
                                            <td id="no_4"></td>
                                            <td id="no_5"></td>
                                            <td id="no_6"></td>
                                            <td id="no_7"></td>
                                            <td id="no_8"></td>
                                            <td id="no_9"></td>
                                            <td id="no_10"></td>
                                            <td id="no_11"></td>
                                            <td id="no_12"></td>
                                            <td id="no_13"></td>
                                            <td id="no_14"></td>
                                            <td id="no_15"></td>
                                            <th class="total" id="stat_no">0</th>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
<!--
                        <div class="col-xs-2">
                            <div class="stat">
                                <span class="title">Labellisation <span class="glyphicon glyphicon-plus"></span></span>
                                <span class="number" id="stat_yes">0</span>
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <div class="stat">
                                <span class="title">Labellisation <span class="glyphicon glyphicon-minus"></span></span>
                                <span class="number" id="stat_no">0</span>
                            </div>
                        </div>
-->
                    </div>
                </div><!-- / row-->

                <div class="row">
                    <div class="col-xs-12 text-center" id="blocs"></div>
                </div>
            </div>
        </div>    
    </div>
</div>

<div class="container" style="margin-bottom: 40px;">
    <div class="row">
        <div class="col-xs-12 text-right">
            <button class="btn btn-success" id="bt_next">Finir & Lancer le traitement >></button>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal_filter" tabindex="-1" role="dialog" aria-labelledby="modal_filter_title">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modal_filter_title">Ajout de filtres</h4>
            </div>
            <div class="modal-body">
            <form>
                <div class="form-group">
                    <label for="columns_filter">Colonne sur laquelle appliquer le filtre : </label>
                    <select class="form-control" id="columns_filter"></select>
                </div><!-- / form-group -->
                <div class="form-group">
                    <label for="text_filter">Filtre : </label>
                    <input type="text" class="form-control" placeholder="Text input" id="text_filter">
                </div><!-- / form-group -->
            </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-xs btn-warning" data-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-xs btn-success2" id="bt_add_filter">Ajouter la valeur</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

function get_metadata(project_type, project_id) {
    // Récupere les métadata via API

    var metadata = "";
    var ret = false;

    $.ajax({
        type: 'get',
        async: false,
        url: '<?php echo BASE_API_URL;?>' + '/api/metadata/' + project_type + '/' + project_id,
        success: function (result) {
            if(result.error){
                console.log("API error");console.log(result.error);
            }
            else{
                console.log("success - metadata");console.dir(result);
                ret = result.metadata;
            }
        },
        error: function (result, status, error){
            console.log(result);
            console.log(status);
            console.log(error);
        }
    });// /ajax metadata

    return ret;
}// / get_metadata


function get_column_matches(project_id) {
    var ret = false;

    var tparams = {
        "data_params": {
            "module_name": "es_linker",
            "file_name": "column_matches.json"
        }
    }

    $.ajax({
        type: 'post',
        dataType: "json",
        contentType: "application/json; charset=utf-8",
        url: '<?php echo BASE_API_URL;?>' + '/api/download_config/link/' + project_id_link + '/',
        data: JSON.stringify(tparams),
        async: false,
        success: function (result) {
            if(result.error){
                console.log("API error - download_config");
                console.log(result.error);
            }
            else{
                console.log("success - download_config");
                console.dir(result);
                ret = result.result;
            }
        },
        error: function (result, status, error){
            console.log("error - download_config");
            console.log(result);
        }
    });// /ajax - Download config

    return ret;
} // /get_column_matches()


function create_es_index_api() {

    var tparams = {
        "module_params": {
            "force": true
        }
    }

    $.ajax({
        type: 'POST',
        url: '<?php echo BASE_API_URL;?>' + '/api/schedule/create_es_index/' + project_id_link + '/',
        data: JSON.stringify(tparams),
        success: function (result) {

            if(result.error){
                console.log("API error - create_es_index_api");
                console.dir(result.error);
            }
            else{
                console.log("success - create_es_index_api");
                console.dir(result);

                // Appel 
                var handle = setInterval(function(){
                    $.ajax({
                        type: 'get',
                        url: '<?php echo BASE_API_URL;?>' + result.job_result_api_url,
                        success: function (result) {
                            if(result.completed){
                                clearInterval(handle);
                                console.log("success - job");
                                console.dir(result);

                                // Chargement du labeller
                                create_es_labeller_api();
                               
                            }
                            else{
                                console.log("success - job en cours");
                            }
                        },
                        error: function (result, status, error){
                            console.log("error");
                            console.log(result);
                            err = true;
                            clearInterval(handle);
                        }
                    });// /ajax - job
                }, 1000);
            }
        },
        error: function (result, status, error){
            console.log("error");
            console.log(result);
            err = true;
        }
    });// /ajax - create_es_labeller
}// create_es_labeller_api()


function create_es_labeller_api() {

    $.ajax({
        type: 'GET',
        url: '<?php echo BASE_API_URL;?>' + '/api/schedule/create_es_labeller/' + project_id_link + '/',
        success: function (result) {

            if(result.error){
                console.log("API error - create_es_labeller_api");
                console.dir(result.error);
            }
            else{
                console.log("success - create_es_labeller_api");
                console.dir(result);

                // Appel 
                var handle = setInterval(function(){
                    $.ajax({
                        type: 'get',
                        url: '<?php echo BASE_API_URL;?>' + result.job_result_api_url,
                        success: function (result) {
                            if(result.completed){
                                clearInterval(handle);
                                console.log("success - job");
                                console.dir(result);
                               
                                var answer_to_send = {'project_id': project_id_link}

                                console.log('socket.emit|load_labeller');
                                socket.emit('load_labeller', JSON.stringify(answer_to_send));
                                console.log('done');

                            }
                            else{
                                console.log("success - job en cours");
                            }
                        },
                        error: function (result, status, error){
                            console.log("error");
                            console.log(result);
                            err = true;
                            clearInterval(handle);
                        }
                    });// /ajax - job
                }, 1000);
            }
        },
        error: function (result, status, error){
            console.log("error");
            console.log(result);
            err = true;
        }
    });// /ajax - create_es_labeller
}// create_es_labeller_api()


function disabeled_buttons() {
    $("#bt_yes").attr("disabeled","disabeled");
    $("#bt_no").attr("disabeled","disabeled");
}// /disabeled_buttons()


function enabeled_buttons() {
    $("#bt_yes").removeAttr('disabled');
    $("#bt_no").removeAttr('disabled');
}// /enabeled_buttons()


function socket_on_message() {
    // Message provenant du serveur

    socket.on('message', function(data) {
        show_new_proposition(JSON.parse(data));
    });// / on
}// / socket_on_message()


function socket_answer(user_response) {
    // Envoi de la réponse utilisateur
    // Un nouveau message sera reçu par socket_on_message()

    disabeled_buttons();
    $("#message").html('<img src="<?php echo base_url('assets/img/wait.gif');?>" style="width: 50px;">');

    var response_to_send = {
        'project_id': project_id_link,
        'user_input': user_response
    }

    console.log('socket.emit|answer');
    socket.emit('answer', JSON.stringify(response_to_send));
    console.log('done');
} // / socket_answer()


function socket_update_filters(must, must_not) {
    // Envoi de la réponse utilisateur
    // Un nouveau message sera reçu par socket_on_message()
    //must = {'NOMEN_LONG': ['ass', 'association', 'sportive', 'foyer'], 'LIBAPET': ['conserverie']}
    var response_to_send = {
        'project_id': project_id_link,
        'must': must,
        'must_not': must_not
    }

    console.log('socket.emit|update_filters');
    socket.emit('update_filters', response_to_send);
    console.log('done'); 
} // / socket_update_filters()


function show_new_proposition(message) {
    // Affiche les propositions en fonction du fichier column_matches
    console.log('show_new_proposition');
    console.dir(message);

    var lines_html = "<table>";

    for (var i = 0; i < column_matches.length; i++) {

        // Retours SOURCE
        // Liste des colonnes associées
        var source_list = column_matches[i].source;

        var source = new Array();
        var source_keys = new Array();
        // Récupération de la valeur associée dans le message
        for (var j = 0; j < source_list.length; j++) {
            var key = source_list[j]; // ex departement
            var value = message["source_item"]["_source"][key];
            source.push(value);
            source_keys.push(key);
        }

        // Concatenation des libellés
        var lib_source_keys = source_keys.join(" | ");
        var lib_source_values = source.join(" | ");
        
        // Ecriture de la ligne Source
        lines_html += '<tr>';
        lines_html += '<td class="title">' + lib_source_keys + ' <i>(source)</i> :</td><td class="message">' + lib_source_values + '</td>';
        lines_html += '</tr>'; 


        // Retours REFERENTIEL
        // Liste des colonnes associées
        var ref_list = column_matches[i].ref;

        var ref = new Array();
        var ref_keys = new Array();
        // Récupération de la valeur associée dans le message
        for (var k = 0; k < ref_list.length; k++) {
            var key = ref_list[k];
            var value = message["ref_item"]["_source"][key];
            ref.push(value);
            ref_keys.push(key);
        }

        // Concatenation des libellés
        var lib_ref_keys = ref_keys.join(" | ");
        var lib_ref_values = ref.join(" | ");

        // Ecriture de la ligne Ref
        lines_html += '<tr>';
        lines_html += '<td class="title">' + lib_ref_keys + ' <i>(referentiel)</i> :</td><td class="message">' + lib_ref_values + '</td>';
        lines_html += '</tr>';
        lines_html += '<tr><td colspan="2" class="hr"></td></tr>';

    }

    // Affichage de la proposition
    /*
    for (var i = 0; i < source_keys.length; i++) {// 1 itération = 1 ligne Source + 1 ligne REF
        lines_html += '<tr>';
        lines_html += '<td class="title">' + source_keys[i] + ' <i>(source)</i> :</td><td class="message">' + source[source_keys[i]] + '</td>';
        lines_html += '</tr>';        
        lines_html += '<tr>';
        lines_html += '<td class="title">' + ref_keys[i] + ' <i>(referentiel)</i> :</td><td class="message">' + ref[ref_keys[i]] + '</td>';
        lines_html += '</tr>';
    }
    */
    lines_html += "</table>";

    // Affichage
    $("#message").html(lines_html);
    $("#stat_estimated_precision").html(show_stats(message.estimated_precision));
    $("#stat_estimated_recall").html(show_stats(message.estimated_recall));

    enabeled_buttons();
}// / show_new_proposition()


function show_stats(stat) {
    var ret = "";
    if(!stat){
       ret = '<span class="text">0 %</span>';
    }
    else {
        ret = Math.round(stat * 100);
        ret += " %";
    }

    return ret;
} // / show_stats()


function get_columns(metadata) {
    // Renvoie les colonnes présentent dans les métadata

    var all_columns = metadata['column_tracker']['original'];
    return all_columns;
}// / get_columns()


function complete_training() {
    var _to_send = {'project_id': project_id_link}

    console.log('socket.emit|complete_training');
    socket.emit('complete_training', JSON.stringify(_to_send));
    console.log('done'); 
}// / complete_training()


function valid_step() {
    // Validation du training
    complete_training();

    // Passage à l'étape suivante
    window.location.href = "<?php echo base_url('index.php/Project/link/');?>" + project_id_link;
}// / valid_step()


function add_columns_filter(columns) {
    // Ajoute les colonnes du référentiel à la modal d'ajout de filtres
    for (var i = 0; i < columns.length; i++) {
        $('#columns_filter').append($("<option></option>")
                            .attr("value",columns[i])
                            .text(columns[i])); 
    }
}// / add_columns_filter()


function show_modal_filter() {
    // Affiche la modale des filtres en la personnalisant en fonction de oblig ou excl

    if(modal_filter_sens == "oblig"){
        $("#modal_filter_title").html("Ajout des termes obligatoires");
    }
    else{
        $("#modal_filter_title").html("Ajout des termes à exclure");
    }

    // Affichage de la modale
    $('#modal_filter').modal('show');
}// / show_modal_filter()


function add_buttons() {
    // Ajout des boutons
    
    $("#bt_start").click(function(){
        $("#entete").css("display", "none");
        $(".work").fadeToggle();
        $("#bt_next").fadeToggle();
    });

    $("#bt_next").click(function(){
        valid_step();
    });

    $("#bt_add_filter_plus").click(function(){
        modal_filter_sens = "oblig";
        show_modal_filter();
    });

    $("#bt_add_filter_minus").click(function(){
        modal_filter_sens = "excl";
        show_modal_filter();
    });

    $("#bt_add_filter").click(function(){
        // Récupération de la colonne sélectionnée
        var column = $('#columns_filter option:selected').val();

        // Récupération du filtre
        var filter = $("#text_filter").val();

        // Ajout dans le bon tagsinput en fonction du bt cliqué initial (plus/minus)
        if(modal_filter_sens == "oblig"){
            sens = "plus";
        }
        else{
            sens = "minus";
        }

        var input_text = column + ":" + filter;

        // Ajout au tagsInput
        $("#filter_" + sens).tagsinput('add', input_text);

        // Fermeture de la modale
        $('#modal_filter').modal('hide');

        // Validation des filtres
        valid_filters();
    });

    $("#bt_yes").click(function(){
        stat_yes += 1;
        stat_all += 1;

        tab_stat_yes.push(1);
        tab_stat_no.push(0);

        update_stat();
    });
    $("#bt_no").click(function(){
        stat_no += 1;
        stat_all += 1;

        tab_stat_yes.push(0);
        tab_stat_no.push(1);

        update_stat();
    });
} // / add_buttons()

function update_stat() {
    // Compteurs
    $("#stat_yes").html(stat_yes);
    $("#stat_no").html(stat_no);
    $("#stat_all").html(stat_all);

    // Historiques
    // Yes
    var max = tab_stat_yes.length;
    if(max >= 15){
        max = 15;
    }
    var first = tab_stat_yes.length - max;
    max = first + max;
    var cpt = 1;
    for (var i = first; i < max; i++) {

        if(tab_stat_yes[i] == 1){
            $("#yes_" + cpt).html('<i class="fa fa-circle" aria-hidden="true"></i>');
            $("#no_" + cpt).html('&nbsp;');
        }
        else{
            html = '';
            $("#no_" + cpt).html('<i class="fa fa-circle" aria-hidden="true"></i>');   
            $("#yes_" + cpt).html('&nbsp;');
        }
        
        cpt ++;
    }
}// /update_stat()

function valid_filters() {
    // Traitement des termes obligatoires
    must = get_obj_filters($("#filter_plus").val()); 

    // Traitement des termes à exclures
    must_not = get_obj_filters($("#filter_minus").val());

    // Appel
    socket_update_filters(must, must_not);
} // / valid_filters()


function get_obj_filters(filter_list) {
    // Prend une liste string en entrée et retourne un objet structuré par colonne
    //{'NOMEN_LONG': ['ass', 'association', 'sportive', 'foyer'], 'LIBAPET': ['conserverie']}

    var tab_by_columns = new Array();

    // regroupement par colonne
    var tab_input_user = filter_list.split(",");
    for (var i = 0; i < tab_input_user.length; i++) {
        var tab_col_val = tab_input_user[i].split(":");
        
        var column_name = tab_col_val[0];
        var value = tab_col_val[1];

        if( column_name in tab_by_columns){
            tab_by_columns[column_name] = tab_by_columns[column_name] + ',' + value + '';
        }
        else {
            tab_by_columns[column_name] = '' + value + '';
        }
    }

    // Parcours du tableau pour renvoyer l'objet
    var obj = new Object();
    for(var key in tab_by_columns){
        obj[key] = [tab_by_columns[key]];
    }

    if(Object.keys(obj) == ""){
        return {};
    }

    return obj;
}// / get_obj_filters()

$(function(){// ready
    // Compteurs
    stat_yes = 0;
    stat_no = 0;
    stat_all = 0;

    // Historiques
    tab_stat_yes = new Array();
    tab_stat_no = new Array();

    $("body").css("height", $(window).height());

    modal_filter_sens = ""; // est utlisé pour savoir si l'on est en exclusion ou en label obligatoire (oblig, excl)

    // Ajout des boutons
    add_buttons();

    project_id_link = "<?php echo $_SESSION['link_project_id'];?>";

    // Récupération des metadata du projet de link en cours
    metadata_link = get_metadata('link', '<?php echo $_SESSION['link_project_id'];?>');

    // MAJ du nom du projet
    $("#project_name1").html(metadata_link.display_name);
    $("#project_name2").html(metadata_link.display_name);

    // Récupération des ids des projets de normalisation
    project_id_src = metadata_link['files']['source']['project_id'];
    project_id_ref = metadata_link['files']['ref']['project_id'];

    // Récupérartion des métadata du fichier source
    metadata_src = get_metadata('normalize', project_id_src);

    // Récupérartion des métadata du fichier referentiel
    metadata_ref = get_metadata('normalize', project_id_ref);

    // Récupération des colonnes référentiel
    var columns_ref = get_columns(metadata_ref);

    //Ajoute les colonnes du référentiel à la modal d'ajout de filtres
    add_columns_filter(columns_ref);
    
    // Récupération des matches
    column_matches = get_column_matches();

    // Connect to socket
    // var socket = io.connect('http://' + document.domain + ':' + location.port + '/');
    socket = io.connect('<?php echo BASE_API_URL;?>');

    // Création des indexs Elastic Search
    create_es_index_api();

    // Ecoute socket
    socket_on_message();

});//ready
</script>
