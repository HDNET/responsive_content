<?php

declare(strict_types = 1);

namespace HDNET\ResponsiveContent\Domain\Model;

use HDNET\Autoloader\Annotation\DatabaseField;
use HDNET\Autoloader\Annotation\DatabaseTable;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * Content.
 *
 * @DatabaseTable("tt_content")
 */
class Content extends AbstractEntity
{

    /**
     * Cell width small.
     *
     * @var int
     * @DatabaseField(type="int")
     */
    protected $cellWidthSmall = 0;

    /**
     * Cell width medium.
     *
     * @var int
     * @DatabaseField(type="int")
     */
    protected $cellWidthMedium = 0;

    /**
     * Cell width large.
     *
     * @var int
     * @DatabaseField(type="int")
     */
    protected $cellWidthLarge = 0;

    /**
     * @return int
     */
    public function getCellWidthSmall()
    {
        return $this->cellWidthSmall;
    }

    /**
     * @param int $cellWidthSmall
     */
    public function setCellWidthSmall(int $cellWidthSmall)
    {
        $this->cellWidthSmall = $cellWidthSmall;
    }

    /**
     * @return int
     */
    public function getCellWidthMedium()
    {
        return $this->cellWidthMedium;
    }

    /**
     * @param int $cellWidthMedium
     */
    public function setCellWidthMedium(int $cellWidthMedium)
    {
        $this->cellWidthMedium = $cellWidthMedium;
    }

    /**
     * @return int
     */
    public function getCellWidthLarge()
    {
        return $this->cellWidthLarge;
    }

    /**
     * @param int $cellWidthLarge
     */
    public function setCellWidthLarge(int $cellWidthLarge)
    {
        $this->cellWidthLarge = $cellWidthLarge;
    }
}
