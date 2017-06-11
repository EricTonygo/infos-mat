<?php

namespace NNGenie\InfosMatBundle\Services;

use Kairos\SpreadsheetReader\SpreadsheetReader;
use Doctrine\ORM\EntityManager;
use NNGenie\InfosMatBundle\Entity\Genre;
use NNGenie\InfosMatBundle\Entity\Marque;
use NNGenie\InfosMatBundle\Entity\Type;
use NNGenie\InfosMatBundle\Entity\Proprietaire;
use NNGenie\InfosMatBundle\Entity\Etat;
use NNGenie\InfosMatBundle\Entity\Materiel;


/**
 * Description of MailService
 *
 * @author Eric TONYE
 */
class ExcelService {

    protected $em;
    
    public function __construct(EntityManager $em) {
        $this->em = $em;
    }

    public function importMaterielsToDatabase($excel_path) {
        // If you need to parse XLS files, include php-excel-reader
        $Reader = new SpreadsheetReader($excel_path);
        $Sheets = $Reader->Sheets();
        $materiel= new Materiel();
        foreach ($Sheets as $Index => $Name) {
            if ($Index == 0) {
                $Reader->ChangeSheet($Index);
                $i = 0;
                foreach ($Reader as $Row) {
                    if ($i == 1) {
                        if($Row[4] == ""){
                            continue;
                        }
                        $materiel = $this->saveMateriel($Row);
                        //break;
                    }
                    $i++;
                }
            }
            break;
        }
        return $materiel;
    }
    
    private function saveGenre($Row= array()){
        $repositoryGenre = $this->em->getRepository("NNGenieInfosMatBundle:Genre");
        $genre = new Genre();
        $genreUnique = $repositoryGenre->findOneBy(array("nom" => $Row[1], "statut" => 1));
        if($genreUnique == null && $Row[1]!=""){
            $genre->setNom($Row[1]);
            $genre->setCode($Row[1]);
            $genre->setFamille(null);
            $genre = $repositoryGenre->saveGenre($genre);
        }else{
            $genre = $genreUnique;
        }
        return $genre;
    }
    
    private function saveMarque($Row = array()){
        $repositoryMarque = $this->em->getRepository("NNGenieInfosMatBundle:Marque");
        $marque = new Marque();
        $marqueUnique = $repositoryMarque->findOneBy(array("nom" => $Row[2], "statut" => 1));
        if($marqueUnique == null && $Row[2] !=""){
            $marque->setNom($Row[2]);
            $marque = $repositoryMarque->saveMarque($marque);
        }else{
            $marque = $marqueUnique;
        }
        return $marque;
    }
    
    private function saveType(Marque $marque, $Row = array()){
        $repositoryType = $this->em->getRepository("NNGenieInfosMatBundle:Type");
        $type = new Type();
        $typeUnique = $repositoryType->findOneBy(array("nom" => $Row[3], "statut" => 1));
        if($typeUnique == null && $Row[3] != ""){
            $type->setNom($Row[3]);
            $type->setMarque($marque);
            $type = $repositoryType->saveType($type);
        }else{
            $type = $typeUnique;
        }
        return $type;
    }
    
    private function saveProprietaire($Row = array()){
        $repositoryProprietaire = $this->em->getRepository("NNGenieInfosMatBundle:Proprietaire");
        $proprietaire = new Proprietaire();
        $nomProprietaire = $Row[5]!="" ? $Row[5]:"NDJOCK";
        $proprietaireUnique = $repositoryProprietaire->findOneBy(array("nom" => $nomProprietaire,"statut" => 1));
        if($proprietaireUnique == null){
            $proprietaire->setNom($nomProprietaire);
            $adresse = new \NNGenie\InfosMatBundle\Entity\Adresse();
            $adresse->setTel($Row[6]);
            $proprietaire->setAdresse($adresse);
            $proprietaire = $repositoryProprietaire->saveProprietaire($proprietaire);
        }else{
            $proprietaire = $proprietaireUnique;
        }
        return $proprietaire;
    }
    
    private function  saveEtat($Row = array()){
        $repositoryEtat = $this->em->getRepository("NNGenieInfosMatBundle:Etat");
        $etat = new Etat();
        $etatUnique = $repositoryEtat->findOneBy(array("nom" => $Row[10], "statut" => 1));
        if($etatUnique == null && $Row[10]!=""){
            $etat->setNom($Row[10]);
            $etat->setNbreetoile(0);
            $etat = $repositoryEtat->saveEtat($etat);
        }else{
            $etat = $etatUnique;
        }
        return $etat;
    }
    
    private function saveMateriel($Row = array()){
        $materiel = new Materiel();
        $repositoryMateriel = $this->em->getRepository("NNGenieInfosMatBundle:Materiel");
        $materielUnique = $repositoryMateriel->findOneBy(array("chassis" => $Row[4], "statut" => 1));
        if($materielUnique == null && $Row[4] != ""){
            $materiel->setGenre($this->saveGenre($Row));
            $materiel->setType($this->saveType($this->saveMarque($Row), $Row));
            $materiel->setChassis($Row[4]);
            $materiel->setProprietaire($this->saveProprietaire($Row));
            $materiel->setEtat($this->saveEtat($Row));
            $repositoryMateriel->saveMateriel($materiel);
        }else{
            $materiel = $materielUnique;
        }
        return $materiel;
    }

}
