//Permet l'affichage du nom de l'image dans l'input
$('.custom-file-input').on('change', function(event) {
    let inputFile = event.currentTarget;
    $(inputFile).parent()
        .find('.custom-file-label')
        .html(inputFile.files[0].name);
});