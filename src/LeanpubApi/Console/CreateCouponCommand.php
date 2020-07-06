<?php
declare(strict_types=1);

namespace LeanpubApi\Console;

use Assert\Assertion;
use DateTimeImmutable;
use LeanpubApi\Coupons\CreateCoupon;
use LeanpubApi\Coupons\PackageDiscount;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use function Safe\array_combine;

final class CreateCouponCommand extends BaseCommand
{
    protected function configure(): void
    {
        $this->setName('leanpub:create-coupon')
            ->addArgument('coupon_code', InputArgument::REQUIRED)
            ->addArgument('start_date', InputArgument::REQUIRED)
            ->addArgument('end_date', InputArgument::OPTIONAL)
            ->addOption('package_slug', null, InputOption::VALUE_IS_ARRAY | InputOption::VALUE_REQUIRED)
            ->addOption('discounted_price', null, InputOption::VALUE_IS_ARRAY | InputOption::VALUE_REQUIRED)
            ->addOption('max_uses', null, InputOption::VALUE_REQUIRED)
            ->addOption('note', null, InputOption::VALUE_REQUIRED)
            ->addOption('suspended')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $createCoupon = $this->createCouponDtoFromInput($input);

        $this->leanpubApi($output)->createCoupon(
            $createCoupon
        );

        $output->writeln('Created coupon: ' . $createCoupon->couponCode());

        return 0;
    }

    protected function createCouponDtoFromInput(InputInterface $input): CreateCoupon
    {
        $packageDiscounts = [];
        $packageSlugs = $input->getOption('package_slug');
        Assertion::isArray($packageSlugs);
        Assertion::allString($packageSlugs);

        $discountedPrices = $input->getOption('discounted_price');
        Assertion::isArray($discountedPrices);
        Assertion::allString($discountedPrices);

        $discountedPriceBySlug = array_combine($packageSlugs, $discountedPrices);
        foreach ($discountedPriceBySlug as $packageSlug => $discountedPrice) {
            $packageDiscounts[] = new PackageDiscount((string)$packageSlug, (float)$discountedPrice);
        }

        $couponCode = $input->getArgument('coupon_code');
        Assertion::string($couponCode);
        $note = $input->getOption('note');
        Assertion::nullOrString($note);
        $suspended = $input->getOption('suspended');
        Assertion::boolean($suspended);

        $maxUses = $input->getOption('max_uses');
        $maxUses = is_string($maxUses) ? (int)$maxUses : null;

        $startDate = $input->getArgument('start_date');
        Assertion::string($startDate);
        $startDate = new DateTimeImmutable($startDate);

        $endDate = $input->getArgument('end_date');
        $endDate = is_string($endDate) ? new DateTimeImmutable($endDate) : null;

        return new CreateCoupon(
            $couponCode,
            $packageDiscounts,
            $startDate,
            $endDate,
            $maxUses,
            $note,
            $suspended
        );
    }
}
