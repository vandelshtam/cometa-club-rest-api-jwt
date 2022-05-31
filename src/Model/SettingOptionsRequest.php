<?php

namespace App\Model;

use Symfony\Component\Validator\Constraints\NotBlank;

class SettingOptionsRequest
{
    #[NotBlank]
    private int $payments_singleline;

    #[NotBlank]
    private int $payments_direct;

    #[NotBlank]
    private int $cash_back;

    #[NotBlank]
    private int $all_price_pakage;

    #[NotBlank]
    private int $accrual_limit;

    #[NotBlank]
    private int $system_revenues;

    #[NotBlank]
    private int $update_day;

    #[NotBlank]
    private int $limit_wallet_from_line;

    #[NotBlank]
    private int $payments_direct_fast;

    //#[NotBlank]
    private string $multi_pakage_day;

    //#[NotBlank]
    private string $name_multi_pakage;

    #[NotBlank]
    private int $start_day;

    #[NotBlank]
    private int $privileget_members;

    //#[NotBlank]
    private string $fast_start;

    private string $created_at;

    private string $updated_at;


    public function getPaymentsSingleline(): int
    {
        return $this->payments_singleline;
    }

    public function setPaymentsSingleline(int $payments_singleline): self
    {
        $this->payments_singleline = $payments_singleline;

        return $this;
    }

    public function getCashBack(): int
    {
        return $this->cash_back;
    }

    public function setCashBack(int $cash_back): self
    {
        $this->cash_back = $cash_back;

        return $this;
    }

    public function getAllPricePakage(): int
    {
        return $this->all_price_pakage;
    }

    public function setAllPricePakage(int $all_price_pakage): self
    {
        $this->all_price_pakage = $all_price_pakage;

        return $this;
    }

    public function getAccrualLimit(): int
    {
        return $this->accrual_limit;
    }

    public function setAccrualLimit(int $accrual_limit): self
    {
        $this->accrual_limit = $accrual_limit;

        return $this;
    }

    public function getSystemRevenues(): int
    {
        return $this->system_revenues;
    }

    public function setSystemRevenues(int $system_revenues): self
    {
        $this->system_revenues = $system_revenues;

        return $this;
    }

    public function getPaymentsDirect(): int
    {
        return $this->payments_direct;
    }

    public function setPaymentsDirect(int $payments_direct): self
    {
        $this->payments_direct = $payments_direct;

        return $this;
    }

    public function getUpdateDay(): int
    {
        return $this->update_day;
    }

    public function setUpdateDay(int $update_day): self
    {
        $this->update_day = $update_day;

        return $this;
    }

    public function getLimitWalletFromLine(): int
    {
        return $this->limit_wallet_from_line;
    }

    public function setLimitWalletFromLine(int $limit_wallet_from_line): self
    {
        $this->limit_wallet_from_line = $limit_wallet_from_line;

        return $this;
    }

    public function getPaymentsDirectFast(): int
    {
        return $this->payments_direct_fast;
    }

    public function setPaymentsDirectFast(int $payments_direct_fast): self
    {
        $this->payments_direct_fast = $payments_direct_fast;

        return $this;
    }

    public function getMultiPakageDay(): string
    {
        return $this->multi_pakage_day;
    }

    public function setMultiPakageDay(string $multi_pakage_day): self
    {
        $this->multi_pakage_day = $multi_pakage_day;

        return $this;
    }

    public function getNameMultiPakage(): string
    {
        return $this->name_multi_pakage;
    }

    public function setNameMultiPakage(string $name_multi_pakage): self
    {
        $this->name_multi_pakage = $name_multi_pakage;

        return $this;
    }

    public function getStartDay(): int
    {
        return $this->start_day;
    }

    public function setStartDay(int $start_day): self
    {
        $this->start_day = $start_day;

        return $this;
    }

    public function getPrivilegetMembers(): int
    {
        return $this->privileget_members;
    }

    public function setPrivilegetMembers(int $privileget_members): self
    {
        $this->privileget_members = $privileget_members;

        return $this;
    }

    public function getFastStart(): string
    {
        return $this->fast_start;
    }

    public function setFastStart(string $fast_start): self
    {
        $this->fast_start = $fast_start;

        return $this;
    }

    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    public function setCreatedAt(string $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(string $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }
}
