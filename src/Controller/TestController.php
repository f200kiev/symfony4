<?php

namespace App\Controller;

use App\Entity\ProductEntity;
use App\Repository\ProductEntityRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class TestController extends Controller
{
    private $entityRepository;

    private $serializer;

    public function __construct(
        ProductEntityRepository $entityRepository,
        SerializerInterface $serializer
    ) {
        $this->entityRepository = $entityRepository;
        $this->serializer = $serializer;
    }

    /**
     * @param ProductEntity
     *
     * @return JsonResponse
     *
     * @Route("/get_product/{product}", name="test")
     */
    public function getProduct(ProductEntity $product): JsonResponse
    {
        $response = new JsonResponse();
        $response->setData(json_decode($this->serializer->serialize($product, 'json')));

        return $response;
    }

    /**
     * @return JsonResponse
     *
     * @Route("/show_all", name="show_all")
     */
    public function showAll(): JsonResponse
    {
        $products = $this->entityRepository->findByAll();

        $response = new JsonResponse();
        $response->setData(json_decode($this->serializer->serialize($products, 'json')));

        return $response;
    }

    /**
     * @Route("/", name="homepage")
     * @Route("/product/{product}", name="product")
     *
     * @param int $product
     *
     * @return Response
     */
    public function indexAction(int $product)
    {
        return $this->render('index.html.twig', ['product' => $product]);
    }
}
