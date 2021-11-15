<?php
namespace App\Controller\BO;

use App\Entity\Article;
use JMS\Serializer\SerializerInterface;
use JMS\Serializer\SerializationContext;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    private $normalizer;

    public function __construct(SerializerInterface $_normalizer) {
        $this->normalizer = $_normalizer;
    }
    /**
     * @Route("/bo/article/{id}", name="bo_article_show")
     *
     * @param Type $var
     * @return void
     */
    public function getArticle(Article $oArticle)
    {
        /** prendre la groupe déclaré dans le entity */
        $groups =  SerializationContext::create()->setGroups('detail');
        $jsonContent = $this->normalizer->serialize($oArticle, 'json', $groups);
        $response = new Response($jsonContent);
        $response->headers->set('Content-type', 'application/json');
        
        return $response;
        
    }

    /**
     * @Route("/bo/articles/list/all", name="bo_articles_alls")
     * 
     */
    public function allArticles()
    {
        $articleRepository = $this->getDoctrine()->getManager()->getRepository(Article::class);
        $oArticles = $articleRepository->findAll();
        $jsonContent = $this->normalizer->serialize($oArticles, 'json');

        $response = new Response($jsonContent);
        $response->headers->set('Content-type', 'application/json');
        
        return $response;
    }
}