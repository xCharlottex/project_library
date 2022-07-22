
// on defini les variables body et button
// grace à leurs classes selectionnées
const body = document.querySelector(".body-js");
const button = document.querySelector(".buttonN");
// si le localstorage est pris par le mode nuit , l'ensemble body est nuit
if (localStorage.getItem('nightjs') === 'true') {
body.classList.add('nightjs')
}
// fonction ou on ecoute si le click du bouton se produit
button.addEventListener('click', function (){

    // si, le click est activé
    if(body.classList.contains("nightjs")){
// on active le mode nuit, et tant que ca ne re click pas on le garde dans le localstorage
        body.classList.remove("nightjs");
        localStorage.removeItem('nightjs');
    } else {
        // sinon, on enleve le mode nuit 
        body.classList.add("nightjs");
        localStorage.setItem('nightjs', 'true');
    }
});




