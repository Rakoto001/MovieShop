<?php
namespace App\Controller\back\UserController;

use App\Entity\User;
use App\Form\UserType;
use App\Services\UserService\UserService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("admin/user")
 */
class UserAjaxController extends AbstractController
{

    private $userService;
  

    public function __construct(UserService $_userService) {
        $this->userService = $_userService;
    }

    /**
     * @Route("/datatable/list", name="user_datatable_list")
     */
    public function userAjaxList(Request $request)
    {
        $alls = $request->request->all();
        $userService = $this->userService;
        $alls        = $request->request->all();
        $offset      = $alls['start'];
        $limit       = $alls['length'];
        $search      = $alls['search'];
        $page        = $alls['page'];
        $query       = $alls['search']['value'];
        //les paramètres
        $params = [];
        $params['offset'] = $offset;
        $params['length'] = $limit;
        $params['search'] = $search;
        $params['query']  = $query;
        $params['page']   = $page;
        $params['list']   = isset($alls['list']) ? $alls['list'] : 1 ;
        $listUsers     = $this->userService->userList($params);
        // $results          = $listAnnonces['datas'];
        // $dataLists        = ['data' => $results];

        return new JsonResponse(['data' => $listUsers]);

    }
   

}