const queryString = window.location.search;
console.log(queryString);
const urlParams = new URLSearchParams(queryString);

let nombreJuego= urlParams.get("juego");

let seccionJuego  = document.getElementById("nombreJuego");

seccionJuego.innerText= nombreJuego;