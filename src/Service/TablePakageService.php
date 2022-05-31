<?php

namespace App\Service;

use DateTime;
use App\Entity\TablePakage;
use App\Model\TablePakageRequest;
use App\Model\PakageAllListResponse;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\TablePakageRepository;
use App\Model\PakageCategory as PakageCategoryModel;
use App\Exception\TablePakageAlreadyExistsException;

class TablePakageService
{
    public function __construct(private TablePakageRepository $tablePakageRepository,
                                private EntityManagerInterface $em,
                                )
    {
    }

    public function pakageNew(TablePakageRequest $tablePakageRequest)
    {
        if ($this->tablePakageRepository->existsByName($tablePakageRequest->getName())) {
            throw new TablePakageAlreadyExistsException();
        }

        $pakage = (new TablePakage())
            ->setName($tablePakageRequest->getName())
            ->setPricePakage($tablePakageRequest->getPricePakage())
            ->setDescription($tablePakageRequest->getDescription())
            ->setCreatedAt((new \DateTime()))
            ->setUpdatedAt((new \DateTime()))
            ;

        

        $this->em->persist($pakage);
        $this->em->flush();

        return $pakage;
    }

    public function pakages(): PakageAllListResponse
    {
        $pakages = $this->tablePakageRepository->findByAllPakage();

        $items = array_map(
            fn (TablePakage $tablePakage) => new PakageCategoryModel(
                $tablePakage->getId(), $tablePakage->getName(), $tablePakage->getPricePakage(),$tablePakage->getDescription()
            ),
            $pakages
        );

        return new PakageAllListResponse($items);
    }

    public function update($entityManager,$tablePakageRequest,$table_pakage_id): PakageAllListResponse
    {
        $update_pakage = $entityManager->getRepository(TablePakage::class)->findOneBy(['id' => $table_pakage_id]);
        $update_pakage -> setName($tablePakageRequest->getName());
        $update_pakage -> setPricePakage($tablePakageRequest->getPricePakage());
        $update_pakage -> setDescription($tablePakageRequest->getDescription());
        $update_pakage -> setUpdatedAt((new \DateTime()));

        $this->em->persist($update_pakage);
        $this->em->flush();

        $pakage = $this->tablePakageRepository->getByTokenPakageOne($table_pakage_id);
        $items = array_map(
            fn (TablePakage $tablePakage) => new PakageCategoryModel(
                $tablePakage->getId(), $tablePakage->getName(), $tablePakage->getPricePakage(),$tablePakage->getDescription()
            ),
            $pakage
        );

        return new PakageAllListResponse($items);
    }

}
