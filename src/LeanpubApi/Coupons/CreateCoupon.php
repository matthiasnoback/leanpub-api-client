<?php
declare(strict_types=1);

namespace LeanpubApi\Coupons;

use Assert\Assert;
use DateTimeImmutable;

final class CreateCoupon
{
    private const DATE_FORMAT = 'Y-m-d';

    private string $couponCode;
    /**
     * @var array<PackageDiscount>
     */
    private array $packageDiscounts;
    private DateTimeImmutable $startDate;
    private ?DateTimeImmutable $endDate;
    private ?int $maxUses;
    private ?string $note;
    private bool $suspended;

    /**
     * @param array<PackageDiscount> $packageDiscounts
     */
    public function __construct(
        string $couponCode,
        array $packageDiscounts,
        DateTimeImmutable $startDate,
        ?DateTimeImmutable $endDate,
        ?int $maxUses,
        ?string $note,
        bool $suspended
    ) {
        Assert::that($couponCode)->notEmpty();
        Assert::that($packageDiscounts)->notEmpty();

        if ($maxUses === 0) {
            $maxUses = null;
        }

        if ($note === '') {
            $note = null;
        }

        $this->couponCode = $couponCode;
        $this->packageDiscounts = $packageDiscounts;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->maxUses = $maxUses;
        $this->note = $note;
        $this->suspended = $suspended;
    }

    public function couponCode(): string
    {
        return $this->couponCode;
    }

    /**
     * @return array<string,mixed>
     */
    public function asArray(): array
    {
        return [
            'coupon' => [
                'coupon_code' => $this->couponCode,
                'start_date' => $this->startDate->format(self::DATE_FORMAT),
                'end_date' => $this->endDate ? $this->endDate->format(self::DATE_FORMAT) : null,
                'package_discounts_attributes' => array_map(
                    function (PackageDiscount $packageDiscount): array {
                        return $packageDiscount->asArray();
                    },
                    $this->packageDiscounts
                ),
                'max_uses' => $this->maxUses,
                'note' => $this->note,
                'suspended' => $this->suspended
            ]
        ];
    }
}
