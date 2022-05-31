<?php

namespace App\Model;

use DateTime;
use DateTimeInterface;

class SettingOptions
{
    private int $id;

    private int $paymentsSingleline;

    private int $paymentsDirect;

    private int $cashBack;

    private int $allPricePakage;

    private int $accrualLimit;

    private int $systemRevenues;

    private int $updateDay;

    private int $limitWalletFromLine;

    private int $paymentsDirectFast;

    private ?\DateTimeInterface $multiPakageDay;

    private string $nameMultiPakage;

    private int $startDay;

    private int $privilegetMembers;

    private ?\DateTimeInterface $fastStart;

    private ?\DateTimeInterface $createdAt;

    private ?\DateTimeInterface $updatedAt;


    public function __construct(int $id, int $paymentsSingleline, int $paymentsDirect, int $cashBack, 
                                int $allPricePakage, int $accrualLimit, int $systemRevenues, 
                                int $updateDay, int $limitWalletFromLine, int $paymentsDirectFast, 
                                ?\DateTimeInterface $multiPakageDay, string $nameMultiPakage, int $startDay, int $privilegetMembers,
                                ?\DateTimeInterface $fastStart, ?\DateTimeInterface $createdAt, ?\DateTimeInterface $updatedAt)
    {
        $this->id = $id;
        $this->paymentsSingleline = $paymentsSingleline;
        $this->paymentsDirect = $paymentsDirect;
        $this->cashBack = $cashBack;
        $this->allPricePakage =$allPricePakage;
        $this->accrualLimit = $accrualLimit;
        $this->systemRevenues =$systemRevenues;
        $this->updateDay = $updateDay;
        $this->limitWalletFromLine = $limitWalletFromLine;
        $this->paymentsDirectFast = $paymentsDirectFast;
        $this->multiPakageDay = $multiPakageDay;
        $this->nameMultiPakage = $nameMultiPakage;
        $this->startDay =$startDay;
        $this->privilegetMembers = $privilegetMembers;
        $this->fastStart =$fastStart;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getPaymentsSingleline(): int
    {
        return $this->paymentsSingleline;
    }

    public function getPaymentsDirect(): int
    {
        return $this->paymentsDirect;
    }

    public function getCashBack(): int
    {
        return $this->cashBack;
    }

    public function getAllPricePakage(): int
    {
        return $this->allPricePakage;
    }

    public function getAccrualLimit(): int
    {
        return $this->accrualLimit;
    }

    public function getSystemRevenues(): int
    {
        return $this->systemRevenues;
    }

    public function getUpdateDay(): int
    {
        return $this->updateDay;
    }

    public function getLimitWalletFromLine(): int
    {
        return $this->limitWalletFromLine;
    }

    public function getPaymentsDirectFast(): int
    {
        return $this->paymentsDirectFast;
    }

    public function getMultiPakageDay(): ?\DateTimeInterface
    {
        return $this->multiPakageDay;
    }

    public function getNameMultiPakage(): string
    {
        return $this->nameMultiPakage;
    }

    public function getStartDay(): int
    {
        return $this->startDay;
    }

    public function getPrivilegetMembers(): int
    {
        return $this->privilegetMembers;
    }

    public function getFastStart(): ?\DateTimeInterface
    {
        return $this->fastStart;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

}
