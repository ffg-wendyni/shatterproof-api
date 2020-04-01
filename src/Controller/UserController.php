<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use App\Repository\LocationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserController
{
    private $userRepository;
    private $locationRepository;

    public function __construct(UserRepository $userRepository, LocationRepository $locationRepository)
    {
        $this->userRepository = $userRepository;
        $this->locationRepository = $locationRepository;
    }

    /**
     * @Route("/users/add", name="add_user", methods={"POST"})
     */
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $userInfo = $data['userInfo'];
        $locationInfo = $data['addressInfo'];

        foreach ($locationInfo as $field => $value) {
            if (empty($value)) {
                throw new NotFoundHttpException('Expecting mandatory address parameter: '.$field);
            }
        }

        $location = $this->locationRepository->saveLocation($locationInfo);
        $userInfo['location'] = $location;

        foreach ($userInfo as $field => $value) {
            if (empty($value)) {
                throw new NotFoundHttpException('Expecting mandatory user parameter: '.$field);
            }
        }

        $this->userRepository->saveUser($userInfo);

        return new JsonResponse(['status' => 'User created!'], Response::HTTP_CREATED);
    }

    /**
     * @Route("/users/{userId}", name="get_one_user", methods={"GET"})
     */
    public function get(int $userId): JsonResponse
    {
        $user = $this->userRepository->findOneBy(['userId' => $userId]);

        if (!$user) {
            throw new NotFoundHttpException(
                'No user found for id '.$userId
            );
        }

        $data  = $user->toArray();

        return new JsonResponse($data, Response::HTTP_OK);

    }

    /**
     * @Route("/users/update", name="update_one_user", methods={"POST"})
     */
    public function update(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (empty($data['userId'])) {
            throw new NotFoundHttpException('Expecting mandatory userId!');
        }

        $this->userRepository->updateUser($data);

        return new JsonResponse(['status' => 'Updated user '. $data['userId'] .'!'], Response::HTTP_ACCEPTED);
    }
}