<?php

namespace App\Controller;

use App\Entity\Room;
use App\Entity\Meeting;
use App\Entity\DateBlocked;
use App\Entity\Booking;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MeetingController extends AbstractController
{
    /**
     * @Route("/reservation/verif/dispo", name="dispo", methods={"GET"})
     * @return JsonResponse
     * @throws Exception
     */
    public function availabilityCheck(Request $request, EntityManagerInterface $manager): Response
    {
        $date = $request->query->get('date');
        $meeting = $request->query->get('meeting');
        $room = $request->query->get('room');

        $verifyDate = $manager
            ->getRepository(DateBlocked::class)
            ->findOneBy([
              'blockedDate' => new \DateTime($date)
            ]);

        if ($verifyDate) {
            return $this->json(['message' => 'Cette date n\'est pas disponible']);
        }

            $roomValue = $manager
                ->getRepository(Room::class)
                ->find($room);

            $meetingValue = $manager
                ->getRepository(Meeting::class)
                ->find($meeting);

                $booking = $manager->getRepository(Booking::class)->findOneBy([
                  'bookingDate' => new \DateTime($date),
                  'meeting' => $meetingValue,
                  'room' => $roomValue
                ]);

        if ($booking) {
            return new JsonResponse([
              'available' => false
            ]);
        }
        return new JsonResponse([
          'available' => true
        ]);
    }
}
