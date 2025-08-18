<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Reservation;

class EmailService
{
    public function __construct(
        private MailerInterface $mailer,
    ) {
    }

    private function sendEmail(string $destinataire, string $objet, $contenu)
    {
        $email = (new Email())
            ->to($destinataire)
            ->subject($objet)
            ->text($contenu);

        $this->mailer->send($email);

        return new Response('Email envoyé !');
    }

    public function mailRappelReservation(Reservation $reservation)
    {
        //@TODO / Completer

        $destinataire = $reservation->getFoodtruck()->getEmail();
        $objet = "Rappel : Votre réservation pour votre foodtruck";
        $contenu = "Rappel de votre resa N°" . $reservation->getNumeroReservation() . " pour votre foodtruck : " . $reservation->getFoodtruck()->getNom();
        $this->sendEmail($destinataire, $objet, $contenu);
    }

}