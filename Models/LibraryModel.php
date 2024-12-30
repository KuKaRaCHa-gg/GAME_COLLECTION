<?php

function afficherJeu()
{
    echo '<div class = "game">';
    echo '<img src=' . '"./../Assets/Images/zelda.jpg"' . 'alt="jeu" class="gameImage"/>'; //Image du jeu
    echo '<h2 class="gameTitle">';
    echo 'Zelda TOTK';//Nom du jeu
    echo '</h2>';
    echo '<p class="gameHours">';
    echo '100' . 'H'; //Nombre d'heures jouées au jeu
    echo '</p>';
    echo '<p class="gamePlatform">';
    echo 'Switch';//Plateforme du jeu
    echo ' </p>';
    echo '<a class="details">'; //Il faut ajouter un lien à la page du jeu en particulier
    echo 'VOIR LE JEU'; //Texte affiché lors du surlignage qui servira à accéder aux détails du jeu
    echo '</a>';
    echo '</div>';
}
