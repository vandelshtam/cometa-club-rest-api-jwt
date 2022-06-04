<?php

namespace App\Service;

use DateTime;
use App\Entity\SavingMail;
use App\Model\SavingMailReviewPage;
use App\Exception\DateNotFoundException;
use App\Exception\UserNotFoundException;
use App\Exception\EmailNotFoundException;
use App\Exception\CategoryNotFoundException;
use App\Repository\SavingMailReviewRepository;
use App\Exception\EmailSearchNotFoundException;
use App\Exception\CategoryTableNotFoundException;
use App\Model\SavingMailReview as SavingMailReviewModel;
use App\Exception\SettingOptionsFormatDateExistsException;

class SavingMailReviewService
{
    private const PAGE_LIMIT = 5;

    public function __construct(private SavingMailReviewRepository $savingMailReviewRepository)
    {
    }

    public function getReviewPageByUserId(int $id, int $page): SavingMailReviewPage
    {
        if (!$this->savingMailReviewRepository->existsByUserId($id)) {
            throw new UserNotFoundException();
        }
    
        $offset = max($page - 1, 0) * self::PAGE_LIMIT;
        $paginator = $this->savingMailReviewRepository->getPageByUserId($id, $offset, self::PAGE_LIMIT);
        $items = [];

        $total = $this->savingMailReviewRepository->countByUserId($id);
        foreach ($paginator as $item) {
            $items[] = $this->map($item);
        }


        return (new SavingMailReviewPage())
            ->setPage($page)
            ->setTotal($total)
            ->setPerPage(self::PAGE_LIMIT)
            ->setPages(ceil($total / self::PAGE_LIMIT))
            ->setItems($items);
    }

    public function getReviewPageByCategory(string $category, int $page): SavingMailReviewPage
    {
        $category = trim($category, '/.*:;,)([]$%');
        $array_category = [
            'pakage new',
            'pakage upgrade',
            'withdrawal to wallet'
        ];
        if (!in_array($category, $array_category)) {
            throw new CategoryNotFoundException();
        }

        if (!$this->savingMailReviewRepository->existsByCategoryTable($category)) {
            throw new CategoryTableNotFoundException();
        }
    
        $offset = max($page - 1, 0) * self::PAGE_LIMIT;
        $paginator = $this->savingMailReviewRepository->getPageByCategory($category, $offset, self::PAGE_LIMIT);
        $items = [];

        $total = $this->savingMailReviewRepository->countByCategory($category);
        foreach ($paginator as $item) {
            $items[] = $this->map($item);
        }


        return (new SavingMailReviewPage())
            ->setPage($page)
            ->setTotal($total)
            ->setPerPage(self::PAGE_LIMIT)
            ->setPages(ceil($total / self::PAGE_LIMIT))
            ->setItems($items);
    }

    public function getReviewPageByToMail( int $page, $savingMailRequest): SavingMailReviewPage
    {
        
        if (!$this->savingMailReviewRepository->existsByEmail($savingMailRequest->getToMail())) {
            throw new EmailSearchNotFoundException();;
        }
       
        $to_mail = $savingMailRequest->getToMail();
    
        $offset = max($page - 1, 0) * self::PAGE_LIMIT;
        $paginator = $this->savingMailReviewRepository->getPageByToMail($to_mail, $offset, self::PAGE_LIMIT);
        $items = [];

        $total = $this->savingMailReviewRepository->countByToMail($to_mail);
        foreach ($paginator as $item) {
            $items[] = $this->map($item);
        }


        return (new SavingMailReviewPage())
            ->setPage($page)
            ->setTotal($total)
            ->setPerPage(self::PAGE_LIMIT)
            ->setPages(ceil($total / self::PAGE_LIMIT))
            ->setItems($items);
    }

    public function getReviewPageByDate(string $date, int $page): SavingMailReviewPage
    {
        $date_regex = '/^(19|20)\d\d[\-\/.](0[1-9]|1[012])[\-\/.](0[1-9]|[12][0-9]|3[01])$/';

        if (!preg_match($date_regex, $date)) {
            throw new SettingOptionsFormatDateExistsException();
        } 
        $date_time = (new \DateTimeImmutable($date));

        // if (!$this->savingMailReviewRepository->existsByDate($date_time)) {
        //     throw new DateNotFoundException();
        // }
        
        $offset = max($page - 1, 0) * self::PAGE_LIMIT;
        $paginator = $this->savingMailReviewRepository->getPageByDate($date_time, $offset, self::PAGE_LIMIT);
        $items = [];

        $totals = $this->savingMailReviewRepository->findByExampleField($date_time);
        
        $total = count($totals);
        
        foreach ($paginator as $item) {
            $items[] = $this->map($item);
        }

        return (new SavingMailReviewPage())
            ->setPage($page)
            ->setTotal($total)
            ->setPerPage(self::PAGE_LIMIT)
            ->setPages(ceil($total / self::PAGE_LIMIT))
            ->setItems($items);
    }

    public function getReviewPageBy(int $page): SavingMailReviewPage
    {
        $offset = max($page - 1, 0) * self::PAGE_LIMIT;
        $paginator = $this->savingMailReviewRepository->getPageBy($offset, self::PAGE_LIMIT);
        $items = [];

        $total = count($this->savingMailReviewRepository->findByAllSavingMail());

        foreach ($paginator as $item) {
            $items[] = $this->map($item);
        }


        return (new SavingMailReviewPage())
            ->setPage($page)
            ->setTotal($total)
            ->setPerPage(self::PAGE_LIMIT)
            ->setPages(ceil($total / self::PAGE_LIMIT))
            ->setItems($items);
    }

    public function map(SavingMail $savingMail): SavingMailReviewModel
    {
        return (new SavingMailReviewModel())
            ->setId($savingMail->getId())
            ->setUserId($savingMail->getUserId())
            ->setFromMail($savingMail->getFromMail())
            ->setToMail($savingMail->getToMail())
            ->setStatus($savingMail->getStatus())
            ->setText($savingMail->getText())
            ->setCategory($savingMail->getCategory())
            ->setCreatedAt($savingMail->getCreatedAt()->getTimestamp());
    }
}
