<?php

namespace App\Service;

use App\Entity\TransactionTable;
use Doctrine\ORM\EntityManagerInterface;
use App\Model\TransactionTableReviewPage;
use App\Repository\TransactionTableRepository;
use App\Model\TransactionTableRewiewListResponse;
use App\Repository\TransactionTableReviewRepository;
use App\Model\TransactionTable as TransactionTableModel;
use App\Model\TransactionTableReview as TransactionTableReviewModel;

class TransactionTableService
{
    private const PAGE_LIMIT = 5;

    public function __construct(private TransactionTableRepository $transactionTableRepository,
                                private TransactionTableReviewRepository $transactionTableReviewRepository,
                                private EntityManagerInterface $em,
                                )
    {
    }

    public function rewiew(): TransactionTableRewiewListResponse
    {
        $transaction_table = $this->transactionTableRepository->findByAllTransactionTable();

        $items = array_map(
            fn (TransactionTable $transactionTable) => new TransactionTableModel(
                $transactionTable->getId(), $transactionTable->getNetworkId(),$transactionTable->getUserId(),
                $transactionTable->getPakageId(), $transactionTable->getCash(),$transactionTable->getDirect(),
                $transactionTable->getWithdrawalToWallet(), $transactionTable->getWithdrawal(),$transactionTable->getApplicationWithdrawal(),
                $transactionTable->getApplicationWithdrawalStatus(), $transactionTable->getNetworkActivationId(),$transactionTable->getType(),$transactionTable->getPakagePrice(),
                $transactionTable->getWalletId(), $transactionTable->getSomme(),$transactionTable->getToken(),$transactionTable->getCreatedAt(), $transactionTable->getUpdatedAt()
            ),
            $transaction_table
        );

        return new TransactionTableRewiewListResponse($items);
    }

    public function getReviewPageBy(int $page): TransactionTableReviewPage
    {
        $offset = max($page - 1, 0) * self::PAGE_LIMIT;
        $paginator = $this->transactionTableReviewRepository->getPageBy($offset, self::PAGE_LIMIT);
        $items = [];

        $total = count($this->transactionTableRepository->findAll());

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
