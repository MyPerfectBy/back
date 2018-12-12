<?php

namespace App\Controller\Security;

use App\Entity\Security\User;
use http\Env\Response;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Validation;

class RegistrationController extends AbstractController
{
    private  $errorsString = null;
    /**
     * @Route("/register", name="user_registration")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {

        $input = [
            //'username' => $request->request->get('username'),
            'email' => $request->request->get('email'),
            'password' => $request->request->get('password'),
        ];
        $input = $request->query->all();

        $validator = Validation::createValidator();

        $constraint = new Assert\Collection(array(
            'email' => new Assert\Email(),
            'password' => new Assert\Length(array('min' => 8))));

        $violations = $validator->validate($input, $constraint);
        if (count($violations) > 0) {
            $this->errorsString = (string) $violations;
            //return $this->errorsString;
        }

        $return = $this->container->get('user.service')->registerUser($input);


        var_dump($this->errorsString); die();

//// 1) build the form
//
//        $form = $this->createForm(UserType::class, $user);
//
//// 2) handle the submit (will only happen on POST)
//        $form->handleRequest($request);
//        if ($form->isSubmitted() && $form->isValid()) {
//
//// 3) Encode the password (you could also do this via Doctrine listener)
//            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
//            $user->setPassword($password);
//
//// 4) save the User!
//            $entityManager = $this->getDoctrine()->getManager();
//            $entityManager->persist($user);
//            $entityManager->flush();
//
//// ... do any other work - like sending them an email, etc
//// maybe set a "flash" success message for the user
//
//            return $this->redirectToRoute('replace_with_some_route');
//        }

        return $this->render('registration/register.html.twig', [ 'form' => $form->createView() ]);
    }
}