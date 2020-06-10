//Permet l'affichage du nom de l'image dans l'input
$(".custom-file-input").on("change", function(event) {
    let inputFile = event.currentTarget;
    $(inputFile)
        .parent()
        .find(".custom-file-label")
        .html(inputFile.files[0].name);
});

// fonction pour la pop-in envoyer un message.
$(document).ready(function() {
    //On écoute le "click" sur le bouton ayant la classe "modal-trigger"
    $(".modal-trigger").click(function() {
        //On initialise les modales materialize
        $(".modal").modal();
        //On récupère l'url depuis la propriété "Data-target" de la balise html a
        url = $(this).attr("data-target");
        //on fait un appel ajax vers l'action symfony qui nous renvoie la vue
        $.get(url, function(data) {
            //on injecte le html dans la modale
            $(".modal-content").html(data);
            //on ouvre la modale
            $("#modal1").modal("show");
        });
    });
});

//Au clique sur n'importe quel image pour l'agrandir
$(".img-container img").on("click", function() {
    // On met temporairement le src de la grande image dans une variable
    let tmp = $(".grde-img").attr("src");

    //On utilise $(this).attr('src') pour recuperer le src sur lequel on a cliqué
    //Et on le met dans le src de la grande image
    $(".grde-img").attr("src", $(this).attr("src"));

    //Et on met l'ancien src qui se trouve dans tmp, dans le src de l'image sur laquelle on viens de cliquer
    $("this").attr("src", tmp);
});


// Pour le filtre en ajax
$("#formulaire-de-tri").on("submit", function(e) {
    e.preventDefault();
    let data = $(this).serialize(); // Récupère les données de chaque champ
    $.ajax({
        url: "/accueil/public/ajax",
        type: "POST",
        data: data, // On désire recevoir du HTML
        success: function(code_html, statut) {
            // code_html contient le HTML renvoyé
            $("#content").html(code_html);
        },
        error: function(resultat, statut, erreur) {},
    });
});

//cache le bouton envoyer du modale
$("#btnSend").hide();
$('#customSwitch1').on("click", function() { //fonction qui écoute un click sur le checkbox

    if ($('#customSwitch1').is(':checked')) { //vérifie si le checkbox est coché
        $("#btnSend").show(); //affiche le bouton envoyer si checkbox est coché
    } else {
        $("#btnSend").hide(); //sinon le laisse caché
    }
});