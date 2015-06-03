<?php
class application {
    private $_titre;
    private $_editeur;
    private $_prix;
    
    public function getTitre(){return $this->_titre;}
    public function getEditeur(){return $this->_editeur;}
    public function getPrix(){return $this->_prix;}
    
    public function afficher(){ //genere le code html permettant d'afficher
     echo '<div class="appCard">
            <a href="application.php?app='.self::getTitre().'" class="appLink">
                <div class="cover">
                    <img alt="cover" src="img/appDefault.png" class="app-cover"/>
                </div>     
                <div class="details">
                    <p class="title">'.self::getTitre().'</p>
                    <p class="subtitle">'.self::getEditeur().'</p>
                    <p class="price">'.self::getPrix().'€</p>  
                </div>
            </a>
            </div>
     ';   
        
        
        
        
        
    }
    //public function getNbTelechargements(); futur develeppoment #stats
    
    public function __construct($titre,$editeur,$prix){
        $this->_titre=$titre;
        $this->_editeur=$editeur;
        $this->_prix=$prix;
    } 
    
}
    

class terminal {
    private $_modele;
    private $_os;
    private $_numSerie;
    
    public function getModele(){return $this->_modele;}
    public function getOs(){return $this->_os;}
    public function getNumSerie(){return $this->_numSerie;}
    
    public function afficher(){ //genere le code html permettant d'afficher
     echo '     <div class="details">
                    <p class="title">'.self::getModele().'</p>
                    <p class="subtitle">'.self::getOs().'</p>
                    <p class="price">'.self::getNumSerie().'€</p>  
                </div>
            </a>
     ';   // Faudrait refaire un affichage, pas le temps pour l'instant
    }
    //public function getNbTelechargements(); futur develeppoment #stats
    
    public function __construct($modele,$os,$numSerie){
        $this->_modele=$modele;
        $this->_os=$os;
        $this->_numSerie=$numSerie;
    } 
    
}
    
?>