function htmlEncode(str) {
    return String(str)
        .replace(/&/g, '&amp;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#39;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;');
}

function loadNewProfilePic(input)
{
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#profile_picture_forUpload').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
}

function getNewMessage()
{
    

    $.get("ajax.php",{numberNewMessage:true},function(rep){
        $("#notViewedCounter").html("");
        if(rep!=0)
            $("#notViewedCounter").html("("+rep+")");
    });
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
        modalIni('Inscription', '<form id="inscriptionForm"><input type="text" id="login" name="login" placeholder="Login" required><input type="password" id="password" name="password" placeholder="Mot de passe" required><input type="mail" name="mail" id="mail" placeholder="Adresse mail" required><button type="submit">S\'inscrire</button></form>');
    });
    $('#touiter').click(function(){
        modalIni('Touiter', '<form id="touiterModalForm"><textarea placeholder="Entrez votre message..." name="touite" maxlength="140" required=""></textarea><input type="submit"></form>');
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
                    $('.modal-footer').html('<div class="loginError">Login ou mot de passe incorrect.</div>');
                }
            }
        });
    });

    $('.modal').on('submit' , '#touiterModalForm', function(event){
        event.preventDefault();
        $.ajax({
            type:"POST",
            url:"ajax.php",
            data:
                {
                    message:$('#touiterModalForm textarea').val()
                },
            dataType:'json',
            success:function(response, status){

            }
        });

    });

    $('.icon-undo2').on('click', function(event){
        var message =$(this).parents('article');
        $.ajax({
            type:"GET",
            url:"ajax.php",
            data:
                {
                    id:$(message).attr('id'),
                    voirMessage:true
                },
                success:function(response, status){
                    $(message).append(response);
            }
         });
    });
    //voir réponse
    $('.icon-bubble').on('click', function(event){
        var id =$(this).parents('article').attr('id');
        modalIni('Répondre', '<form id="RepondreModalForm"><textarea placeholder="Entrez votre message..." name="touite" maxlength="140" required=""></textarea><input type="submit"></form>');
        $('#RepondreModalForm').submit(function(event){
            event.preventDefault();
            $.ajax({
                type:"POST",
                url:"ajax.php",
                data:
                    {
                        id:id,
                        message:$('#RepondreModalForm > textarea').val(),
                        discution:true
                    },
                dataType:'html'
             });
         });
    });

    //suppression message
    $("#pageDisplay").on("click",".icon-bin2",function(event){
        var message =$(this).parents('article');
        $.ajax({
            type:"GET",
            url:"ajax.php",
            data:
                {
                    id:$(message).attr('id'),
                    remove:true
                },
            dataType:'json'
         });
        $(message).remove();
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
                if(!response.validMail)
                {
                    $('.modal-footer').html('<div class="loginError">Un compte associé à ce mail existe déjà</div>');
                }
                else if(!response.validPseudo){
                    $('.modal-footer').html('<div class="loginError">Ce nom d\'utilisateur est déjà utilisé.</div>');
                }
                else{
                    location.reload(true);
                }
            },
             error : function(resultat, statut, erreur){
                console.log(resultat + erreur);
            }
        });
    });
    $("#pageDisplay").on("click",'#touite', function(event){
        if(event.target.type=='submit')
        {
            event.preventDefault();
            $.ajax({
                type:"POST",
                url:"ajax.php",
                data:
                    {
                        message:$('#touite-box textarea').val()
                    },
                success:function(response){
                    //$('#ongletSelect td:nth-child(1)').click();
                    $("#touiteList").html(response+$("#touiteList").html());
                    $("#touiteArea").val("");
                }
            });
        }
    });

    /*function calculerCaractere(){
        $('compteurCaractere').html(140-$('#touite-box textarea').val().lenght());
    }
    $('#touite-box textarea').on('change', function(){
        calculerCaractere();
    });*/

    $("#ongletSelect td").click(function()
    {   
        /*
            0 -> touites
            1 -> Suivi
            2 -> Suiveurs
        */

        var index = $('td').index(this);


        if(index==0)
        {
            $.get("ajax.php",{getTimeline:true},function(rep){
                $("#timeline").html(rep);
            });
        }
        else if(index==1)
        {
            $.get("ajax.php",{getSuivi:true},function(rep){
                $("#timeline").html(rep);
            });
        }
        else if(index==2)
        {
            $.get("ajax.php",{getFollowers:true},function(rep){
                $("#timeline").html(rep);
            });
        }
        else if(index == 3){

            var balise = '<div id="edit">';
            balise+='<form id="editForm" action="'+window.location.href+'" method="POST" enctype="multipart/form-data" >';
            balise += '<fieldset><legend>Modification</legend>';
            balise +='<p><label class="modif" for="editName">Nom</label><input id="editName" type="text" name="editName" value="'+htmlEncode($("#profile_name").text())+'"></p>';
            balise += '<p><label class="modif" for="editStatut">Description</label><textarea name="editStatut" form="editForm" placeholder = "Description..." id="editStatut" >'+$("#profile_statut").text()+'</textarea></p>';
            
            var fileUploadDiv='<p><label for="profile_pic_upload">Photo';
            fileUploadDiv+='<div id="profile_photo_uploadDiv" class="modif modif_left"></div></label></p>';
            fileUploadDiv+='<p><input  class="modif_left" type="file" onchange="loadNewProfilePic(this)" style="display:none" name="profile_pic_upload" id="profile_pic_upload" accept="image/x-png, image/gif, image/jpeg"></p>';
            balise+=fileUploadDiv;

            var select = '<p><label class="modif" for="editColor">Couleur Fond</label><select id="editColor" name="editColor"><option style="background-color:white" value="white">white</option>';
            select += '<option value="blue" style="background-color:blue">blue</option>';
            select += '<option value="aliceblue" style="background-color:aliceblue">aliceblue</option>';
            select += '</select></p>';
            balise += select;
            select = '<p><label class="modif" for="editPolice">Police</label><select name="editPolice" id="editPolice"><option value="Arial">Arial</option>';
            select += '<option value="Verdana">Verdana</option>';
            select += '<option value="Georgia">Georgia</option>';
            select += '<option value="Impact">Impact</option>';
            select += '</select></p>';
            balise += select;
            balise+='<input type="submit" id="saveEdit" value="Enregistrer les modifications">';
            balise+='<span><button id="deleteAccount" type="button">Supprimer le compte</button></span>';
            balise += '</fieldset>';

            balise +='</form></div>';
            $("#timeline").html(balise);

            var $img = $("#profile_photo").children("img").clone();
            $img.attr("id","profile_picture_forUpload");

            $("#profile_photo_uploadDiv").append($img);
        }
    });

    $('#pageDisplay').on("click","#deleteAccount",function(){

        modalIni('Confirmer la suppression', '<label for="password">Entrez votre mot de passe</label><input type="password" id="password" name="password" placeholder="Mot de Passe" required><button id="confirmAccountSuppression" type="button">Confirmer</button>');

    });

    $('#myModal').on("click","#confirmAccountSuppression",function(){
        $.post("ajax.php",{deleteAccount:true,password:$("#password").val()},function(rep){
            if(rep!='OK')
                $("#confirmAccountSuppression").parents('.modal-content').find('.modal-footer').html(rep);
            else
                window.location.replace("logout.php");
        });
    });

    $('#pageDisplay').on("click",".subscribe",function(){

        $.post("ajax.php",{suivi:$(this).attr("idtouitos"),follow:true},function(rep){
        });

        $(this).removeClass("subscribe");
        $(this).prop( "disabled", true );
        $(this).html("En attente d\'une réponse");
    });

    $('#pageDisplay').on("click",".unsubscribe",function(){

        $.post("ajax.php",{suivi:$(this).attr("idtouitos"),unfollow:true},function(rep){
        });

        $(this).addClass("subscribe");
        $(this).removeClass("unsubscribe");
        $(this).html("Suivre");
    });

    $('#pageDisplay').on("mouseover",".unsubscribe",function(){
        $(this).removeClass("followed");
        $(this).html("Ne plus suivre");
    });

    $('#pageDisplay').on("mouseleave",".unsubscribe",function(){
        $(this).addClass("followed");
        $(this).html("Abonné");
    });

    $('#pageDisplay').on("click","#acceptRequest",function(){
        $.post("ajax.php",{suiveur:$(this).attr("touitosid"),acceptRequest:true},function(rep){
        });

        $("#requestButton").html("Accepté");
    });

    $('#pageDisplay').on("click","#refuseRequest",function(){
        $.post("ajax.php",{suiveur:$(this).attr("touitosid"),acceptRequest:false},function(rep){
        });

        $("#requestButton").html("Refusé");
    });

    $("#loadMoreNewsTouite").click(function(){
        
        var nextPage=parseInt($(this).attr("next"));

        $.get("ajax.php",{moreNewsTouite:true,offset:nextPage},function(rep){
            nextPage++;
            $("#loadMoreNewsTouite").attr("next",nextPage);
             $("#news").hide();
            $("#news").append(rep);
            $("#news").fadeIn();
        });
    });

    $("#pageDisplay").on("click","#loadMoreProfileTouite",function(){
        
        var nextPage=parseInt($("#loadMoreProfileTouite").attr("next"));
        var id=parseInt($(this).attr("idtouitos"));

        $.get("ajax.php",{moreProfileTouite:true,offset:nextPage,id:id},function(rep){
            nextPage++;
            $("#loadMoreProfileTouite").attr("next",nextPage);
             $("#touiteList").hide();
            $("#touiteList").append(rep);
            $("#touiteList").fadeIn();
        });
    });

    $("#pageDisplay").on("click","#moreSearchResult",function(){
        
        var nextPage=parseInt($("#moreSearchResult").attr("next"));
        var search=$("#searchBar").val();

        $.get("ajax.php",{moreSearch:true,offset:nextPage,search:search},function(rep){
            nextPage++;
            $("#moreSearchResult").attr("next",nextPage);
             $("#searchResult").hide();
            $("#searchResult").append(rep);
            $("#searchResult").fadeIn();
        });
    });

    $("#pageDisplay").on("click",".unAcceptRequest",function(){

        var id=parseInt($(this).attr("idtouitos"));
        $.post("ajax.php",{unAcceptRequest:true,suiveur:id},function(rep){
            
        });
    });

    $(".contactRow").click(function()
    {
        var id=$(this).attr("idtouitos");

        $.get("ajax.php",{discussion:true,destinataire:id},function(rep){
            $("#discussionDisplay").html(rep);
        });
    });

    $("#pageDisplay").on("click","#sendDiscussion",function()
    {
        var id=$(this).attr("replyto");
        var message = $("#discussionAnswer").val();

        $.post("ajax.php",{sendDiscussion:true,destinataire:id,message:message},function(rep){
            $("#discussionMessage").append(rep);
            $("#discussionAnswer").val("");
        });
    });

    setInterval(getNewMessage, 10000);

});