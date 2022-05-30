<?php

namespace App\Service;

use App\Entity\PakagesCategory;
//use App\Model\PakagesCategory;
use App\Model\PakagesCategory as PakagesCategoryModel;
use App\Model\PakageAllListResponse;
use App\Repository\PakagesCategoryRepository;

class PakagesCategoryService
{
    public function __construct(private PakagesCategoryRepository $pakagesCategoryRepository)
    {
    }

    public function getPakages(): PakageAllListResponse
    {
        $pakages = $this->pakagesCategoryRepository->findByAllPakages();
        $items = array_map(
            fn (PakagesCategory $pakagesCategory) => new PakagesCategoryModel(
                $pakagesCategory->getId(), $pakagesCategory->getName(), $pakagesCategory->getPricePakage(),$pakagesCategory->getDescription()
            ),
            $pakages
        );

        return new PakageAllListResponse($items);
    }
}
