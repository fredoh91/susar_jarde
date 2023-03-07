<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserEditType;
use App\Form\UserEditPasswordType;
use App\Form\UserRegistrationType;
use App\Security\UserAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
// use Symfony\Contracts\Translation\TranslatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

#[Security("is_granted('ROLE_SUPER_ADMIN')")]
class RegistrationController extends AbstractController
{
    #[Route('/super_admin/inscription', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, UserAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(UserRegistrationType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        return $this->render('user/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/super_admin/modif_user/{id}', name: 'app_modif_user')]
    public function modif_user(User $user, Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, UserAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserEditType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($form->get('Valider')->isClicked()) {
                /**
                 * L'utilisateur a cliqué sur le bouton "Valider", ce qui :
                 *      - 
                 *      - 
                 */

                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );
                $entityManager->persist($user);
                $entityManager->flush();
            } else if ($form->get('Annuler')->isClicked()) {
                /**
                 * L'utilisateur a cliqué sur le bouton "Annuler", on ne fait rien, a part être redirigé versla liste des utilisateurs
                 */
            } else {
            }

            return $this->redirectToRoute('app_liste_user'); // liste des utilisateurs

            // $message = $translator->trans('User modified successfully');

            // $this->addFlash('message', $message);
        }

        return $this->render('user/edituser.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/super_admin/modif_user_password/{id}', name: 'app_modif_user_password')]
    public function modif_user_password(User $user, Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, UserAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserEditPasswordType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($form->get('Valider')->isClicked()) {
                /**
                 * L'utilisateur a cliqué sur le bouton "Valider", ce qui :
                 *      - 
                 *      - 
                 */

                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );
                $entityManager->persist($user);
                $entityManager->flush();
            } else if ($form->get('Annuler')->isClicked()) {
                /**
                 * L'utilisateur a cliqué sur le bouton "Annuler", on ne fait rien, a part être redirigé versla liste des utilisateurs
                 */
            } else {
            }

            return $this->redirectToRoute('app_liste_user'); // liste des utilisateurs

            // $message = $translator->trans('User modified successfully');

            // $this->addFlash('message', $message);
        }

        return $this->render('user/edituser_password.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/contact_admin', name: 'app_contact_admin')]
    public function contactAdmin(): Response
    {
        return $this->render('user/contact_admin.html.twig');
    }
}
