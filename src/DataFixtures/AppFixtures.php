<?php
// src/DataFixtures/AppFixtures.php

namespace App\DataFixtures;

use App\Entity\TypeCorps;
use App\Entity\GrammageCorps;
use App\Entity\AntenneCouleur;
use App\Entity\AntenneLongueur;
use App\Entity\QuilleLongueur;
use App\Entity\Bouchon;
use App\Entity\BouchonVariante;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $type = new TypeCorps();
        $type->setNom('Liège');
        $manager->persist($type);

        $grammage = new GrammageCorps();
        $grammage->setPoids(3.0);
        $manager->persist($grammage);

        $antenneCouleur = new AntenneCouleur();
        $antenneCouleur->setNom('Rouge');
        $manager->persist($antenneCouleur);

        $antenneLongueur = new AntenneLongueur();
        $antenneLongueur->setLongueur(5);
        $manager->persist($antenneLongueur);

        $quilleLongueur = new QuilleLongueur();
        $quilleLongueur->setLongueur(3);
        $manager->persist($quilleLongueur);

        $bouchon = new Bouchon();
        $bouchon->setNom('Bouchon Test');
        $bouchon->setDescription('Un bouchon de test');
        $bouchon->setActif(true);
        $bouchon->setCreatedAt(new \DateTimeImmutable());
        $bouchon->setUpdatedAt(new \DateTimeImmutable());
        $manager->persist($bouchon);

        $variante = new BouchonVariante();
        $variante->setBouchon($bouchon);
        $variante->setTypeCorps($type);
        $variante->setGrammageCorps($grammage);
        $variante->setAntenneCouleur($antenneCouleur);
        $variante->setAntenneLongueur($antenneLongueur);
        $variante->setQuilleLongueur($quilleLongueur);
        $variante->setPrix(1.90);
        $variante->setStock(10);
        $variante->setCodeSku('TEST-001');
        $variante->setActif(true);
        $variante->setCreatedAt(new \DateTimeImmutable());
        $variante->setUpdatedAt(new \DateTimeImmutable());
        $manager->persist($variante);

        $manager->flush();
    }
}
