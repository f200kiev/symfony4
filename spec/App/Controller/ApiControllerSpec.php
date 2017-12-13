<?php

namespace spec\App\Controller;

use App\Controller\ApiController;
use Doctrine\ORM\EntityManagerInterface;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ApiControllerSpec extends ObjectBehavior
{
    public function let(
      SerializerInterface $serializer,
      ValidatorInterface $validator,
      EntityManagerInterface $entityManager
    ) {
        $this->beConstructedWith($serializer, $validator, $entityManager);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(ApiController::class);
    }

    public function it_should_add_product()
    {
    }
}
