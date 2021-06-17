<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Category;

class CategoriesController extends AbstractController
{

    /**
     * @Route("/info_categorie-{slug}", name="categories")
     * @param Request $request
     * @param PostRepository $postRepository
     * @return Response
     */
    public function findAllCategory(Category $category, Request $request, PostRepository $postRepository):Response
    {



        $limit = $request->get("limit", 10);
        $page = $request->get("page", 1);
        //$total = $this->getDoctrine()->getRepository(Post::class)->count([]);
        /**
         * @var Paginator $posts
         */
        $posts = $this->getDoctrine()->getRepository(Post::class)->getPaginatedPosts($page, $limit);
        $pages = ceil(count($posts) / $limit);


        $range = range(max($page - 3, 1),
            min($page + 3, $pages)
        );

    // $posts=$postRepository->findAllCategory($category);
         //$postsP=$postRepository->findAll();

        return $this->render("categories/category.html.twig",
            [
                "postsRepos"=>$postRepository->findAll(),
                "category"=>$category,
                "posts" => $posts,
                "pages" => $pages,
                "page" => $page,
                "limit" => $limit,
                "range" => $range,
            ]);
    }


    /**
     * @Route ("/category_economy", name ="economy")
     * @return Response
     * @param Request $request
     * @param CategoryRepository $categoryRepository
     */

     public function economy( CategoryRepository $categoryRepository,Request $request):Response{


         return $this->render("categories/index.html.twig",['categories' => $categoryRepository->findAll()]);


     }



    /**
     * @Route ("/cat_politics", name ="politics")
     * @return Response
     * @param Request $request
     * @param   CategoryRepository $categoryRepository
     */
     public function politics( CategoryRepository $categoryRepository,Request $request):Response{
         return $this->render("categories/index.html.twig",['categories' => $categoryRepository->findAll()]);
     }

}
