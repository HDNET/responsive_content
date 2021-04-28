<?php

declare(strict_types=1);

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
     * Cell offset small.
     *
     * @var int
     * @DatabaseField(type="int")
     */
    protected $cellOffsetSmall = 0;

    /**
     * Cell offset medium.
     *
     * @var int
     * @DatabaseField(type="int")
     */
    protected $cellOffsetMedium = 0;

    /**
     * Cell offset large.
     *
     * @var int
     * @DatabaseField(type="int")
     */
    protected $cellOffsetLarge = 0;

    public function getCellWidthSmall()
    {
        return $this->cellWidthSmall;
    }

    public function setCellWidthSmall(int $cellWidthSmall): void
    {
        $this->cellWidthSmall = $cellWidthSmall;
    }

    public function getCellWidthMedium()
    {
        return $this->cellWidthMedium;
    }

    public function setCellWidthMedium(int $cellWidthMedium): void
    {
        $this->cellWidthMedium = $cellWidthMedium;
    }

    public function getCellWidthLarge()
    {
        return $this->cellWidthLarge;
    }

    public function setCellWidthLarge(int $cellWidthLarge): void
    {
        $this->cellWidthLarge = $cellWidthLarge;
    }

    public function getCellOffsetSmall(): int
    {
        return $this->cellOffsetSmall;
    }

    public function setCellOffsetSmall(int $cellOffsetSmall): void
    {
        $this->cellOffsetSmall = $cellOffsetSmall;
    }

    public function getCellOffsetMedium(): int
    {
        return $this->cellOffsetMedium;
    }

    public function setCellOffsetMedium(int $cellOffsetMedium): void
    {
        $this->cellOffsetMedium = $cellOffsetMedium;
    }

    public function getCellOffsetLarge(): int
    {
        return $this->cellOffsetLarge;
    }

    public function setCellOffsetLarge(int $cellOffsetLarge): void
    {
        $this->cellOffsetLarge = $cellOffsetLarge;
    }
}
