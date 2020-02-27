<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserController
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/users/add", name="add_user", methods={"POST"})
     */
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $firstName = $data['firstName'];
        $lastName = $data['lastName'];
        $email = $data['email'];
        $phone = $data['phone'];
        $gender = $data['gender'];
        $ethnicity = $data['ethnicity'];
        $occupation = $data['occupation'];
        $newsletterSub = $data['newsletterSub'];

        if (empty($firstName) || empty($lastName) || empty($email) || empty($phone) || empty($gender) || empty($ethnicity) || empty($occupation) || empty($newsletterSub)) {
            throw new NotFoundHttpException('Expecting mandatory parameters!');
        }

        $this->userRepository->saveUser($firstName, $lastName, $email, $phone, $gender, $ethnicity, $occupation, $newsletterSub);

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