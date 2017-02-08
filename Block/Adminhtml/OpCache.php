<?php

namespace TrashPanda\OpCacheMonitor\Block\Adminhtml;

use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context;

/**
 * @author Aydin Hassan <aydin@hotmail.co.uk>
 */
class OpCache extends Template
{
    private $config = [];
    private $status = [];

    public function __construct(Context $context)
    {
        parent::__construct($context);

        $this->config = opcache_get_configuration();
        $this->status = opcache_get_status();
    }

    public function opCacheEnabled() : string
    {
        return $this->getDirectives()['opcache.enable'];
    }

    public function getDirectives() : array
    {
        return $this->config['directives'];
    }

    public function getVersion() : string
    {
        return $this->config['version']['version'];
    }

    public function getBlackList() : array
    {
        return $this->config['blacklist'];
    }

    public function getAvailableMemoryInBytes() : string
    {
        return $this->formatBytes($this->config['directives']['opcache.memory_consumption']);
    }

    public function getUsedMemoryInBytes() : string
    {
        return $this->formatBytes($this->status['memory_usage']['used_memory']);
    }

    public function getFreeMemoryInBytes() : string
    {
        return $this->formatBytes($this->status['memory_usage']['free_memory']);
    }

    public function getWastedMemoryInBytes() : string
    {
        return $this->formatBytes($this->status['memory_usage']['wasted_memory']);
    }

    public function getUsedMemory() : int
    {
        return $this->status['memory_usage']['used_memory'];
    }

    public function getFreeMemory() : int
    {
        return $this->status['memory_usage']['free_memory'];
    }

    public function getWastedMemory() : int
    {
        return $this->status['memory_usage']['wasted_memory'];
    }

    public function getNumCachedKeys() : int
    {
        return $this->status['opcache_statistics']['num_cached_scripts'];
    }

    public function getNumFreeCacheKeys() : int
    {
        $stats = $this->status['opcache_statistics'];
        return $stats['max_cached_keys'] - $stats['num_cached_keys'];
    }

    public function getNumWastedCacheKeys() : int
    {
        $stats = $this->status['opcache_statistics'];
        return $stats['num_cached_keys'] - $stats['num_cached_scripts'];
    }

    public function scripts() : array
    {
        return array_map(function ($script) {
            $script['memory_consumption'] = $this->formatBytes($script['memory_consumption']);
            return $script;
        }, $this->status['scripts']);
    }

    public function status()
    {
        return $this->status;
    }

    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= pow(1024, $pow);
        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
