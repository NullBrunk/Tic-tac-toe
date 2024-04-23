// THIS IS A SPECIFIC JS FILE THAT IS INCLUDED ONLY IN THE PROFILE PAGE

function sleep(ms) {
  return new Promise(resolve => setTimeout(resolve, ms));
}


/**
 * Au lieu d'afficher directement 10, afficher 0 puis attendre 100ms puis 2 puis 3 
 * jusqu'a 10
 * 
 * @param  {integer} start      En général 0, c'est le nombre dont on part
 * @param  {integer} end        Le nombre auquel on souhaite arriver (dans notre exemple c'était 10)
 * @param  {HTMLElement} elem   L'élement HTML qui contiendra le nombre a afficher
 * 
 * @return {boolean}       
 */
function animated_counter(start, end, elem) {
    // On attend 100 ms
    sleep(100).then(() => {
        // On modifie l'élement HTML pour y placer notre nombre
        elem.innerHTML = start

        // Si start vaut end on arrete la récursion
        if(start >= end) {
            return true
        }

        // Sinon on rappelle la fonction en augmentant la valeur de start
        return animated_counter(++start, end, elem);
    });
}

// Les id des éléments à animer
let ids = [ "won", "lost", "drawn" ];

// On parcourt le tableau
ids.forEach((id) => {
    // On recupere l'element
    let elem = document.getElementById(id);
    // On recupère le nombre auquel on souhaite arriver,
    // il est passé par un data attribute
    let stat = elem.dataset.stat;

    // On appelle la fonction récursive pour animer le tout
    animated_counter(0, stat, elem);
});

