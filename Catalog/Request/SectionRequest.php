<?php

namespace Dyson\Services\Catalog\Request;

class SectionRequest
{
    /** @var int|null */
    public $id;

    /** @var int|null */
    public $rootId;

    /** @var string|null */
    public $code;

    /** @var string|null */
    public $rootCode;

    /** @var int|null */
    public $accessoryId;

    /**
     * @param int|null $id
     * @param int|null $rootId
     * @param string|null $code
     * @param string|null $rootCode
     * @param int|null $accessoryId
     */
    public function __construct($id, $rootId, $code, $rootCode, $accessoryId)
    {
        $this->id = $id;
        $this->rootId = $rootId;
        $this->code = $code;
        $this->rootCode = $rootCode;
        $this->accessoryId = $accessoryId;
    }
}
