<?php

namespace App\Service;

use DateTime;
use App\Entity\TokenRate;
use App\Model\TokenRateRequest;
use App\Model\TokenRateListResponse;
use App\Repository\TokenRateRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Model\TokenRate as TokenRateModel;
use App\Model\TokenRateRewiewListResponse;
use App\Exception\TokenRateAlreadyExistsException;

class TokenRateService
{
    public function __construct(private TokenRateRepository $tokenRateRepository,
                                private EntityManagerInterface $em,
                                )
    {
    }

    public function new(TokenRateRequest $tokenRateRequest)
    {

        if (count($this->tokenRateRepository->existsByAll()) >= 1) {
            throw new TokenRateAlreadyExistsException();
        }

        $token_rate = (new TokenRate())
            ->setExchangeRate($tokenRateRequest->getExchangeRate())
            ->setCreatedAt((new \DateTime()))
            ->setUpdatedAt((new \DateTime()));

        $this->em->persist($token_rate);
        $this->em->flush();

        return $token_rate;
    }


    public function update($entityManager,TokenRateRequest $tokenRateRequest): TokenRateListResponse
    {
        $id = 1;
        $update_token_rate = $entityManager->getRepository(TokenRate::class)->findOneBy(['id' => $id]);
        $update_token_rate -> setExchangeRate($tokenRateRequest->getExchangeRate());
        $update_token_rate -> setUpdatedAt(new \DateTime());

        $this->em->persist($update_token_rate);
        $this->em->flush();

        $update_token_rate = $this->tokenRateRepository->getByTokenRate($id);
        $items = array_map(
            fn (TokenRate $tokenRate) => new TokenRateModel(
                $tokenRate->getId(), $tokenRate->getExchangeRate(),
            ),
            $update_token_rate
        );

        return new TokenRateListResponse($items);
    }

    public function rewiew(): TokenRateRewiewListResponse
    {
        $id = 1;
        $token_rate = $this->tokenRateRepository->getByTokenRate($id);

        $items = array_map(
            fn (TokenRate $tokenRate) => new TokenRateModel(
                $tokenRate->getId(), $tokenRate->getExchangeRate(),
            ),
            $token_rate
        );

        return new TokenRateRewiewListResponse($items);
    }
}
