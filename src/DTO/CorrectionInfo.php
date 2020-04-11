<?php

namespace SaveTime\AtolV4\DTO;

use SaveTime\AtolV4\handbooks\CorrectionTypes;

class CorrectionInfo extends BaseDataObject
{
    /** @var string */
    protected $base_date;
    /**    @var string */
    protected $base_name;
    /** @var string */
    protected $base_number;
    /** @var string */
    protected $type;

    public function __construct(CorrectionTypes $type, \DateTime $baseDate, $baseNumber, $baseName)
    {
        $this->type = $type->getValue();
        $this->base_date = $baseDate->format('d.m.Y');
        $this->base_number = (string)$baseNumber;
        $this->base_name = (string)$baseName;
    }
}