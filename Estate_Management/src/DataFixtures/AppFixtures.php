<?php

namespace App\DataFixtures;

use App\Entity\Biens;
use App\Entity\Adresses;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // create 20 Adresses! Bam!
        for ($i = 0; $i < 20; $i++) {
            $ruesVille = chr(mt_rand(65, 90));
            $adresse = new Adresses();
            $bien = new Biens();

            $adresse->setNumeros(mt_rand(1, 99));
            $adresse->setVoies('rue '.$ruesVille);
            $adresse->setVilles($ruesVille);
            $adresse->setCp(mt_rand(62000, 62999));
            $adresse->setActivate(1);
            $adresse->setDateAdd(new \DateTime());
            $adresse->setDateUpdate(new \DateTime());

            $bien->setNoms('bien '.$i);
            $bien->setDescriptions('Lorem ipsum dolor sit amet, consectetur adipisicing elit. Exercitationem provident autem aut ad, assumenda suscipit quisquam blanditiis asperiores in ab et quam ipsa delectus magnam fugit deleniti excepturi officia accusamus!');
            $bien->setSurfaces(mt_rand(80, 150));
            $bien->setNbrPieces(mt_rand(2, 5));
            $bien->setNbrChambres(mt_rand(1, 4));
            $bien->setLoyers(mt_rand(350, 750));
            $bien->setStatuts(0);
            $bien->setActivate(1);
            $bien->setDateAdd(new \DateTime());
            $bien->setDateUpdate(new \DateTime());
            $bien->setAdresses($adresse);
            
            $manager->persist($adresse);
            $manager->persist($bien);
        }
        $manager->flush();
    }
}
