<?php

namespace VolodymyrKlymniuk\StdLib\FrequentField\Traits;

trait TitleTrait
{
    /**
     * @var null|string
     */
    protected $title;

    /**
     * @return null|string
     */
    public function getTitle():? string
    {
        return $this->title;
    }

    /**
     * @param null|string $title
     *
     * @return $this
     */
    public function setTitle(string $title = null)
    {
        $this->title = $title;

        return $this;
    }
}