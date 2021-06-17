<?php

namespace App\Controller\Admin;
use App\DataTransfertObject\Credentials;
use App\Entity\Category;
use App\Entity\Post;
use App\Entity\User;
use App\Form\AdminType;
use App\Form\LoginType;
use App\Form\PostType;
use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use App\Uploads\UploaderInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class DashboardController extends AbstractDashboardController
{
    private CategoryRepository $categoryRepository;
    private PostRepository $postRepository;
    private UserRepository $userRepository;

    public function __construct(CategoryRepository $categoryRepository,
                                PostRepository $postRepository, UserRepository $userRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->postRepository = $postRepository;
        $this->userRepository = $userRepository;

    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin", name="admin")
     * @return Response
     */


    public function index(): Response
    {

        return $this->render("admin/bundles/welcome.html.twig", [
            "cuntAllCategory" => $this->categoryRepository->cuntAllCategory(),
            "cuntAllPosts" => $this->postRepository->cuntAllPosts(),
            "cuntAllUser" => $this->userRepository->cuntAllUser()
        ]);
    }

    public function configureDashboard(): Dashboard


    {
        return Dashboard::new()
            ->setTitle('Allnews');
    }

    public function configureMenuItems(): iterable


    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Categories', 'fas fa-book-open', Category::class);
        yield MenuItem::linkToCrud('Posts', 'fas fa-list', Post::class);
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-child', User::class);
    }


    public function configureUserMenu(UserInterface $user): UserMenu
    {
        return parent::configureUserMenu($user)
            ->setName($user->getUsername())
            //->setGravatarEmail($user->getUsername());
            ->displayUserAvatar(true);

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
        $post = new Post();
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
            return $this->redirectToRoute("post_read", ["id" => $post->getId()]);
        }

        return $this->render("create.html.twig", ["form" => $form->createView()]);

    }


}
