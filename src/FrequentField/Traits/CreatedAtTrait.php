<?php

namespace VolodymyrKlymniuk\StdLib\FrequentField\Traits;

trait CreatedAtTrait
{
    /**
    * @var \DateTime|null
    */
    protected $createdAt;

    /**
     * @return \DateTime|null
     */
    public function getCreatedAt():? \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime|null $createdAt
     *
     * @return $this
     */
    public function setCreatedAt(\DateTime $createdAt = null)
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}