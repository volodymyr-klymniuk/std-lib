<?php

namespace VolodymyrKlymniuk\StdLib\FrequentField\Traits;

trait SortableTrait
{
    /**
     * @var int
     */
    protected $sort = 0;

    /**
     * @return int
     */
    public function getSort(): int
    {
        return $this->sort;
    }

    /**
     * @param int $sort
     *
     * @return $this
     */
    public function setSort(int $sort)
    {
        $this->sort = $sort;

        return $this;
    }
}