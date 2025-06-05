<?php

function choisirmot() { // choisira le mot au hasard dans le fichier mots.txt
    $mots = file("mots.txt", FILE_IGNORE_NEW_LINES);
    $mot = $mots[array_rand($mots)];
    $mot = trim($mot);
    $mot = strtolower($mot);
    $mot = str_split($mot); // Convertit le mot en tableau
    return $mot;
}


function choisirlettre($lettreutilisee) { // Demande à l'utilisateur de choisir une lettre et fait des vérifications
    $lettre = readline("Entrez une lettre : ");
    $lettre = strtolower($lettre);
    if (strlen($lettre) !== 1 || !preg_match('/^[a-z]$/', $lettre)) {
        echo "Veuillez entrer une seule lettre valide.\n";
        return choisirlettre($lettreutilisee);
    }
    if (in_array($lettre, $lettreutilisee)) {
        echo "Vous avez déjà utilisé cette lettre.\n";
        return choisirlettre($lettreutilisee);
    }
    return $lettre;
}

function affichiermot($mot, $lettresutilisees) { // Affiche le mot avec les lettres trouvées et des tirets pour les lettres non trouvées
    $affichage = '';
    for ($i = 0; $i < count($mot); $i++) {
        $lettre = $mot[$i];
        if (in_array($lettre, $lettresutilisees)) {
            $affichage .= $lettre . ' ';
        }
        else {
            $affichage .= '- ';
        }
    }
    return trim($affichage);
}

function lettrecorrecte($mot, $lettre) { // Vérifie si la lettre choisie par l'utilisateur est dans le mot
    if (in_array($lettre, $mot)) {
        echo "Bien joué ! La lettre '$lettre' est dans le mot.\n";
        return true;
    }
    else {
        echo "Désolé, la lettre '$lettre' n'est pas dans le mot.\n";
        return false;
    }
}

function dessinPendu($l):string
{
    switch ($l) {
        case 0:
            return " 
    ____
   |    |      
   |    o      
   |   /|\     
   |    |
   |   / \
  _|_
 |   |______
 |          |
 |__________|
		";
            break;

        case 1:
            return "
    ____
   |    |      
   |    o      
   |   /|\     
   |    |
   |    
  _|_
 |   |______
 |          |
 |__________|
		";
            break;
        case 2:
            return "
    ____
   |    |      
   |    o      
   |    |
   |    |
   |     
  _|_
 |   |______
 |          |
 |__________|
		";
            break;
        case 3:
            return "
    ____
   |    |      
   |    o      
   |        
   |   
   |   
  _|_
 |   |______
 |          |
 |__________|
		";
            break;
        case 4:
            return "
    ____
   |    |      
   |      
   |      
   |  
   |  
  _|_
 |   |______
 |          |
 |__________|
		";
            break;
        case 5:
            return "
    ____
   |        
   |        
   |        
   |   
   |   
  _|_
 |   |______
 |          |
 |__________|
		";
            break;
        case 6:
            return "
    
   |     
   |     
   |     
   |
   |
  _|_
 |   |______
 |          |
 |__________|
		";
            break;
        case 7:
            return "
  _ _
 |   |______
 |          |
 |__________|
		";
            break;
        case 8:
            return " ";
    }

}

function jeu() { // Fonction principale du jeu
    $titre = "
      _____               _       
     |  __ \             | |      
     | |__) |__ _ __   __| |_   _ 
     |  ___/ _ \ '_ \ / _` | | | |
     | |  |  __/ | | | (_| | |_| |
     |_|   \___|_| |_|\__,_|\__,_|
    ";
    $mot = choisirmot();
    $lettresutilisees = [];
    $tentatives = 8; // Nombre de tentatives avant de perdre
    echo $titre . "\n";
    
    while ($tentatives > 0) {
        echo dessinPendu($tentatives) . "\n";
        echo "Mot à deviner : " . affichiermot($mot, $lettresutilisees) . "\n";
        echo "Tentatives restantes : $tentatives . "\n";
        echo "Lettres utilisées : " . implode(', ', $lettresutilisees) . "\n";
        $lettre = choisirlettre($lettresutilisees);
        $lettresutilisees[] = $lettre;
        
        if (lettrecorrecte($mot, $lettre)) {
            if (count(array_intersect($mot, $lettresutilisees)) === count($mot)) {
                echo "Félicitations ! Vous avez deviné le mot : " . implode('', $mot) . "\n";
                return;
            }
        } else {
            $tentatives--;
        }
    }
    
    echo "Désolé, vous avez perdu. Le mot était : " . implode('', $mot) . "\n";
}

// Lancer le jeu
jeu();
