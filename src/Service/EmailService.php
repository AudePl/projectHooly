<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use App\Entity\Reservation;

class EmailService
{
    public function __construct(
        private MailerInterface $mailer,
        private Environment $twig
    ) {
    }

    private function sendEmail(string $destinataire, string $objet, string $contenu)
    {
        $email = (new Email())
            ->to($destinataire)
            ->subject($objet)
            ->html($contenu);

        $this->mailer->send($email);

        return new Response('Email envoyé !');
    }

    public function mailRappelReservation(Reservation $reservation)
    {

        $destinataire = $reservation->getFoodtruck()->getEmail();
        $objet = "Votre foodtruck " . $reservation->getFoodtruck()->getNom() . " est attendu !";

        $contenu = $this->twig->render('emails/rappelReservation.html.twig', [
                'reservation' => $reservation,
                ]);

        $this->sendEmail($destinataire, $objet, $contenu);
    }

}