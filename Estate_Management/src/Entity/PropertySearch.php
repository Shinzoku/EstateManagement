<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints\Range as Assert;

class PropertySearch
{

    /**
     *
     * @var int|null
     * @Assert(min=300, max=1000)
     */
    private $maxPrice;

    /**
     *
     * @var int|null
     * @Assert(min=80, max=150)
     */
    private $minSurface;

    /**
     * Get the value of maxPrice
     *
     * @return  int|null
     */
    public function getMaxPrice()
    {
        return $this->maxPrice;
    }

    /**
     * Set the value of maxPrice
     *
     * @param  int|null  $maxPrice
     *
     * @return  self
     */
    public function setMaxPrice($maxPrice): PropertySearch
    {
        $this->maxPrice = $maxPrice;

        return $this;
    }

    /**
     * Get the value of minSurface
     *
     * @return  int|null
     */
    public function getMinSurface()
    {
        return $this->minSurface;
    }

    /**
     * Set the value of minSurface
     *
     * @param  int|null  $minSurface
     *
     * @return  self
     */
    public function setMinSurface($minSurface): PropertySearch
    {
        $this->minSurface = $minSurface;

        return $this;
    }
}
