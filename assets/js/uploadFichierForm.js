//lancement JS sous reserve qu'un champ unload soit sur la page en question
if(document.querySelector('.custom-file-input') !== null){

    /**
     * Generation du nom de fichier uploadé dans le champ du form correspondant.
     * Inspiré par : 
     * https://www.w3schools.com/jsref/prop_fileupload_files.asp
     * https://stackoverflow.com/questions/19315948/how-to-insert-html-before-element-in-javascript-without-jquery#19316351
     * 
     */

    console.log('JS champ upload');
    //stockage elements input upload
    let boutonsChargement = document.querySelector('.custom-file-input');

    //definition du texte à charger sur la page
    let texteFile = '';


    //lancement écouteur qui déclanche une fn
    boutonsChargement.addEventListener('change', function(){

        console.log('fn lancée');
        //si l'element est bien un upload
        if ('files' in boutonsChargement) {
            //si il n'y a rien dedans
            if (boutonsChargement.files.length == 0) {
                console.log('input vide');
            } else {

                //boucle sur les fichiers présents
                for (let j = 0; j < boutonsChargement.files.length; j++) {

                    //recuperation du fichier j
                    let file = boutonsChargement.files;

                    //nom du ficher ajouté dans texteFile
                    if ('name' in file[j]) {
                        texteFile += file[j].name + ' ';
                    }

                    //poids du ficher ajouté dans texteFile
                    if ('size' in file[j]) {
                        texteFile += '' + file[j].size + ' bytes';
                    }
                }

                //chargement du texte généré dans un span avant le champ upload
                document.getElementById('livre_form_url_couverture').insertAdjacentHTML('beforebegin',
                `<span class="filenameInput">${texteFile}</span>`);
            }
        } 
    });
}