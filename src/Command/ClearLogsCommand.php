<?php

namespace App\Command;

use App\Entity\Exception;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\Service\Attribute\Required;

#[AsCommand(
    name: 'app:clear:logs',
    description: 'Clear old logs.'
)]
class ClearLogsCommand extends Command {

    #[Required]
    public EntityManagerInterface $entityManager;

    protected function execute(InputInterface $input,
                               OutputInterface $output): int {
        $exceptionRepository = $this->entityManager->getRepository(Exception::class);

        $twoMonthAgo = (new DateTime("2 month ago"));;

        $oldExceptionsIt = $exceptionRepository->iterateOlderThan($twoMonthAgo);

        $counter = 0;

        foreach ($oldExceptionsIt as $exception) {
            $this->entityManager->remove($exception);
            $this->entityManager->flush();

            if ($counter >= 5000) {
                break;
            }
            else {
                $counter++;
            }
        }

        $output->writeln("<info>$counter old exception(s) deleted</info>");

        return 0;
    }
}
