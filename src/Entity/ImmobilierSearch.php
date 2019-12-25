<?php

namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;


class ImmobilierSearch{

    /*
     *@var int|null
     */

    private $maxPrice;
    /*
     *@var int|null
     *@Assert\Range(min =10, max =400)
    */
    private $minSurface;


    /**
     * @param mixed $maxPrice
     */
    public function setMaxPrice( int $maxPrice): void
    {
        $this->maxPrice = $maxPrice;
    }

    public function getMaxPrice(): ?int
    {
        return $this->maxPrice;
    }

    /**
     * @param mixed $minSurface
     */
    public function setMinSurface(int $minSurface): void
    {
        $this->minSurface = $minSurface;
    }

    /**
     * @return mixed
     */
    public function getMinSurface():?int
    {
        return $this->minSurface;
    }

    /**
     * @return ArrayCollection

    public function getOptions(): ArrayCollection
    {
        return $this->options;
    }

    /**
     * @param ArrayCollection $options

    public function setOptions(ArrayCollection $options): void
    {
        $this->options = $options;
    }
*/
}
