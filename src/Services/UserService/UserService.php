<?php
namespace App\Services\UserService;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use App\Services\BaseService\BaseService;
use App\Services\BaseService\UploadService;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserService extends BaseService
{
    private $manager;
    private $upload;
    private $encode;
    private $kernel;

    public function __construct(EntityManagerInterface  $_manager, UploadService $_upload, UserPasswordEncoderInterface $_encode, KernelInterface $_kernel) {
        $this->manager = $_manager;
        $this->upload = $_upload;
        $this->encode = $_encode;
        $this->kernel = $_kernel;
    }

    public function getRepository()
    {
        $this->manager->getRepository(User::class);
    }

    public function checkUser(array $_paramettersInput)
    {
        $projectDir = $this->kernel->getProjectDir();
        dump($projectDir);


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

        dump($user);
        die();

            //  $this->manage->persist($user);
            //  $this->manage->flush();

        

      

    }

}