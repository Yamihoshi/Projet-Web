function resetEditButton()
{
    var balise ='<button type="button" id="edit_profile">Editer les informations</button>';

    $("#editDiv").html(balise);
}

function resetInfos()
{
    $("#profile_name").html($("#editName").attr('previous'));
    $("#profile_statut").html($("#editStatut").attr('previous'));
}

function updateInfos()
{
    $("#profile_name").html($("#editName").val());
    $("#profile_statut").html($("#editStatut").val());
}

$(document).ready(function()
{
	//Appui de la touche Entrer -> activer recherche
	$("#searchBar").keyup(function(event){
    	if(event.keyCode == 13)
    	{
    		$.get("ajax.php",{search:$("#searchBar").val()},function(rep){
    			$("#pageDisplay").hide();
    			$("#pageDisplay").html(rep);
    			$("#pageDisplay").fadeIn('slow');
			});
    	}
	});
    function modalIni(name, html){
        $('.modal-header h2').html(name);
        $('.modal-body').html(html);
        $('.modal-footer').html('');
        $('#myModal').toggle();
    }
    $('#connexion').click(function(){
        modalIni('Connexion', '<form id="loginForm"><input type="text" id="login" name="login" placeholder="Login" required><input type="password" id="password" name="password" placeholder="Mot de passe" required><button type="submit">Se Connecter</button></form>');
    });
    $('#inscription').click(function(){
        modalIni('Inscription', '<form id="inscriptionForm"><input type="text" id="login" name="login" placeholder="Login" required><input type="password" id="password" name="password" placeholder="Mot de passe" required><input type="mail" name="mail" id="mail" placeholder="Adresse mail" required><button type="submit">Se Connecter</button></form>');
    });
    $('.close').click(function(){
        $('#myModal').toggle();
    });

    $('.modal').on('submit' , '#loginForm', function(event){
        event.preventDefault();
        $.ajax({
            type:"POST",
            url:"login.php",
            data:
                {
                    login:$('#login').val(),
                    password: $('#password').val()
                },
            dataType:'json',
            success: function(data){
                if(data.reussit){
                    location.reload(true); 
                }
                else{
                    $('.modal-footer').html('');
                    $('.modal-footer').html('<div class="loginError">Login ou mot de passe incorrect.</div>');
                }
            }
        });
    });
    $('.modal').on('submit' , '#inscriptionForm', function(event){
        event.preventDefault();
        $.ajax({
            type:"POST",
            url:"inscription.php",
            data:
                {
                    pseudo:$('#login').val(),
                    PWD: $('#password').val(),
                    mail: $('#mail').val()
                },
            dataType:'json',
            success: function(response, statut){
                if(response.reussit){
                    location.reload(true);
                    console.log("hey");
                }
                else{
                    $('.modal-footer').html('');
                    $('.modal-footer').html('<div class="loginError">Ce nom d\'utilisateur est déjà utilisé.</div>');
                }
            },
             error : function(resultat, statut, erreur){
                console.log(resultat + erreur);
            }
        });
    });
    $('#touite').on('submit', function(e){
        e.preventDefault();
        $.ajax({
            type:"POST",
            url:"ajax.php",
            data:
                {
                    message:$('#touite-box textarea').val()
                },
            dataType:'json'
        });
    });
    $("#editDiv").on('click',"#edit_profile",function()
    {

        $("#profile_name").html('<input id="editName" type="text" name="editName" previous="'+$("#profile_name").text()+'" value="'+$("#profile_name").text()+'">');
        $("#profile_statut").html('<textarea id="editStatut" previous="'+$("#profile_statut").text()+'" >'+$("#profile_statut").text()+'</textarea>');


        var balise ='<button id="cancelEdit" type="button"> Annuler</button>';
        balise+='<button type="button" id="saveEdit">Enregistrer les modifications</button>';

        $("#editDiv").html(balise);

    });

    $("#editDiv").on('click',"#cancelEdit",function()
    {
        resetEditButton();
        resetInfos();
    });

    $("#editDiv").on('click',"#saveEdit",function()
    {
        resetEditButton();
        updateInfos();

        var form = new Object();
        form['nom']=$("#profile_name").text();
        form['statut']=$("#profile_statut").text();

        $.post("ajax.php",{editProfile:form,touitos:$("#touitos_pseudo").val()},function(rep){
                $("body").append(rep);
        });

    });
    /*function calculerCaractere(){
        $('compteurCaractere').html(140-$('#touite-box textarea').val().lenght());
    }
    $('#touite-box textarea').on('change', function(){
        calculerCaractere();
    });*/

    $("#ongletSelect>li").click(function()
    {   
        /*
            0 -> Touites
            1 -> Suivi
            2 -> Suiveurs
        */

        var index = $('#ongletSelect').index(this);

        if(index==0)
        {

        }
        else if(index==1)
        {
            
        }
        else if(index==2)
        {
            
        }
        

    });


var nyan=0;

function nyanF()
{
    if(nyan==0)
    {
        $("#nyan_nyan img").attr("src","nyan_.jpg");
        $("#nyan_nyan img").css("height","480");
        $("#nyan_nyan img").css("width","480");
        nyan=1;
    }
    else
    {
        $("#nyan_nyan img").attr("src","nyan.jpg");
        $("#nyan_nyan img").css("height","720");
        $("#nyan_nyan img").css("width","480");
        nyan=0;
    }
}

window.setInterval(function(){
  /// call your function here
  $("#nyan_nyan img").hide();
  nyanF();
  $("#nyan_nyan img").animate({height:'toggle',width:'toggle'},600);

    setTimeout(function () {
    $("#nyan_nyan img").animate({height:'toggle',width:'toggle'},600);
    }, 2000);

}, 3000);




});