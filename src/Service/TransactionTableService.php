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
            ->setCreatedAt($transactionTable->getCreatedAt()->getTimestamp());
    }

    public function pakegeNew($pakage_user_price,$user_id,$pakage_id)
    {
        $transaction = new TransactionTable();
        $transaction  -> setCreatedAt(new \DateTime());
        $transaction  -> setUpdatedAt(new \DateTime()); 
        $transaction -> setPakagePrice($pakage_user_price);
        $transaction -> setUserId($user_id);
        $transaction -> setPakageId($pakage_id);
        $transaction -> setSomme($pakage_user_price);
        $transaction -> setToken('usdt');
        $transaction -> setType('new pakage');//type 7
        $this->em->persist($transaction);
        $this->em->flush();
    }

    public function walletAdd($summ,$user_id,$wallet_id,$type_opation,$parent_user_id)
    {
        $transaction = new TransactionTable();
        $transaction  -> setCreatedAt(new \DateTime());
        $transaction  -> setUpdatedAt(new \DateTime()); 
        $transaction -> setPakagePrice($summ);
        $transaction -> setUserId($user_id);
        $transaction -> setParentUserId($parent_user_id);
        $transaction -> setWalletId($wallet_id);
        $transaction -> setSomme($summ);
        $transaction -> setToken($type_opation);
        $transaction -> setType('add wallet');//type 24
        $this->em->persist($transaction);
        $this->em->flush();
    }
    
}
