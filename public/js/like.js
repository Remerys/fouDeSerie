/* lesLiens contient la liste des éléments <a> correspond au lien avec le pouce, le nombre de like et le j'aime */
var lesLiens = document.getElementById('likes')
/* on parcourt les éléments que l'on vient de récupérer et pour chacun d'entre eux on écoute l'événement click et on appelle la fonction majLike lorsque l'événement se produit */
for (var i = 0; i < lesLiens.length; i++) {
    addEventListener('click', majlike())
}

function majLike(event) {
    /* On annule l'action par défaut correspondant à l'événement. Normalement  quand on clique sur un lien , cela entraîne directement une nouvelle requête  http. Or dans notre cas, on ne veut pas que la requête s'exécute pour afficher  une page contenant le json*/
    event.preventDefault()
    //On instancie un objet XMLHttpRequest
    let xhr = new XMLHttpRequest();
    /* On récupère l'URL du lien. Attention l'élément sur lequel se produit l'événement ne correspond pas à la balise <a> mais à la balise <i> ou une des balises <span> */
    /* utiliser la propriété parentNode pour récupérer le parent de l'élément sur lequel s'est produit l'événement c’est-à-dire la balise <a> */
    let baliseA = document.getElementById('likes')
    //On récupère la valeur de l'attribut href
    let url = lesLiens.href
    //On initialise notre requête avec open()
    xhr.open("_______", _______________);
    //On indique le format de la réponse
    xhr.responseType = "json"
    //On envoie la requête
    xhr.send();
    //Dès que la réponse est reçue...
    xhr.onload = function () {
        //Si le statut HTTP n'est pas 200...
        if (xhr.status != 200) {
            //...On affiche le statut et le message correspondant
            alert("Erreur " + xhr.status + " : " + xhr.statusText)
            //Si le statut HTTP est 200
        } else {
            /* si l'élément sur lequel s'est produit l'événement est le 1er  enfant de l'élément <a> , cela signifie qu'on a cliqué sur le   pouce et il faut donc mettre à jour l'élément suivant contenant le   nombre de like (avec la réponse au format json) */
            if (event.target == baliseA.firstElementChild) {
                event.target.nextElementSibling.textContent = xhr.response.likes
            } else {
                /* si l'élément sur lequel s'est produit l'événement est le   dernier enfant de l'élément <a> , cela signifie qu'on a cliqué   sur le "j'aime et il faut donc mettre à jour l'élément   précédent contenant le nombre de like */
            }

            if (___________________________________________) {
                _______________________________________________________
            } else {
                /* dans les autres cas, l'élément sur lequel s'est produit   l'événement est l'élément contenant le nombre de like qu'il   faut donc mettre à jour l'élément */
            }
            _____________________________________________________
        }
    }
    //Si la requête n'a pas pu aboutir...
    xhr.onerror = function () {
        alert("La requête a échoué")
    }
}