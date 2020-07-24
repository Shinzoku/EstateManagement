//Permet l'affichage du nom de l'image dans l'input
$(".custom-file-input").on("change", function(event) {
    let inputFile = event.currentTarget;
    $(inputFile)
        .parent()
        .find(".custom-file-label")
        .html(inputFile.files[0].name);
});

//Au clique sur n'importe quel image pour l'agrandir
$(".img-container img").on("click", function() {
    // On met temporairement le src de la grande image dans une letiable
    let tmp = $(".grde-img").attr("src");

    //On utilise $(this).attr('src') pour recuperer le src sur lequel on a cliqué
    //Et on le met dans le src de la grande image
    $(".grde-img").attr("src", $(this).attr("src"));

    //Et on met l'ancien src qui se trouve dans tmp, dans le src de l'image sur laquelle on viens de cliquer
    $("this").attr("src", tmp);
});

//fonction pour le graphique
$(window).on('load', function() {
    let datas = $('.js-locataires-data').data(); //récupération des données 
    x = []
    y = []
    $.each(datas, function(i, data) {
        $.each(data, function(d, val) {
            x[d] = val['locataire']
            y[d] = val['mois']
        })
    })

    let ctx = document.getElementById('myChart').getContext('2d');
    let chart = new Chart(ctx, { // The type of chart we want to create
        type: 'bar',

        // The data for our dataset
        data: {
            labels: y,
            datasets: [{
                label: 'Nombre de nouveau Locataire du mois',
                backgroundColor: 'rgba(231,130,0,0.8)',
                data: x
            }]
        },

        // Configuration options go here
        options: {
            title: {
                display: true,
                text: "Fréquence des nouveaux Locataires en 2020",
                fontSize: 18,
                fontColor: "#000"
            },
            legend: {
                display: true,
                labels: {
                    fontColor: 'rgb(0, 0, 0)',
                }
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true, //permet de commencer par 0
                        stepSize: 1 //permet avec cette precision d'afficher que les nombre entier de un en un
                    }
                }]
            }
        }
    });
});