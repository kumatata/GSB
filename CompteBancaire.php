<?php

class CompteBancaire {
    // Attributs privés
    private $type  ;
    private $numeroCompte ;
    private $solde = 0 ;
    private $decouvert ;
    
    const COURANT = 1 ;
    const CEL = 2 ;
    const PEL = 3 ;
    const LIVRET_A = 4 ;
   
    
    //Constructeur 
    public function __construct($numeroCompte,$type,$solde)
    {   
        if(!isset($numeroCompte))
        {
            echo "Erreur, il faut absolument un numero de compte.</br>";
        }
        else
        {
             $this->numeroCompte = $numeroCompte ;
        }
        
        if(!isset($type)&&(!isset($solde)))
        {
            $this->type = 1 ;
            $this->solde = 0 ;
        }
        else
        {
             $this->type = $type ;
             $this->solde = $solde ;   
        }
        }

           
    
    
    // Méthode d'instance 
    
    public function getType() 
            {
        return $this->type;
            }
    public function setTypeCourant() 
            {
            $this->type = self ::COURANT ;
            $this->decouvert = 0 ;
            }
    
    public function getDecouvert()
            {
            return $this->decouvert ;
            } 
            
    public function setDecouvert($montant)
            {
                $this->decouvert = $montant;
            return $this->decouvert ;
            }        
           
    public function setTypeEpargne() 
            {
            $this->type = self ::LIVRET_A;
            }
     public function setTypePEL() 
            {
            $this->type = self ::PEL;
            }
    public function setTypeCEL() 
            {
            $this->type = self ::CEL;
            }
    public function setSolde($solde)
            {
        $this->solde = $solde ;
    }
    
    public function getSolde()
            {
        return $this->solde ;
    }
    
    public function getNumeroCompte()
    {
        return $this->numeroCompte ;
    }
    
    public function setNumeroCompte($num)
    {
        $this->numeroCompte = $num ;

    }
    public function crediter($numero,$montant)
    {
        $c = new CompteBancaire($numero) ;
        $this->solde += $montant ;
        $c->setSolde($this->solde) ;
        return $this->solde ;
    }
    
    public function debiter($montant)
    {
       $type = $this->type ;
       $solde = $this->solde ;
       switch($type)
       {
        case '2' or '3' :
                    $this->solde = $solde ;
                    echo 'Un compte bloque ne peut pas etre debite.</br>';
          break ;     
       
        case '4' :
            if($montant>$this->solde)
            {
                $this->solde = $solde ;
               echo"Le montant est superieur au solde, on ne peut pas débiter.</br>" ;
            }
            else
            {
                $this->solde -= $montant ; 
            }
        break ;
        
        case '1' :
            if($montant>$this->decouvert)
            {
                $this->solde = $solde ;
                echo "Le montant depasse votre decouvert, debit impossible.</br>" ;
            }
            else
            {
                 $this->solde -= $montant ; 
            }
         break ;
        
        default :
       return $this->solde ;
        
       }
    }
    
    public function __toString() 
            {
     return "[numeroCompte = ". $this->numeroCompte . " typeCompte = ". $this->type . " Solde = ".$this->solde."] <br/>" ;
            }
}
