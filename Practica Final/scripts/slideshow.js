let slideIndex = [0,0]; //empezamos con el index 0
let slideId = ["mySlides1", "mySlides2"]
let slideSrc =[[
"imagenes/god_of_war.webp",
"imagenes/infamous.jpg",
"imagenes/infamous-second-son.jpg",
"imagenes/infamous-2.webp",
"imagenes/prototype.webp",
"imagenes/Spider-Man.jfif" 
],[
  "imagenes/god_of_war.webp",
  "imagenes/infamous.jpg",
  "imagenes/infamous-second-son.jpg",
  "imagenes/infamous-2.webp",
  "imagenes/prototype.webp",
  "imagenes/Spider-Man.jfif" 
]]; //para cambiarle el src de la foto dinamicamente

let slideTitle =[[
"God Of War",
"Infamous",
"Infamous Second Son",
"Infamous 2",
"Prototype",
"SpiderMan"
],
[
"God Of War",
"Infamous",
"Infamous Second Son",
"Infamous 2",
"Prototype",
"SpiderMan"
]
];

mostrar(0, 0);
mostrar(0,1);
//showSlides(1, 1);

function plusSlides(n, no) {
    let x = document.getElementsByClassName(slideId[no]);
    mostrar(slideIndex[no] += n, no);
}


function mostrar(n, no) { //n es el index de donde empieza a mostrar imagenes 
  let i;
 
  let slides =  document.getElementsByClassName(slideId[no]); //cogemos los elementos que se llamen slides 1
  //hay que recorrer los 4 elementos que existen con ese id y cambiarle los atributos src a las imagenes que contienen.
  
  for(i=0;i<4;i++){
    let imagen=   slides[i].getElementsByTagName("img")[0];
    let titulo = slides[i].getElementsByTagName("p")[0];
    let indexSlide =  (((n+i)%slideSrc[no].length) + slideSrc[0].length)%slideSrc[0].length; //hace falta controlar los valores negativos
    
    imagen.src= slideSrc[no][indexSlide];
    titulo.innerText = slideTitle[no][indexSlide];
    console.log((n+i)%slideSrc[no].length);

  }
}

function irAJuego(enlace){
    let nombreJuego= enlace.getElementsByClassName("tituloPeq")[0].innerText;
    console.log("queremos ir a: " + nombreJuego);
    window.location.href = "juego.html?juego="+nombreJuego;

}