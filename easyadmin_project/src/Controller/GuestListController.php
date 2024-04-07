<?php

namespace App\Controller;

use App\Repository\GuestListRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class GuestListController extends AbstractController
{
    public function __invoke(GuestListRepository $repository): JsonResponse
    {
        $guestLists = $repository->findAll();
        $data = [];
        foreach ($guestLists as $guestList) {
            $data[] = [
                'id' => $guestList->getId(),
                'name' => $guestList->getName(),
                'isPresent' => $guestList->getIsPresent(),
                'tables' => $guestList->getTableId(),
            ];
        }
        return $this->json($data);
    }
}