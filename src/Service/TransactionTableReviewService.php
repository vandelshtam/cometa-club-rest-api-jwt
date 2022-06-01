<?php

namespace App\Service;


use DateTime;
use App\Entity\TransactionTable;
use App\Model\TransactionTableReviewPage;
use App\Repository\TransactionTableReviewRepository;
use App\Exception\SettingOptionsFormatDateExistsException;
use App\Model\TransactionTableReview as TransactionTableReviewModel;

class TransactionTableReviewService
{
    private const PAGE_LIMIT = 5;

    public function __construct(private TransactionTableReviewRepository $transactionTableReviewRepository)
    {
    }

    public function getReviewPageByUserId(int $id, int $page): TransactionTableReviewPage
    {
        $offset = max($page - 1, 0) * self::PAGE_LIMIT;
        $paginator = $this->transactionTableReviewRepository->getPageByUserId($id, $offset, self::PAGE_LIMIT);
        $items = [];

        $total = $this->transactionTableReviewRepository->countByUserId($id);
        foreach ($paginator as $item) {
            $items[] = $this->map($item);
        }


        return (new TransactionTableReviewPage())
            ->setPage($page)
            ->setTotal($total)
            ->setPerPage(self::PAGE_LIMIT)
            ->setPages(ceil($total / self::PAGE_LIMIT))
            ->setItems($items);
    }

    public function getReviewPageByDate(string $date, int $page): TransactionTableReviewPage
    {
        $date_regex = '/^(19|20)\d\d[\-\/.](0[1-9]|1[012])[\-\/.](0[1-9]|[12][0-9]|3[01])$/';

        if (!preg_match($date_regex, $date)) {
            throw new SettingOptionsFormatDateExistsException();
        } 
        $date_time = (new \DateTime($date));
        $offset = max($page - 1, 0) * self::PAGE_LIMIT;
        $paginator = $this->transactionTableReviewRepository->getPageByDate($date_time, $offset, self::PAGE_LIMIT);
        $items = [];

        $totals = $this->transactionTableReviewRepository->findByExampleField($date_time);
        
        $total = count($totals);
        
        foreach ($paginator as $item) {
            $items[] = $this->map($item);
        }

        return (new TransactionTableReviewPage())
            ->setPage($page)
            ->setTotal($total)
            ->setPerPage(self::PAGE_LIMIT)
            ->setPages(ceil($total / self::PAGE_LIMIT))
            ->setItems($items);
    }

    public function map(TransactionTable $transactionTable): TransactionTableReviewModel
    {
        return (new TransactionTableReviewModel())
            ->setId($transactionTable->getId())
            ->setNetworkId($transactionTable->getNetworkId())
            ->setUserId($transactionTable->getUserId())
            ->setPakageId($transactionTable->getPakageId())
            ->setCash($transactionTable->getCash())
            ->setDirect($transactionTable->getDirect())
            ->setWithdrawalToWallet($transactionTable->getWithdrawalToWallet())
            ->setWithdrawal($transactionTable->getWithdrawal())
            ->setApplicationWithdrawal($transactionTable->getApplicationWithdrawal())
            ->setApplicationWithdrawalStatus($transactionTable->getApplicationWithdrawalStatus())
            ->setNetworkActivationId($transactionTable->getNetworkActivationId())
            ->setType($transactionTable->getType())
            ->setPakagePrice($transactionTable->getPakagePrice())
            ->setWalletId($transactionTable->getWalletId())
            ->setSomme($transactionTable->getSomme())
            ->setToken($transactionTable->getToken())
            // ->setCreatedAt(serialize($transactionTable->getCreatedAt()))
            ->setCreatedAt($transactionTable->getCreatedAt()->getTimestamp());
    }
}
