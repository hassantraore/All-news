<?php


namespace App\Controller;

use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\User;
use App\Form\CommentType;
use App\Form\PostType;
use App\Form\UserType;
use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use App\Security\Voter\PostVoter;
use App\Uploads\UploaderInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Class HomeController
 * @package App\Controller
 */
class HomeController extends AbstractController
{
    //controller pour afficher toutes articles de presse de toutes les categories

    /**
     * @Route("/revue_de_presse", name="revue_de_presse_home")
     * @param Request $request
     * @return Response
     */
    //@Route("/categories", name="categories_index")
    //@Route ("/", name ="home")
    public function home(Request $request): Response

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


        //$categorie = $this->getDoctrine()->getRepository(Category::class)->findAll();

        return $this->render("home.html.twig", [
            "posts" => $posts,
            "pages" => $pages,
            "page" => $page,
            "limit" => $limit,
            "range" => $range,

        ]);

    }

    /**
     * @param Post $post
     * @param Request $request
     * @return Response
     * @Route("/article-{id}",name="post_read")
     */
    public function read(Post $post, Request $request): Response
    {
        $comment = new Comment();
        $comment->setPost($post);
        if($this->isGranted("ROLE_USER")){
            $comment->setUser($this->getUser());
        }

        $form = $this->createForm(CommentType::class, $comment,[
            "validation_groups"=>$this->isGranted("ROLE_USER") ? "Default":["Default","anonymous"]
        ])->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->persist($comment);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute("", ["id" => $post->getId()]);
        }

        return $this->render("read.html.twig", ["post" => $post, "form" => $form->createView()]);

    }


    /**
     * @Route("/publier-article",name="post_create")
     * @param Request $request
     * @param  UploaderInterface $uploader
     * @return Response
     */
    public function create(Request $request,
                           UploaderInterface $uploader
    ): Response
    {
        $this->denyAccessUnlessGranted("ROLE_ADMIN");
        $post = new Post();
        $post->setUser($this->getUser());
        $form = $this->createForm(PostType::class, $post,["validation_groups"=>["Default","create"]])->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /**
             *@var  UploadedFile $file
             */
            $file = $form->get("image")->getData();
            //$filename = $slugger->slug($file->getClientOriginalName().'_'.uniqid().'.'.$file->getClientOriginalExtension());
            $post->setImage($uploader->upload( $file));


            $this->getDoctrine()->getManager()->persist($post);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute("", ["id" => $post->getId()]);
        }

        return $this->render("create.html.twig", ["form" => $form->createView()]);

    }

    /**
     * @param UploaderInterface $uploader
     * @param Request $request
     * @return Response
     * @param Post $post
     * @Route("/modifier-article/{id}",name="post_update")
     */

    public function update(Request $request,Post $post,
                           UploaderInterface $uploader ): Response
    {
        $this->denyAccessUnlessGranted(PostVoter::POST_EDIT,$post);

        $form = $this->createForm(PostType::class, $post)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
                /**
                 *@var  UploadedFile $file
                 */
                $file = $form->get("image")->getData();

                if($file !== null){
                    $post->setImage($uploader->upload($file));
                }


                $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute("post_update", ["id" => $post->getId()]);

        }
        return $this->render("update.html.twig", [
            "form" => $form->createView()
        ]);

    }


//pour afficher toutes les categories
    /**
     * @Route ("/", name ="home")
     * @param CategoryRepository $categoryRepository
     * @return Response
     * @param Request $request
     */
    public function index(CategoryRepository $categoryRepository, Request $request): Response
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


        return $this->render('categories/index.html.twig', [
            'categories' => $categoryRepository->findAll(),
            "posts" => $posts,
            "pages" => $pages,
            "page" => $page,
            "limit" => $limit,
            "range" => $range,
        ]);
    }






}
