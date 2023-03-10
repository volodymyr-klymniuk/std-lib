<?php
declare(strict_types=1);

namespace VolodymyrKlymniuk\StdLib\Period;

use VolodymyrKlymniuk\StdLib\Consequence\Change;
use VolodymyrKlymniuk\StdLib\Consequence\ConsequenceCollection;
use VolodymyrKlymniuk\StdLib\Consequence\Creation;
use VolodymyrKlymniuk\StdLib\Consequence\Destruction;

class Computation
{
    /**
     * Checks, does period $a and $b intersect
     */
    static public function isIntersect(PeriodInterface $a, PeriodInterface $b): bool
    {
        $aStart = $a->getFrom();
        $aEnd = $a->getTo();
        $bStart = $b->getFrom();
        $bEnd = $b->getTo();

        return $aStart > $bStart  ? $bEnd >= $aStart || $bEnd === null : $aEnd >= $bStart || $aEnd === null;
    }

    /**
     * Subtracts $subtrahend from $minuend. And return list of consequence
     *
     * @param PeriodInterface $minuend
     * @param PeriodInterface $subtrahend
     *
     * @return ConsequenceCollection
     */
    static public function subtraction(PeriodInterface $minuend, PeriodInterface $subtrahend): ConsequenceCollection
    {
        if (!self::isIntersect($minuend, $subtrahend)) {
            return new ConsequenceCollection();
        }

        $subtrahend = self::expand(clone $subtrahend);
        $isSubtrahendStartBeforeMinuend = $subtrahend->getFrom() === null || ($minuend->getFrom() !== null && ($minuend->getFrom() > $subtrahend->getFrom()));
        $isSubtrahendEndAfterMinuend = $subtrahend->getTo() === null ||  ($minuend->getTo() !== null && $minuend->getTo() < $subtrahend->getTo());

        switch (true) {
            case $isSubtrahendStartBeforeMinuend && $isSubtrahendEndAfterMinuend:

                return new ConsequenceCollection([new Destruction($minuend)]);
            case $isSubtrahendStartBeforeMinuend && !$isSubtrahendEndAfterMinuend:
                $minuend->setFrom($subtrahend->getTo());

                return new ConsequenceCollection([new Change($minuend)]);
            case !$isSubtrahendStartBeforeMinuend && $isSubtrahendEndAfterMinuend:
                $minuend->setTo($subtrahend->getFrom());

                return new ConsequenceCollection([new Change($minuend)]);
            case !$isSubtrahendStartBeforeMinuend && !$isSubtrahendEndAfterMinuend:
                $newPeriod = (clone $minuend)->setFrom($subtrahend->getTo());
                $minuend->setTo($subtrahend->getFrom());

                return new ConsequenceCollection([new Creation($newPeriod), new Change($minuend)]);
            default:
                throw new \LogicException();
        }
    }

    /**
     * Merge period $a with period $b if possible
     *
     * @param PeriodInterface $a
     * @param PeriodInterface $b
     *
     * @return ConsequenceCollection
     */
    static public function merge(PeriodInterface $a, PeriodInterface $b)
    {
        $collection = new ConsequenceCollection();
        $changed = false;

        if (!self::isIntersect($a, self::expand(clone $b))) {
            return $collection;
        }

        if ($a->getFrom() > $b->getFrom()) {
            $a->setFrom($b->getFrom());
            $changed = true;
        }

        if ($a->getTo() !== null && ($b->getTo() === null || $a->getTo() < $b->getTo())) {
            $a->setTo($b->getTo());
            $changed = true;
        }

        $collection[] = new Destruction($b);

        if ($changed) {
            $collection[] = new Change($a);
        }

        return $collection;
    }

    /**
     * Truncate $minuend period
     *
     * @param PeriodInterface $minuend
     * @param PeriodInterface $to
     *
     * @return ConsequenceCollection
     */
    static public function truncate(PeriodInterface $minuend, PeriodInterface $to)
    {
        $changed = false;
        $collection = new ConsequenceCollection();

        if ($to->getFrom() !== null && $to->getFrom() > $minuend->getFrom()) {
            $changed = true;
            $minuend->setFrom(clone $to->getFrom());
        }

        if ($to->getTo() !== null && ($to->getTo() < $minuend->getTo() || $minuend->getTo() === null)) {
            $changed = true;
            $minuend->setTo(clone $to->getTo());
        }

        if ($changed) {
            $collection[] = new Change($minuend);
        }

        return $collection;
    }

    /**
     * Expands the incoming period
     *
     * @param PeriodInterface $object
     * @param string              $before
     * @param string              $after
     *
     * @return PeriodInterface
     */
    static public function expand(PeriodInterface $object, string $before = '-1 second', string $after = '+1 second'): PeriodInterface
    {
        if ($object->getFrom() !== null) {
            $object->getFrom()->modify($before);
        }

        if ($object->getTo() !== null) {
            $object->getTo()->modify($after);
        }

        return $object;
    }

    /**
     * @param PeriodInterface[] $list
     */
    static public function sort(array &$list)
    {
        usort($list, function (PeriodInterface $a, PeriodInterface $b) {

            if ($a->getFrom() === $b->getFrom()) {

                if ($a->getTo() === $b->getTo()) {
                    return 0;
                }

                return $a->getTo() > $b->getTo();
            }

            return $a->getFrom() > $b->getFrom();
        });
    }
}