<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\CustomPledgeRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    private $userRepository;
    private $customPledgeRepository;
    private $mailer;
    private $templating;

    public function __construct(UserRepository $userRepository, CustomPledgeRepository $customPledgeRepository, \Swift_Mailer $mailer, \Twig\Environment $templating)
    {
        $this->userRepository = $userRepository;
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->customPledgeRepository = $customPledgeRepository;
    }

    /**
     * @Route("/users/add", name="add_user", methods={"POST"})
     */
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);


        foreach ($data as $field => $value) {
            if (empty($value) && $field != 'occupation') {
                throw new NotFoundHttpException('Expecting mandatory user parameter: '.$field);
            }
        }

        $newCustomPledge = $this->customPledgeRepository->saveCustomPledge($data['firstName'], $data['lastName'], $data['customPledge'], $data['shareOnMedia']);

        $data['userPledge'] = $newCustomPledge;
        $newUserId = $this->userRepository->saveUser($data);

        $message = new \Swift_Message('Custom Pledge Approval for Pledge ID '. $newCustomPledge->getPledgeId());
        $message->setFrom($this->getParameter('sender_email'));
        $message->setTo($this->getParameter('receiver_email'));
        $message->setBody(
                $this->templating->render(
                    'emails/customPledge.html.twig',
                    ['body' => $newCustomPledge->getBody(),
                    'id' => $newCustomPledge->getPledgeId(),
                    'firstName' => $newCustomPledge->getFirstName(),
                    'lastName' => $newCustomPledge->getLastName()]
                ),
                'text/html'
            );


        $this->mailer->send($message);

        $response = [
            'status' => 'User created!',
            'userId' => $newUserId
        ];
        return new JsonResponse($response, Response::HTTP_CREATED);
    }

    /**
     * @Route("/users", name="get_all_users", methods={"GET"})
     */
    public function get_all_users(int $userId): JsonResponse
    {
        $users = $this->userRepository->findAll();
        $data = [];

        foreach ($users as $user) {
            $data[] = $user->toArray();
        }

        return new JsonResponse($data, Response::HTTP_OK);

    }

    /**
     * @Route("/users/{userId}", name="get_one_user", methods={"GET"})
     */
    public function get($userId): JsonResponse
    {
        $user = $this->userRepository->findOneBy(['userId' => $userId]);

        if (!$user) {
            throw new NotFoundHttpException(
                'No user found for id '.$userId. ' !'
            );
        }

        $data  = $user->toArray();

        return new JsonResponse($data, Response::HTTP_OK);

    }

    /**
     * @Route("/users/{userId}/update", name="update_one_user", methods={"POST"})
     */
    public function update($userId, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $data['userId'] = $userId;

        foreach ($data as $field => $value) {
            if (empty($value) && $field != 'occupation') {
                throw new NotFoundHttpException('Expecting mandatory user parameter: '.$field);
            }
        }

        $this->userRepository->updateUser($data);

        return new JsonResponse(['status' => 'Updated user '. $data['userId'] .'!'], Response::HTTP_ACCEPTED);
    }

    /**
     * @Route("/users/{userId}/delete", name="delete_one_user", methods={"GET"})
     */
    public function delete($userId, Request $request): JsonResponse
    {
        $this->userRepository->deleteUser($userId);

        return new JsonResponse(['status' => 'Deleted user '. $userId .'!'], Response::HTTP_ACCEPTED);
    }
}