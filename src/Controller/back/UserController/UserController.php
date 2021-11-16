<?php
namespace App\Controller\back\UserController;

use App\Entity\User;
use App\Form\UserType;
use App\Services\UserService\UserService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    private $encode;
    private $userService;
    public function __construct(UserPasswordEncoderInterface $_encode, UserService $_userService) {
        $this->encode = $_encode;
        $this->userService = $_userService;
    }
    /**
     * @Route("/new", name="admin_user_create")
     */
    public function userCreate(Request $request)
    {
        // $user->setEmail('admin@admin.com')
        //      ->setUsername('Super Admin')
        //      ->setRoles(['ROLE_ADMIN'])
        //      ->setPassword($this->encode->encodePassword($user, 123456));
        // $manager = $this->getDoctrine()->getManager();
        // $manager->persist($user);
        // $manager->flush();
        $user = new User;
        $userForm = $this->createForm(UserType::class, $user);
        $userForm->handleRequest($request);

        if ($userForm->isSubmitted() && $userForm->isValid()) {
            // dump($user);
            // dump();
            $allParams = $request->request->all();
            $allFiles = $request->files->all();
            $allParams['userAvatar'] = $allFiles;

            unset($allParams['user']['_token']);

            $this->userService->checkUser($allParams);



            die();


        }

        return $this->render('BO/user/user-action.html.twig', [
                                                                    'userForm' => $userForm->createView(),
        ]);
    }

}