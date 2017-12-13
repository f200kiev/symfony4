<?php

namespace App\Controller;

use App\Entity\ProductEntity;
use App\Repository\ProductEntityRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class TestController extends Controller
{
    private $entityRepository;

    public function __construct(
        ProductEntityRepository $entityRepository
    ) {
        $this->entityRepository = $entityRepository;
    }

    /**
     * @param ProductEntity
     *
     * @return Response
     *
     * @Route("/test/{product}", name="test")
     */
    public function index(ProductEntity $product)
    {
        var_dump($product);
        die;

        return new Response('Welcome to your new controller!');
    }

    /**
     * @Route("/show_all", name="show_all")
     */
    public function showAll()
    {
        var_dump($this->entityRepository->findByAll());
        die;
    }

    /**
     * @param ProductEntity
     *
     * @Route("/", name="homepage")
     * @Route("/product/{product}", name="product")
     *
     * @return Response
     */
    public function indexAction(ProductEntity $product)
    {
        return $this->render('index.html.twig', ['product' => $product]);
    }
}
