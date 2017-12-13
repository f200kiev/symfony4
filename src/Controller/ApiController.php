<?php

namespace App\Controller;

use App\Entity\ProductEntity;
use App\Persister\ProductEntityPersister;
use App\Repository\ProductEntityRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ApiController extends Controller
{
    private $serializer;

    private $validator;

    private $entityPersister;

    private $entityRepository;

    public function __construct(
      SerializerInterface $serializer,
      ValidatorInterface $validator,
      ProductEntityPersister $entityPersister,
      ProductEntityRepository $entityRepository
    ) {
        $this->serializer = $serializer;
        $this->validator = $validator;
        $this->entityPersister = $entityPersister;
        $this->entityRepository = $entityRepository;
    }

    /**
     * @Route("/api/product/add", name="add_product")
     * @Method({"POST"})
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addProduct(Request $request): Response
    {
        $product = $this->serializer->deserialize($request->getContent(), ProductEntity::class, 'json');

        $violations = $this->validator->validate($product);
        if (0 !== count($violations)) {
            return new Response($violations);
        }

        $this->entityPersister->save($product);

        return new Response($this->serializer->serialize($product, 'json'));
    }

    public function updateProduct(int $productId, Request $request): Response
    {
    }

    public function patchProduct(int $productId, Request $request): Response
    {
    }

    /**
     * @Route("/api/product/remove/{productId}", name="remove_product")
     * @Method({"DELETE"})
     *
     * @param int $productId
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function removeProduct(int $productId): Response
    {
        $product = $this->entityRepository->find($productId);

        if (!$product) {
            return new Response($this->serializer->serialize(['No products found'], 'json'), Response::HTTP_NOT_FOUND);
        }

        $this->entityPersister->remove($product);

        $response = new JsonResponse();
        $response->headers->set('Content-Type', 'application/json');
        $response->setData('Product has been removed');

        return $response;
    }
}
