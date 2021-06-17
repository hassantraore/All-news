<?php


namespace App\Controller;


use App\DataTransfertObject\Credentials;
use App\Form\LoginType;
use Psr\Container\ContainerInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     * @Route ("/login",name="security_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {     // fonctionne avec  cette façon
        //if(null!==$authenticationUtils->getLastAuthenticationError(fasle)){

        $form = $this->createForm(LoginType::class, new Credentials($authenticationUtils->getLastUsername()));
        //$error = $authenticationUtils->getLastAuthenticationError();
        if (null !== $authenticationUtils->getLastAuthenticationError(false)) {
            $form->addError(new FormError($authenticationUtils->getLastAuthenticationError()->getMessage()));

        }

        return $this->render("security/login.html.twig",
            ["form" => $form->createView()]);

    }

    /*Metode vide  mais precider  dans le securty.yaml le
     logout:
                path: secrity_logout dans le firewalls: en dessous provider: users pour la decon */

    /**
     *  @Route("/logout",name="app_logout")
     */
    public function logout(): void
    {

    }


}