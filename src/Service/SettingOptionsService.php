<?php

namespace App\Service;

use DateTime;
use App\Entity\SettingOptions;
use App\Model\SettingOptionsRequest;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\SettingOptionsRepository;
use App\Model\SettingOptionsRewiewListResponse;
use App\Exception\TokenRateAlreadyExistsException;
use App\Model\SettingOptions as SettingOptionsModel;
use App\Exception\SettingOptionsFormatDateExistsException;

class SettingOptionsService
{
    public function __construct(private SettingOptionsRepository $settingOptionsRepository,
                                private EntityManagerInterface $em,
                                )
    {
    }

    public function new(SettingOptionsRequest $settingOptionsRequest)
    {

        if (count($this->settingOptionsRepository->existsByAll()) >= 1) {
            throw new TokenRateAlreadyExistsException();
        }

        $setting_options = (new SettingOptions())
            ->setPaymentsSingleline($settingOptionsRequest->getPaymentsSingleline())
            ->setPaymentsDirect($settingOptionsRequest->getPaymentsDirect())
            ->setCashBack($settingOptionsRequest->getCashBack())
            ->setAllPricePakage($settingOptionsRequest->getAllPricePakage())
            ->setAccrualLimit($settingOptionsRequest->getAccrualLimit())
            ->setSystemRevenues($settingOptionsRequest->getSystemRevenues())
            ->setUpdateDay($settingOptionsRequest->getUpdateDay())
            ->setLimitWalletFromLine($settingOptionsRequest->getLimitWalletFromLine())
            ->setPaymentsDirectFast($settingOptionsRequest->getPaymentsDirectFast())
            ->setMultiPakageDay((new \DateTime($settingOptionsRequest->getMultiPakageDay())))
            ->setNameMultiPakage($settingOptionsRequest->getNameMultiPakage())
            ->setStartDay($settingOptionsRequest->getStartDay())
            ->setPrivilegetMembers($settingOptionsRequest->getPrivilegetMembers())
            ->setFastStart((new \DateTime($settingOptionsRequest->getFastStart())))
            ->setCreatedAt((new \DateTime()))
            ->setUpdatedAt((new \DateTime()));

        $this->em->persist($setting_options);
        $this->em->flush();

        return $setting_options;
    }


    public function update($entityManager,SettingOptionsRequest $settingOptionsRequest): SettingOptionsRewiewListResponse
    {
        $date_regex = '/^(19|20)\d\d[\-\/.](0[1-9]|1[012])[\-\/.](0[1-9]|[12][0-9]|3[01])$/';

        if (!preg_match($date_regex, $settingOptionsRequest->getMultiPakageDay())) {
            throw new SettingOptionsFormatDateExistsException();
        } 
        if (!preg_match($date_regex, $settingOptionsRequest->getFastStart())) {
            throw new SettingOptionsFormatDateExistsException();
        } 
        
        $id = 1;
        $update_setting_options = $entityManager->getRepository(SettingOptions::class)->findOneBy(['id' => $id]);
        $update_setting_options -> setPaymentsSingleline($settingOptionsRequest->getPaymentsSingleline());
        $update_setting_options -> setPaymentsDirect($settingOptionsRequest->getPaymentsDirect());
        $update_setting_options -> setCashBack($settingOptionsRequest->getCashBack());
        $update_setting_options -> setAllPricePakage($settingOptionsRequest->getAllPricePakage());
        $update_setting_options -> setAccrualLimit($settingOptionsRequest->getAccrualLimit());
        $update_setting_options -> setSystemRevenues($settingOptionsRequest->getSystemRevenues());
        $update_setting_options -> setUpdateDay($settingOptionsRequest->getUpdateDay());
        $update_setting_options -> setLimitWalletFromLine($settingOptionsRequest->getLimitWalletFromLine());
        $update_setting_options -> setPaymentsDirectFast($settingOptionsRequest->getPaymentsDirectFast());
        $update_setting_options -> setMultiPakageDay(new \DateTime($settingOptionsRequest->getMultiPakageDay()));
        $update_setting_options -> setNameMultiPakage($settingOptionsRequest->getNameMultiPakage());
        $update_setting_options -> setStartDay($settingOptionsRequest->getStartDay());
        $update_setting_options -> setPrivilegetMembers($settingOptionsRequest->getPrivilegetMembers());
        $update_setting_options -> setFastStart(new \DateTime($settingOptionsRequest->getFastStart()));
        $update_setting_options -> setUpdatedAt(new \DateTime());

        $this->em->persist($update_setting_options);
        $this->em->flush();

        $setting_options = $this->settingOptionsRepository->getBySettingOptions($id);
        $items = array_map(
            fn (SettingOptions $settingOptions) => new SettingOptionsModel(
                $settingOptions->getId(), $settingOptions->getPaymentsSingleline(),$settingOptions->getPaymentsDirect(),
                $settingOptions->getCashBack(), $settingOptions->getAllPricePakage(),$settingOptions->getAccrualLimit(),
                $settingOptions->getSystemRevenues(), $settingOptions->getUpdateDay(),$settingOptions->getLimitWalletFromLine(),
                $settingOptions->getPaymentsDirectFast(), $settingOptions->getMultiPakageDay(),$settingOptions->getNameMultiPakage(),$settingOptions->getStartDay(),
                $settingOptions->getPrivilegetMembers(), $settingOptions->getFastStart(),$settingOptions->getCreatedAt(), $settingOptions->getUpdatedAt()
            ),
            $setting_options
        );

        return new SettingOptionsRewiewListResponse($items);
    }

    public function rewiew(): SettingOptionsRewiewListResponse
    {
        $id = 1;
        $setting_options = $this->settingOptionsRepository->getBySettingOptions($id);

        $items = array_map(
            fn (SettingOptions $settingOptions) => new SettingOptionsModel(
                $settingOptions->getId(), $settingOptions->getPaymentsSingleline(),$settingOptions->getPaymentsDirect(),
                $settingOptions->getCashBack(), $settingOptions->getAllPricePakage(),$settingOptions->getAccrualLimit(),
                $settingOptions->getSystemRevenues(), $settingOptions->getUpdateDay(),$settingOptions->getLimitWalletFromLine(),
                $settingOptions->getPaymentsDirectFast(), $settingOptions->getMultiPakageDay(),$settingOptions->getNameMultiPakage(),$settingOptions->getStartDay(),
                $settingOptions->getPrivilegetMembers(), $settingOptions->getFastStart(),$settingOptions->getCreatedAt(), $settingOptions->getUpdatedAt()
            ),
            $setting_options
        );

        return new SettingOptionsRewiewListResponse($items);
    }
}
