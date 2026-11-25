<?php

namespace App\Enum;

    enum BookingStatus: string {
        case AVAILABLE = "Available";
        case BOOKED = "Booked";
        case CANCELED = "Canceled";

        public function voirStatut(): string {
            return match($this) {
                self::AVAILABLE => "Place are available",
                self::BOOKED => "You've booked a party game",
                self::CANCELED => "You just canceled a booking",
            };
        }
    }
?>