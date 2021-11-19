<?php
namespace App\Services\UserService;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use App\Services\BaseService\BaseService;
use App\Services\BaseService\UploadService;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserService extends BaseService
{
    private $manager;
    private $upload;
    private $encode;
    private $kernel;
    private $router;

    public function __construct(EntityManagerInterface  $_manager, 
                                UploadService $_upload, 
                                UserPasswordEncoderInterface $_encode, 
                                KernelInterface $_kernel,
                                RouterInterface $_router
                                ) {
        $this->manager = $_manager;
        $this->upload = $_upload;
        $this->encode = $_encode;
        $this->kernel = $_kernel;
        $this->router = $_router;
    }

    public function getRepository()
    {
       
        return $this->manager->getRepository(User::class);
    }

    public function checkUser(array $_paramettersInput)
    {
        $projectDir = $this->kernel->getProjectDir();

        $user = new User;
        $user->setUsername($_paramettersInput['user']['username'])
             ->setRoles([$_paramettersInput['user']['roles']])
             ->setEmail($_paramettersInput['user']['email'])
             //encore par défaut
             ->setPassword($this->encode->encodePassword($user, 123456));

            //   upload image si image existe
        if (isset($_paramettersInput['userAvatar']['userAvatar'])) {
            $this->upload->makePath($projectDir. '\public\upload\bo\user');
            $userAvatar = $this->upload->upload($projectDir. '\public\upload\bo\user', 'userAvatar');
            $user->setUserAvatar($userAvatar);
        }

        $this->manager->persist($user);
        $this->manager->flush();

    return $user;


    }

    public function userList(array $_parametters)
    {
        $offset      = $_parametters['offset'];
        $searchValue = $_parametters['search'];
        $limit       = $_parametters['length'];
        $projectDir = $this->kernel->getProjectDir();

        $allUsers = $this->getRepository()->findByGivenValue($offset, $limit, $searchValue);
       

        $paramsOutput = [];
        foreach($allUsers as $key => $user){
            $id = $user->getId();
            $btnEdit   = '<a href="'.$this->router->generate('admin_user_edit', ['id' => $id]).'"><i class="ti-pencil-alt"></i> </a>';
            // $btnDelete = '<a href="'.$this->router->generate('admin_delete_user', ['id' => $id]).'"><i class="ti-trash"></i> </a>';
            // $btnAction = $btnEdit.$btnDelete;
            $tmp_output []= [
                                //  $user->getUserAvatar(),

                                 $userAvatar = '<img src="/upload/bo/user/'.$user->getUserAvatar().'" class="img-radius" style="width:40px;" alt="User-Avatar-Image">',
                                 $user->getUserName(),
                                 $user->getEmail(),
                                 $btnEdit,
            ];
        }

        return $tmp_output;
    }


}