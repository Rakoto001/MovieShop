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
 * @Route("admin/user")
 */
class UserController extends AbstractController
{
    private $encode;
    private $userService;

    const USER_PAGE    = 'Utilisateur';
    const USER_ACTION  = 'Liste';
    const USER_EDITION = 'Mofdification';

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
           
            $allParams = $request->request->all();
            $allFiles = $request->files->all();
            $allParams['userAvatar'] = $allFiles;

            unset($allParams['user']['_token']);
            $this->userService->checkUser($allParams);

            $this->addFlash('success', 'Utilisateur ajouté');

        }

        return $this->render('BO/user/user-action.html.twig', [
                                                                    'userForm' => $userForm->createView(),
        ]);
    }

    /**
     * @Route("/list", name="admin_user_list")
    */
    public function userList()
    {
        // $users = $this->userService->getRepository()->findAll();

        return $this->render('/BO/user/user-list.html.twig', [

                                                                'page'   => self::USER_PAGE,
                                                                'action' => self::USER_ACTION,
                                                             ]);

    }

    /**
     * @Route("/edit/{id}", name="admin_user_edit")
     */
    public function userEdit(int $id, Request $request)
    {
        $user = $this->userService->getRepository()->findById($id);

        if($user){

            $user = $user[0];

        }


        $userForm = $this->createForm(UserType::class, $user);
        $userForm->handleRequest($request);
        $userAvatar = $user->getUserAvatar();
        if ($userForm->isSubmitted() && $userForm->isValid()) {

        }


        return $this->render('BO/user/user-action.html.twig', [
                                                                  'userForm' => $userForm->createView(),
                                                                  'userAvatar' => $userAvatar,
        ]);
    }


}