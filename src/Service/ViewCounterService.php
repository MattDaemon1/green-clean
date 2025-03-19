<?php

namespace App\Service;

use Symfony\Component\Cache\Adapter\RedisAdapter;
use Symfony\Contracts\Cache\ItemInterface;

class ViewCounterService
{
    private RedisAdapter $redis;

    public function __construct()
    {
        $this->redis = new RedisAdapter(RedisAdapter::createConnection($_ENV['REDIS_URL']));
    }

    public function incrementViewCount(int $projectId): int
    {
        $cacheItem = $this->redis->getItem('project_'.$projectId.'_views');

        if (!$cacheItem->isHit()) {
            $cacheItem->set(0);
        }

        $cacheItem->set($cacheItem->get() + 1);
        $this->redis->save($cacheItem);

        return $cacheItem->get();
    }

    public function getViewCount(int $projectId): int
    {
        return $this->redis->getItem('project_'.$projectId.'_views')->get() ?? 0;
    }
}
