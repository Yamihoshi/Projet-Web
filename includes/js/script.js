function resetEditButton()
{
    var balise ='<button type="button" id="edit_profile">Editer les informations</button>';

    $("#editDiv").html(balise);
}

function resetInfos()
{
    $("#profile_name").html($("#editName").attr('previous'));
    $("#profile_statut").html($("#editStatut").attr('previous'));
    $("#profile_statut").html($("#editStatut").attr('previous'));

    var before=$("#profile_picture_IMG");
    $("#profile_photo").html(before);
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
            dataType:'json'
         });
    });
    //voir réponse
    $('.icon-bubble').on('click', function(event){
        var id =$(this).parents('article').attr('id');
        modalIni('Répondre', '<form id="RetouiterModalForm"><textarea placeholder="Entrez votre message..." name="touite" maxlength="140" required=""></textarea><input type="submit"></form>');
        $('#touiterModalForm').submit(function(event){
            event.preventDefault();
            $.ajax({
                type:"POST",
                url:"ajax.php",
                data:
                    {
                        id:id,
                        message:$('#RetouiterModalForm > textarea').val(),
                        discution:true
                    },
                dataType:'json'
             });
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
    $('#touite').on('submit', function(event){
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
        //$('#ongletSelect td:nth-child(1)').click();
    });


    $("#editDiv").on('click',"#cancelEdit",function()
    {
        resetEditButton();
        resetInfos();
    });

    $("#editDiv").on('click',"#saveEdit",function(event)
    {
      /* event.preventDefault();
        resetEditButton();
        updateInfos();
        $( "#editForm" ).submit();*/

       /* var form = new Object();
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
        });*/

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
                console.log("hollez");
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
            balise += '<form><fieldset><legend>Modification</legend>';
            balise +='<label for="editName">Pseudonyme</label><input id="editName" type="text" name="editName" previous="'+$("#profile_name").text()+'" value="'+$("#profile_name").text()+'">';
            balise += '<label for="editStatut">Description</label><textarea name="editStatut" form="editForm" placeholder = "Description..." id="editStatut" previous="'+$("#profile_statut").text()+'" >'+$("#profile_statut").text()+'</textarea>';
            

            var fileUploadDiv='<label for="profile_pic_upload">'+$("#profile_photo").html();
            fileUploadDiv+='</label>';
            fileUploadDiv+='<input  type="file" onchange="loadNewProfilePic(this)" style="display:none;" name="profile_pic_upload" id="profile_pic_upload" accept="image/x-png, image/gif, image/jpeg">';
            $('#profile_photo').html(fileUploadDiv);

            var select = '<select><option style="background-color:white">white</option>';
            select += '<option style="background-color:blue">blue</option>';
            select += '<option style="background-color:aliceblue">aliceblue</option>';
            select += '</select>';
            balise += select;
            
            balise +='<button id="cancelEdit" type="button"> Annuler</button>';
            balise+='<input type="submit" id="saveEdit" value="Enregistrer les modifications">';
            balise += '</fieldset></form>';

            balise +='</div>';
            $("#timeline").html(balise);
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


});