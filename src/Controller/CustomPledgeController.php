<?php

namespace App\Controller;

use App\Repository\CustomPledgeRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CustomPledgeController extends AbstractController
{
    private $customPledgeRepository;

    public function __construct(CustomPledgeRepository $customPledgeRepository)
        {
            $this->customPledgeRepository = $customPledgeRepository;
        }

    /**
     * @Route("/pledges/{pledgeId}", name="get_one_or_all_pledge", methods={"GET"})
     */
    public function get($pledgeId): JsonResponse
    {
        $customPledge = [];
        $data = [];

        if ($pledgeId == "all") {
            $customPledges = $this->customPledgeRepository->findAll();
    
            foreach ($customPledges as $customPledge) {
                $data[] = [
                    'pledgeId' => $customPledge->getPledgeId(),
                    'firstName' => $customPledge->getFirstName(),
                    'lastName' => $customPledge->getLastName(),
                    'likeCount' => $customPledge->getLikeCount(),
                    'pledgeBody' => $customPledge->getBody()
                ];
            }
        } else {
            $customPledge = $this->customPledgeRepository->findOneBy(['pledgeId' => $pledgeId]);

            $data = [
                'pledgeId' => $customPledge->getPledgeId(),
                'firstName' => $customPledge->getFirstName(),
                'lastName' => $customPledge->getLastName(),
                'likeCount' => $customPledge->getLikeCount(),
                'pledgeBody' => $customPledge->getBody(),
                'approved' => $customPledge->getApproved()
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/pledges", name="get_all_pledges", methods={"GET"})
     */
    public function getAll(): JsonResponse
    {
        $customPledges = $this->customPledgeRepository->findBy(['approved' => true]);
        $data = [];

        foreach ($customPledges as $customPledge) {
            $data[] = [
                'pledgeId' => $customPledge->getPledgeId(),
                'firstName' => $customPledge->getFirstName(),
                'lastName' => $customPledge->getLastName(),
                'likeCount' => $customPledge->getLikeCount(),
                'pledgeBody' => $customPledge->getBody()
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/pledges/{pledgeId}/update", name="update_pledge", methods={"POST"})
     */
    public function update($pledgeId, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $customPledge = $this->customPledgeRepository->findOneBy(['pledgeId' => $pledgeId]);

        $customPledge->setFirstName($data['firstName']);
        $customPledge->setLastName($data['lastName']);
        $customPledge->setLikeCount($data['likeCount']);
        $customPledge->setBody($data['pledgeBody']);
        $customPledge->setApproved($data['approved']);

        $updatedCustomPledge = $this->customPledgeRepository->updateCustomPledge($customPledge);

        return new JsonResponse(['status' => 'Updated pledge '. $updatedCustomPledge->getPledgeId() .'!'], Response::HTTP_OK);
    }

    /**
     * @Route("/pledges/{pledgeId}/delete", name="delete_pledge", methods={"GET"})
     */
    public function delete($pledgeId): JsonResponse
    {
        $customPledge = $this->customPledgeRepository->findOneBy(['pledgeId' => $pledgeId]);

        $this->customPledgeRepository->removeCustomPledge($customPledge);

        return new JsonResponse(['status' => 'Deleted pledge '. $pledgeId .'!'], Response::HTTP_NO_CONTENT);
    }

    /**
     * @Route("/pledges/{pledgeId}/approve", name="approve_pledge", methods={"GET"})
     */
    public function approve($pledgeId): JsonResponse
    {
         $customPledge = $this->customPledgeRepository->findOneBy(['pledgeId' => $pledgeId]);
         $customPledge->setApproved(true);

         $updatedCustomPledge = $this->customPledgeRepository->updateCustomPledge($customPledge);

         return new JsonResponse(['status' => 'Approved pledge '. $pledgeId .'!'], Response::HTTP_OK);
    }

    /**
     * @Route("/pledges/{pledgeId}/like", name="like_pledge", methods={"GET"})
     */
    public function like($pledgeId): JsonResponse
    {
         $customPledge = $this->customPledgeRepository->findOneBy(['pledgeId' => $pledgeId]);
         $customPledge->setLikeCount($customPledge->getLikeCount() + 1);

         $updatedCustomPledge = $this->customPledgeRepository->updateCustomPledge($customPledge);

         return new JsonResponse(['status' => 'Pledge '. $pledgeId .' like count increamented!', 'newLikeCount' => $updatedCustomPledge->getLikeCount()], Response::HTTP_OK);
    }
}