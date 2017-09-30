<?php

namespace Modules\Motel\Repositories\Cache;

use Modules\Motel\Repositories\MotelRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheMotelDecorator extends BaseCacheDecorator implements MotelRepository
{
    public function __construct(MotelRepository $motel)
    {
        parent::__construct();
        $this->entityName = 'motel.motels';
        $this->repository = $motel;
    }
}
