window.addEventListener('load', () => {    

// Trigger aos event if you havent scrolled
AOS.init({
    offset: 1,
});

// On recupere la div qui est le conteneur du dropdown
let dropdown_content = document.getElementById("dropdown-content");


/**
 * Le but de cette fonction est de faire en sorte que lorsque le dropdown est actif on 
 * on puisse cliquer n'importe ou dans le fenetre pour le "désactiver"
 *
 * @return {undefined} 
*/
function handle_removal() {
    //console.log(dropdown_content)
    // On enleve la classe flex pour le masquer
    dropdown_content.classList.remove("flex");
    // On enleve le listenner, sinon la prochaine fois qu'on cliquera sur
    // le dropdown cette fonction sera executée, et donc le dropdown
    // sera immédiatement masqué
    window.removeEventListener("click", handle_removal);
}

// Quand on clique sur le dropdown
document.getElementById("dropdown").addEventListener("click", () => {

    // On l'affiche ou on le masque
    dropdown_content.classList.toggle("flex");
    
    // On déclenche le truc qui permet de masquer le dropdown si on clique 
    // n'importe ou dans la fenetre

    // Si le dropdown est actif (il contient la classe flex qui l'affiche)
    if(dropdown_content.classList.contains("flex")) {
        // On attend un peu, sinon le window.addEventListenner se déclenche directement
        // puisqu'on vient de CLIQUER sur le dropdown pour l'activer
        setTimeout(() => {
            // On déclenche la fonction qui permet de handle le fait de masquer le dropdown
            // au click n'importe ou dans la fenetre
            window.addEventListener("click", handle_removal);
        }, 50);
    }
});


});

