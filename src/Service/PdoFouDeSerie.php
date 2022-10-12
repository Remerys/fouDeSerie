<?php

namespace App\Service;

use PDO;

class PdoFouDeSerie
{
    private static $monPdo;
    public function __construct($serveur, $bdd, $user, $mdp)
    {
        PdoFouDeSerie::$monPdo = new PDO($serveur . ';' . $bdd, $user, $mdp);
        PdoFouDeSerie::$monPdo->query("SET CHARACTER SET utf8");
    }
    
    public function getLesSeries() {
        $req = PdoFouDeSerie::$monPdo->prepare('SELECT id, UPPER(titre) as titre,resume,duree,DATE_FORMAT(premiereDiffusion,"%d/%m/%Y") as premiereDiffusion, image FROM serie');
		$req->execute();
		$lesSeries = $req->fetchAll();
		return $lesSeries;
    }

    public function getLaSerie($id) {
        $req = PdoFouDeSerie::$monPdo->prepare('SELECT id, UPPER(titre) as titre,resume,duree,DATE_FORMAT(premiereDiffusion,"%d/%m/%Y") as premiereDiffusion, image FROM serie WHERE id = '.$id);
		$req->execute();
		$laSerie = $req->fetch();
		return $laSerie;
    }

    public function getNbSeries() {
        $req = PdoFouDeSerie::$monPdo->prepare('SELECT COUNT(id) as nombre FROM serie');
		$req->execute();
		$leNombre = $req->fetch();
		return $leNombre;
    }

    public function setLaSerie($laSerie) {
        $req = PdoFouDeSerie::$monPdo->prepare("INSERT INTO serie (titre, resume, duree, premiereDiffusion, image) VALUES (:titre, :resume, :duree, :premiereDiffusion, :image)");
        $req->bindValue(':titre', $laSerie['titre'], PDO::PARAM_STR);
        $req->bindValue(':resume', $laSerie['resume'], PDO::PARAM_STR);
        $req->bindValue(':duree', $laSerie['duree'], PDO::PARAM_STR);
        $req->bindValue(':premiereDiffusion', $laSerie['premiereDiffusion'], PDO::PARAM_STR);
        $req->bindValue(':image', $laSerie['image'], PDO::PARAM_STR);
		$req->execute();

        $req2 = PdoFouDeSerie::$monPdo->prepare("SELECT * FROM serie WHERE id=last_insert_id()");
        $req2->execute();
		$laLigne = $req2->fetch();
		return $laLigne;
    }

    public function deleteLaSerie($id) {
        $req = PdoFouDeSerie::$monPdo->prepare("DELETE FROM serie WHERE id=:id");
        $req->bindValue(':id', $id, PDO::PARAM_STR);
        $req->execute();
    }

    public function updateLaSerie($laSerie, $id) {
        $req = PdoFouDeSerie::$monPdo->prepare("UPDATE serie SET id=id, titre=:titre, resume=:resume, duree=:duree, premiereDiffusion=:premiereDiffusion, image=:image WHERE id=:id");
        $req->bindValue(':id', $id, PDO::PARAM_STR);
        $req->bindValue(':titre', $laSerie['titre'], PDO::PARAM_STR);
        $req->bindValue(':resume', $laSerie['resume'], PDO::PARAM_STR);
        $req->bindValue(':duree', $laSerie['duree'], PDO::PARAM_STR);
        $req->bindValue(':premiereDiffusion', $laSerie['premiereDiffusion'], PDO::PARAM_STR);
        $req->bindValue(':image', $laSerie['image'], PDO::PARAM_STR);
        $req->execute();

        $req2 = PdoFouDeSerie::$monPdo->prepare("SELECT * FROM serie WHERE id=:id");
        $req2->bindValue(':id', $id, PDO::PARAM_INT);
        $req2->execute();
		$laLigne = $req2->fetch();
		return $laLigne;
    }
}
