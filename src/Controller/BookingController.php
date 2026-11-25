<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\PartyGame;
use App\Entity\User;
use App\Enum\BookingStatus;
use App\Repository\BookingRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class BookingController extends AbstractController
{
    #[IsGranted("ROLE_USER")]
    #[Route('/booking/{id}/book', name: 'app_booking', methods:["POST"])]
    public function booking(
        Request $request,
        EntityManagerInterface $entityManager,
        PartyGame $partyGame,
        BookingRepository $bookingRepository
    ): Response
    {

        if (!$this->isCsrfTokenValid(
            'book_' . $partyGame->getId(),
            $request->request->get("_csrf_token")
        )) {
            $this->addFlash('error', "Token is invalid");
            return $this->redirectToRoute('app_board_game');
        }

        $user = $this->getUser();
        if (!$user instanceof User) {
            $this->addFlash("error", "User is not connected");
            throw $this->createAccessDeniedException();
        }

        $existingBooking = $bookingRepository->searchByUserAndPartyGame($user, $partyGame);
        if ($existingBooking) {
            $this->addFlash('error', "You have already registered for this party game");
            return $this->redirectToRoute("app_board_game");
        }

        // $availableSpace = $partyGame->getAvailableSpace();
        // if ($availableSpace === null || $availableSpace < 1) {
            // $this->addFlash('error', "You cannot book this party game because it has full place");
            // return $this->redirectToRoute('app_board_game');
        // }

        $date = new DateTimeImmutable();

        $booking = new Booking();

        $booking->setUser($user);
        $booking->setPartyGame($partyGame);
        $booking->setBookingDate($date);
        $booking->setStatus(BookingStatus::BOOKED);
        // $partyGame->setAvailableSpace($availableSpace - 1);

        // mettre dans la base de données
        $entityManager->persist($booking);
        $entityManager->flush();

        $this->addFlash('success', sprintf(
            'Your booking has been confirmed for %s.',
            $date->format('d/m/Y')
        ));


        
        return $this->redirectToRoute("app_board_game");
    }

    #[IsGranted("ROLE_USER")]
    #[Route('/booking', name: 'app_booking', methods:["GET"])]
    public function showBookingByUser(): Response
    {
        $user = $this->getUser();

        if (!$user instanceof User) {
            throw $this->createAccessDeniedException();
        }

        $bookings = $user->getBookings();

        return $this->render('booking/index.html.twig', [
            'bookings' => $bookings,
        ]);
    }
}
