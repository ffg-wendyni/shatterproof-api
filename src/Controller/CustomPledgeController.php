<?php

namespace App\Controller;

use App\Entity\CustomPledge;
use App\Repository\CustomPledgeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CustomPledgeController extends AbstractController
{
    private $customPledgeRepository;
    private $mailer;
    private $templating;

    public function __construct(CustomPledgeRepository $customPledgeRepository, \Swift_Mailer $mailer, \Twig\Environment $templating)
        {
            $this->customPledgeRepository = $customPledgeRepository;
            $this->mailer = $mailer;
            $this->templating = $templating;
        }

    /**
     * @Route("/pledge/add", name="add_pledge", methods={"POST"})
     */
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $firstName = $data['firstName'];
        $lastName = $data['lastName'];
        $likeCount = $data['likeCount'];
        $body = $data['body'];
        $approved = $data['approved'];
        $canShare = $data['canShare'];

        if (empty($body) || empty($firstName) || empty($lastName)) {
            throw new NotFoundHttpException('Expecting mandatory pledge parameter');
        }

        $pledgeId = $this->customPledgeRepository->saveCustomPledge($firstName, $lastName, $likeCount, $body, $approved, $canShare);

        return new JsonResponse(['status' => 'Pledge '. $pledgeId .' created!'], Response::HTTP_CREATED);
    }

    /**
     * @Route("/pledge/{pledgeId}", name="get_one_pledge", methods={"GET"})
     */
    public function get($pledgeId): JsonResponse
    {
        $customPledge = $this->customPledgeRepository->findOneBy(['pledgeId' => $pledgeId]);

        $data = [
            'pledgeId' => $customPledge->getPledgeId(),
            'firstName' => $customPledge->getFirstName(),
            'lastName' => $customPledge->getLastName(),
            'likeCount' => $customPledge->getLikeCount(),
            'body' => $customPledge->getBody(),
            'approved' => $customPledge->getApproved(),
            'canShare' => $customPledge->getCanShare()
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/pledge", name="get_all_pledges", methods={"GET"})
     */
    public function getAll(): JsonResponse
    {
        $customPledges = $this->customPledgeRepository->findAll();
        $data = [];

        foreach ($customPledges as $customPledge) {
            $data[] = [
                'pledgeId' => $customPledge->getPledgeId(),
                'firstName' => $customPledge->getFirstName(),
                'lastName' => $customPledge->getLastName(),
                'likeCount' => $customPledge->getLikeCount(),
                'body' => $customPledge->getBody(),
                'approved' => $customPledge->getApproved(),
                'canShare' => $customPledge->getCanShare()
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/pledge/{pledgeId}", name="update_pledge", methods={"PUT"})
     */
    public function update($pledgeId, Request $request): JsonResponse
    {
        $customPledge = $this->customPledgeRepository->findOneBy(['pledgeId' => $pledgeId]);
        $data = json_decode($request->getContent(), true);

        $customPledge->setFirstName($data['firstName']);
        $customPledge->setLastName($data['lastName']);
        $customPledge->setLikeCount($data['likeCount']);
        $customPledge->setBody($data['body']);
        $customPledge->setApproved($data['approved']);
        $customPledge->setCanShare($data['canShare']);

        $updatedCustomPledge = $this->customPledgeRepository->updateCustomPledge($customPledge);

        return new JsonResponse($updatedCustomPledge->toArray(), Response::HTTP_OK);
    }

    /**
     * @Route("/pledge/{pledgeId}", name="delete_pledge", methods={"DELETE"})
     */
    public function delete($pledgeId): JsonResponse
    {
        $customPledge = $this->customPledgeRepository->findOneBy(['pledgeId' => $pledgeId]);

        $this->customPledgeRepository->removeCustomPledge($customPledge);

        return new JsonResponse(['status' => 'Pledge deleted'], Response::HTTP_NO_CONTENT);
    }

    /**
     * @Route("/pledge/email/{pledgeId}", name="email_pledge", methods={"GET"})
     */
     public function email($pledgeId): JsonResponse
     {
        $customPledge = $this->customPledgeRepository->findOneBy(['pledgeId' => $pledgeId]);

        $message = new \Swift_Message('Custom Pledge Approval for Pledge ID '. $customPledge->getPledgeId());
        $message->setFrom($this->getParameter('sender_email'));
        $message->setTo($this->getParameter('receiver_email'));
        $message->setBody(
                $this->templating->render(
                    'emails/customPledge.html.twig',
                    ['body' => $customPledge->getBody(),
                    'id' => $customPledge->getPledgeId(),
                    'firstName' => $customPledge->getFirstName(),
                    'lastName' => $customPledge->getLastName()]
                ),
                'text/html'
            );

        $this->mailer->send($message);
        return new JsonResponse(['status' => 'Pledge '. $pledgeId .' emailed for approval!'], Response::HTTP_OK);
     }

    /**
     * @Route("/pledge/approve/{pledgeId}", name="approve_pledge", methods={"GET"})
     */
    public function approve($pledgeId): JsonResponse
    {
         $customPledge = $this->customPledgeRepository->findOneBy(['pledgeId' => $pledgeId]);
         $customPledge->setApproved(true);

         $updatedCustomPledge = $this->customPledgeRepository->updateCustomPledge($customPledge);

         return new JsonResponse(['status' => 'Pledge '. $pledgeId .' approved!'], Response::HTTP_OK);
    }
}