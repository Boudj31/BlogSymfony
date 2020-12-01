<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $article1 = new Article();
        $article1->setTitle('Fixture 1')
                 ->setSummary('Ceci est un résumé')
                 ->setContent('Ceci est un contenu')
                 ->setPublished(true);

       $manager->persist($article1);

       $article2 = new Article();
       $article2->setTitle('Fixture 2')
             ->setSummary('Ceci est un résumé')
             ->setContent('Ceci est un contenu')
             ->setPublished(true);

      $manager->persist($article2);

        $manager->flush();

    }
}
