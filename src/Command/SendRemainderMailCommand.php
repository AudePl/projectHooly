<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Repository\ReservationRepository;
use App\Service\EmailService;
use App\Entity\Reservation;

#[AsCommand(
    name: 'app:reservation:sendRemainderMail',
    description: "Commande d'envoi des mails de rappel la veille d'une reservation à 18h.",
)]
class SendRemainderMailCommand extends Command
{
    public function __construct(
        private ReservationRepository $reservationRepository,
        private EmailService $emailService
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        #$today = new \Datetime('now');
        $today = new \Datetime('2025-08-19');
        $tomorrow = $today->modify('+1 day')->setTime(0, 0, 0);

        $allReservationsForTomorrow = $this->reservationRepository->findByDate($tomorrow);

        foreach ($allReservationsForTomorrow as $reservation) {
               
            $this->emailService->mailRappelReservation($reservation);

        }
        
        $io->success('Les mails de rappels sont bien envoyés.');

        return Command::SUCCESS;
    }
}
