function resetEditButton()
{
    var balise ='<input id="edit_profile" class="connectButton" type="button" value="Editer les informations">';

    $("#editDiv").html(balise);
}

function resetInfos()
{
    $("#profile_name").html($("#touitos_pseudo").val());
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

    $("#editDiv").on('click',"#edit_profile",function()
    {

        $("#profile_name").html('<input id="editName" type="text" name="editName" value="'+$("#profile_name").text()+'">');
        $("#profile_statut").html('<textarea id="editStatut" previous="'+$("#profile_statut").text()+'" >'+$("#profile_statut").text()+'</textarea>');


        var balise ='<input id="cancelEdit" class="cancelButton" type="button" value="Annuler">';
        balise+='<input id="saveEdit" class="validateButton" type="button" value="Enregistrer les modifications">';

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
  $("#nyan_nyan img").animate({height:'toggle',width:'toggle'},600)
}, 2000);




});