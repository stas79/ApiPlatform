<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Repository\UserRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserLoginProcessor implements ProcessorInterface
{

    public function __construct(private UserRepository $repository, private UserPasswordHasherInterface $userPasswordEncoder)
    {
    }

    /**
     * @param mixed $data
     * @param Operation $operation
     * @param array $uriVariables
     * @param array $context
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): User
    {
        $user = $this->repository->findOneByLogin($data->getEmail());
        if($user instanceof User){
            $user->SetToken(bin2hex(random_bytes(60)));
            $this->repository->save($user, true);
            return $user;
        }

        throw new NotFoundHttpException();
    }
}
