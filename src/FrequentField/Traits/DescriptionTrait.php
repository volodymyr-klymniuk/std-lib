<?php

namespace VolodymyrKlymniuk\StdLib\FrequentField\Traits;

trait DescriptionTrait
{
    /**
     * @var null|string
     */
    protected $description;

    /**
     * @return null|string
     */
    public function getDescription():? string
    {
        return $this->description;
    }

    /**
     * @param null|string $description
     *
     * @return $this
     */
    public function setDescription(string $description = null)
    {
        $this->description = $description;

        return $this;
    }
}