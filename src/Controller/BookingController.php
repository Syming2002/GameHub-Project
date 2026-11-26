<?php

namespace App\Controller;

use App\Entity\BoardGame;
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
    #[Route('/booking/{id}/book', name: 'app_booking', requirements: ["id" => "\d+"], methods:["POST"])]
    public function booking(
        Request $request,
        EntityManagerInterface $entityManager,
        BoardGame $boardGame,
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

        $date = new DateTimeImmutable();

        $booking = new Booking();
        // $boardGame = new BoardGame();

        $booking->setUser($user);
        $booking->setPartyGame($partyGame);
        $booking->setBookingDate($date);
        $booking->setStatus(BookingStatus::BOOKED);

        $boardGame->setNumberPlayer($boardGame->getNumberPlayer() + 1);

        // mettre dans la base de données
        $entityManager->persist($booking);
        $entityManager->flush();

        $this->addFlash('success', sprintf(
            'Your booking has been confirmed for %s.',
            $date->format('d/m/Y')
        ));


        
        return $this->redirectToRoute("app_show_booking");
    }

    #[IsGranted("ROLE_USER")]
    #[Route('/booking/{id}/cancel', name: 'app_booking_cancel', requirements: ["id" => "\d+"], methods:["POST"])]
    public function cancelBooking(
        Request $request,
        EntityManagerInterface $entityManager,
        Booking $booking
    ): Response
    {

        if (!$this->isCsrfTokenValid(
            'cancel_' . $booking->getId(),
            $request->request->get("_csrf_token")
        )) {
            $this->addFlash('error', "Token is invalid");
            return $this->redirectToRoute('app_show_booking');
        }

        $user = $this->getUser();
        if (!$user instanceof User) {
            $this->addFlash("error", "User is not connected");
            throw $this->createAccessDeniedException();
        }

        if ($booking->getUser() !== $user) {
            throw $this->createAccessDeniedException();
        }

        if ($booking->getStatus() !== BookingStatus::BOOKED) {
            $this->addFlash('error', "This booking has already been canceled");
            return $this->redirectToRoute('app_show_booking');
        }

        $booking->setStatus(BookingStatus::CANCELED);

        $entityManager->flush();

        $this->addFlash('success', sprintf(
            'Your booking has been canceled for the following party game %s.',
            $booking->getPartyGame()->getPartyGameName()
        ));

        return $this->redirectToRoute('app_show_booking');
    }

    #[IsGranted("ROLE_USER")]
    #[Route('/booking/{id}/delete', name: 'app_booking_delete', requirements: ["id" => "\d+"], methods:["POST"])]
    public function deleteBooking(
        int $id,
        Request $request,
        EntityManagerInterface $entityManager,
        BookingRepository $bookingRepository
    ): Response
    {
        $booking = $bookingRepository->find($id);

        if (!$this->isCsrfTokenValid(
            'delete_' . $booking->getId(),
            $request->request->get("_csrf_token")
        )) {
            $this->addFlash('error', "Token is invalid");
            return $this->redirectToRoute('app_show_booking');
        }

        $user = $this->getUser();
        if (!$user instanceof User) {
            $this->addFlash("error", "User is not connected");
            throw $this->createAccessDeniedException();
        }

        if ($booking->getUser() !== $user) {
            throw $this->createAccessDeniedException();
        }

        if ($booking->getStatus() !== BookingStatus::CANCELED) {
            $this->addFlash('error', "This booking has not been canceled");
            return $this->redirectToRoute('app_show_booking');
        }

        $entityManager->remove($booking);
        $entityManager->flush();

        $this->addFlash('success',
            'Your booking has been removed from the list.'
        );

        return $this->redirectToRoute('app_show_booking');
    }

    #[IsGranted("ROLE_USER")]
    #[Route('/booking', name: 'app_show_booking', methods:["GET"])]
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
