<?php

namespace App\Service;

use DateTime;
use App\Entity\SavingMail;
use App\Repository\UserRepository;
use App\Repository\SavingMailRepository;
use App\Service\TransactionTableService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;


class MailerService extends AbstractController
{
    public function __construct(private UserRepository $userRepository,
                                private ManagerRegistry $doctrine,
                                private EntityManagerInterface $entityManager, 
                                private SavingMailRepository $savingMailRepository,
                                private EntityManagerInterface $em,
                                private MailerInterface $mailer,
                                private TransactionTableService $transactionTableService
                                )
    {
    }

    public function sendEmail($user_id,$to_email)
    {
        $saving_mail = new SavingMail();
        $email = (new TemplatedEmail())
            ->from('Commet-AT@example.com')
            ->to($to_email)
            ->subject('Time for Symfony Mailer!')
            ->text('Thank you for joining our network and purchasing the package! Go to site ,<a href="http://164.92.159.123"> link </a>')
            ->htmlTemplate('emails/pakage_new.html.twig')
            ->context([
                 'date' => new \DateTime(),
            ]);
            $saving_mail -> setCategory('pakege new');
            $saving_mail -> setUserId($user_id);
            $saving_mail -> setFromMail('Commet-AT@example.com');
            $saving_mail -> setToMail($to_email);
            $saving_mail -> setCreatedAt((new \DateTimeImmutable()));

            try {
                $this->mailer->send($email);
                $saving_mail -> setStatus('success');
                $saving_mail -> setText('Congratulations and thank you for purchasing the package!');
                $notice_mailer = [
                                    'success' =>'An email has been sent to you confirming the purchase of the package  CoMetaClub!'
                                 ]; 
            } catch (TransportExceptionInterface $e) {
                $saving_mail -> setStatus('error');
                $saving_mail -> setText('An unexpected failure of the mail client occurred, the CoMetaClub membership confirmation email was not sent. We apologize, we will send you a confirmation email as soon as possible.');
                $notice_mailer = [
                    'warning' =>'An unexpected failure of the mail client occurred, the CoMetaClub membership confirmation email was not sent. We apologize, we will send you a confirmation email as soon as possible.'
                 ]; 
            } 
            $this->em->persist($saving_mail);
            $this->em->flush();            
            
            return $notice_mailer;
    }

    public function sendEmailAddWallet($user_id,$to_email,$summ,$type_opation)
    {
        $saving_mail = new SavingMail();
        $email = (new TemplatedEmail())
            ->from('Commet-AT@example.com')
            ->to($to_email)
            ->subject('Time for Symfony Mailer!')
            ->text('Thank you for joining our network and purchasing the package! Go to site ,<a href="http://164.92.159.123"> link </a>')
            ->htmlTemplate('emails/wallet_add_create.html.twig')
            ->context([
                 'date' => new \DateTime(),
                 'summ' => $summ,
                 'token' => $type_opation
            ]);
            $saving_mail -> setCategory('add wallet');
            $saving_mail -> setUserId($user_id);
            $saving_mail -> setFromMail('Commet-AT@example.com');
            $saving_mail -> setToMail($to_email);
            $saving_mail -> setCreatedAt((new \DateTimeImmutable()));

            try {
                $this->mailer->send($email);
                $saving_mail -> setStatus('success');
                $saving_mail -> setText('Congratulations! You have successfully replenished your wallet.');
                $notice_mailer = [
                                    'success' =>'An e-mail has been sent to you about the successful replenishment of the wallet.'
                                 ]; 
            } catch (TransportExceptionInterface $e) {
                $saving_mail -> setStatus('error');
                $saving_mail -> setText('An unexpected failure of the mail client occurred, the CoMetaClub membership confirmation email was not sent. We apologize, we will send you a confirmation email as soon as possible.');
                $notice_mailer = [
                    'warning' =>'An unexpected failure of the mail client occurred, the CoMetaClub membership confirmation email was not sent. We apologize, we will send you a confirmation email as soon as possible.'
                 ]; 
            } 
            $this->em->persist($saving_mail);
            $this->em->flush();            
            
            return $notice_mailer;
    }
}