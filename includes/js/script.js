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

function loadNewProfilePic(input)
{
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#profile_picture_IMG').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
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
                    console.log("TEST");
                    location.reload(true); 
                }
                else{
                    $('.modal-footer').html('<div class="loginError">Login ou mot de passe incorrect.</div>');
                }
            }
        });
    });

    //suppression message
    $('.icon-bin2').on('click', function(event){
        var message =$(this).parents('article');
        $.ajax({
            type:"GET",
            url:"ajax.php",
            data:
                {
                    id:$(message).attr('id')
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
    $('#touite').on('submit', function(event){
        event.preventDefault();
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

        var fileUploadDiv='<label for="profile_pic_upload">'+$("#profile_photo").html();
        fileUploadDiv+='</label>';
        fileUploadDiv+='<input  type="file" onchange="loadNewProfilePic(this)" style="display:none;" name="profile_pic_upload" id="profile_pic_upload" accept="image/x-png, image/gif, image/jpeg">';
        $('#profile_photo').html(fileUploadDiv);

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
        form['file']=0;
        console.log(typeof(document.getElementById("profile_pic_upload").files[0]));
        if(typeof(document.getElementById("profile_pic_upload").files[0])!="undefined")
        {
            form['file']=1;
        }

        var data = new FormData();
        $.each(files, function(key, value)
        {
            data.append(key, value);
        });

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

    $("#ongletSelect td").click(function()
    {   
        /*
            0 -> Touites
            1 -> Suivi
            2 -> Suiveurs
        */

        var index = $('td').index(this);
        console.log(index);

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