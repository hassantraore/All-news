<?php

namespace App\DataFixtures;
use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\DataFixtures\UserFixtures;

/**
 * Class PostFixtures
 * @package App\DataFixtures
 */
class PostFixtures extends Fixture
//implements DependentFixtureInterface
{
    /***
     * @param ObjectManager $manager
     *
     *
     */
    public function load(ObjectManager $manager){


        //\Faker\Factory
        $faker = Factory::create('fr_FR');

        //Cinq category  de  faker
        for ($k = 0; $k <= 5; $k++) {
            $category = new Category();
            $category->setName($faker->sentence());//$faker->sentences
            $category->setDescription($faker->paragraph());
            //$category->setImage("https://picsum.photos/400/300");
            $manager->persist($category);

            //Dix articles par category
            //$content = '<p>'.join($faker->paragraphs(5),'</p><p>').'</p>';


            for ($i = 0; $i <= rand(5, 10); $i++) {
                $post = new Post();
                $post->setTitle($faker->sentence().$i);
                //$post->setUser($this->getReference(sprintf("user-%d",($i % 10)+1)));
                $post->setAuthorName($faker->name().$i);
                $post->setImage("https://picsum.photos/400/300");
                //https://picsum.photos/400/300,http://via.placeholder.com/400x300


                //$post->setImage($faker->imageUrl($width = 640, $height = 480).$i);
                $post->setContents($faker->paragraph(50).$i);
                //$post->setContents("contenue n°".$i);
                $post->setCategory($category);
                $manager->persist($post);

                //Dix Commentaires par category
                for ($j = 0; $j <= rand(3, 10); $j++) {
                    $comment = new Comment();
                    $comment->setAuthorName($faker->name().$i);
                    $comment ->setContent($faker->paragraph().$j);
                    //$comment->setAddress($faker->sentence());
                    //$comment->setSite($faker->sentence());
                     $comment ->setPost($post);
                    //permet de lier un poste a un commentaire sans cela les fixtures ne peuvent chargé

                    $manager->persist($comment);
                }
            }
        }


        $manager->flush();
    }

   /* /**
     * @return string[]
     */
    //public function getDependencies()
    //{
        //return[UserFixtures::class];
    //}


}