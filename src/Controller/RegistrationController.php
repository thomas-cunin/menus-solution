<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends AbstractController
{
    private EmailVerifier $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
//        ->add('email')
//        ->add('agreeTerms', CheckboxType::class, [
//            'mapped' => false,
//            'constraints' => [
//                new IsTrue([
//                    'message' => 'You should agree to our terms.',
//                ]),
//            ],
//        ])
//        ->add('plainPassword', PasswordType::class, [
//            // instead of being set onto the object directly,
//            // this is read and encoded in the controller
//            'mapped' => false,
//            'attr' => ['autocomplete' => 'new-password'],
//            'constraints' => [
//                new NotBlank([
//                    'message' => 'Please enter a password',
//                ]),
//                new Length([
//                    'min' => 6,
//                    'minMessage' => 'Your password should be at least {{ limit }} characters',
//                    // max length allowed by Symfony for security reasons
//                    'max' => 4096,
//                ]),
//            ],
//        ])
//        ->add('firstName',TextType::class)
//        ->add('lastName' ,TextType::class)
//        ->add('place', EntityType::class, [
//            'label' => false,
//            'required' => false,
//            'attr' => [
//                'class' => 'form-control',
//                'placeholder' => 'Place',
//            ],
//        ])
//        // add roles ROLE_SUPER_ADMIN and ROLE_ADMIN and  ROLE_USER with a choiceType
//        ->add('roles', ChoiceType::class, [
//            'choices' => [
//                'ROLE_SUPER_ADMIN' => 'ROLE_SUPER_ADMIN',
//                'ROLE_ADMIN' => 'ROLE_ADMIN',
//                'ROLE_USER' => 'ROLE_USER',
//            ],
//            'multiple' => true,
//            'expanded' => true,
//            'label' => 'Roles',
//            'required' => true,
//        ])
        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setRoles($form->get('roles')->getData());

            // set user as verified
            $user->setIsVerified(true);

            $entityManager->persist($user);
            $entityManager->flush();

            // generate a signed url and email it to the user
            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address('no@email.fr', 'Mail bot'))
                    ->to($user->getEmail())
                    ->subject('Please Confirm your Email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );
            // do anything else you need here, like send an email

            return $this->redirectToRoute('admin');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request, TranslatorInterface $translator, UserRepository $userRepository): Response
    {
        $id = $request->query->get('id');

        if (null === $id) {
            return $this->redirectToRoute('app_register');
        }

        $user = $userRepository->find($id);

        if (null === $user) {
            return $this->redirectToRoute('app_register');
        }

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $user);
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));

            return $this->redirectToRoute('app_register');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Your email address has been verified.');

        return $this->redirectToRoute('app_register');
    }
}
