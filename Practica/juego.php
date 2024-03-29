<!DOCTYPE html>
<html>

<head>
    <title>Fractal Games Juego</title>
    <?php 
if( !headers_sent() && '' == session_id() ) {
    session_start();
    }
  //para volver al index si el id del juego no está incluido
  if(!isset($_GET['juego'])){
      header("Location: index.php");
      exit;
  }
  include("head.php");
include("phpComponents/logo.php"); ?>     
    <style>
.gameContainer, .videoContainer {
    z-index: 1;
    position:relative;
    margin-top:5%;
    margin-left:10%;
    background-color: #f2f2f2;
width:80%;
-moz-box-shadow:  0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
-webkit-box-shadow:  0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
  padding: 5px;
}
.descriptionContainer{
    
box-shadow: 2px 2px 2px 2px rgba(0, 0, 0, 0.2);
}

.carousel{

float:right;
padding-bottom:5%;
}
.imgJuegoPhp {
  
  width:170px; 
  height:170px;
}

.gameContainer::after {
   
  content: "";
  clear: both;
  display: table;
}
.gamebody{
width: 90%;
}
.botonJugar{
    width:40%;
    
   margin-top:2%;
}
.botonFav{
    width:55%;
}
.trailer{
    margin-left:20%;
}
        </style>
</head>

<body>
<script> 
function añadirFav(idJuego){
window.location="favoritos.php?idJuego="+idJuego+"&accion=añadir";
}

function quitarFav(idJuego){
window.location="favoritos.php?idJuego="+idJuego+"&accion=quitar";
}
</script>

     <section id="mainContent">
     <?php 

        include("phpComponents/topbar.php");
        // include("phpComponents/formLogin.php");
        include_once("phpComponents/funcionBBDD.php");
        $link = db_Connect();
        $sql_juego="SELECT * FROM videojuegos WHERE idJuego =\"".$_GET['juego']."\"";
        $qry_juego=peticionSQL($sql_juego,$link);
        if(!$qry_juego){
            echo("ERROR AL MOSTRAR JUEGO, VUELVA A INTENTARLO EN OTRO MOMENTO");
        }
        $juego = mysqli_fetch_object($qry_juego);
  ?>
<article class="gameContainer">

    <div id="carouselId" class="carousel slide" data-ride="carousel">
    <?PHP     
    $sql_imagenes = "SELECT * FROM `imagenes` WHERE idJuego=".$juego->idJuego;
    $qry_imagenes = peticionSQL($sql_imagenes,$link);
    ?>
        
        <div class="carousel-inner" role="listbox">
            <?php
            $j =0;
             while($imagen = mysqli_fetch_object($qry_imagenes)){ ?>
                
            <div class="carousel-item <?=$j==0?"active":""?>">
                <img src="imagenes/<?=$imagen->urlImagen?>" class="imgJuegoPhp" alt="slide<?=$j?>">
            </div>
                <?php $j++;}?>
        </div>
        <a class="carousel-control-prev" href="#carouselId" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselId" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
        <?php if(!isset($_SESSION['user'])){
            $funcion ="document.getElementById('id01').style.display='block'";

        }else{
            $funcion ="alert('Ahora podrá jugar al juego sin problemas')";

        }
        
        ?>
        <button onclick="<?= $funcion?>" class="botonJugar">Jugar </button>
        <?php
        if(isset($_SESSION['user'])){
            $sql_fav = "SELECT * FROM FAVORITOS WHERE idJuego=".$juego->idJuego." && idUsuario=".$_SESSION['user'];
            $qry_fav=peticionSQL($sql_fav,$link);
            if(mysqli_num_rows($qry_fav)==1){
            echo "<button onclick=\"quitarFav(".$juego->idJuego.")\" class=\"botonFav\">QuitarFav</button>";
            }else{
                echo "<button onclick=\"añadirFav(".$juego->idJuego.")\" class=\"botonFav\">AñadirFav</button>";
            }
        }
        ?>
    </div>
  <h2 style="float: left; width: 50%;"><?=$juego->nombreJuego ?></h2><h3 style="display:block">Precio: <?=$juego->precioJuego?>€</h3>
  <p class="descriptionContainer"> <br><?=$juego->descripcionJuego?>
  </p>
</article>
<br>
<h1>JUEGO</h1>
<article class="videoContainer">
        <?php if($juego->trailer != "not available"){ ?>
            <h2 >Score:  </h2><h2 id="score"></h2>
            <iframe src="<?=$juego->trailer ?>" width="100%" height="750"></iframe>
            <script>
                window.addEventListener('message', function(event) {
                // verificar si el mensaje es del tipo 'scoreUpdate'
                    if (event.data.type === 'scoreUpdate') {
                        console.log("SE ACTUALIZA LA PUNTUACION")
                // actualizar el contador con el valor enviado por la página dentro del iframe
                    var score = event.data.score;
                // código para actualizar el contador en la página principal
                    var contador = document.getElementById('score');
                    contador.textContent= score;
                    }
                });
            
            </script>
            <?php } else { ?>
                    <div> NO DISPONIBLE</div>
            <?php }?>
<!-- <iframe class="trailer" width="560" height="315" src="<$juego->trailer ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> -->



</article>
    </section>

    <!-- <iframe src="Juegos/solitario.html" width="75%" height="500"></iframe> -->
    
    </body>
    </html>