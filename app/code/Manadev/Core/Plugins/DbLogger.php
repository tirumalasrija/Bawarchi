<?php
/** 
 * @copyright   Copyright (c) http://www.manadev.com
 * @license     http://www.manadev.com/license  Proprietary License
 */

namespace Manadev\Core\Plugins;

use Magento\Framework\DB\LoggerInterface;
use Manadev\Core\QueryLogger;

class DbLogger {
    protected $timer;

    /**
     * @var QueryLogger
     */
    protected $queryLogger;

    public function __construct(QueryLogger $queryLogger) {
        $this->queryLogger = $queryLogger;
    }

    public function beforeStartTimer(LoggerInterface $dbLogger) {
        $this->timer = microtime(true);
    }

    public function beforeLogStats(LoggerInterface $dbLogger, $type, $sql, $bind = [], $result = null) {
        $time = sprintf('%.1f ms', (microtime(true) - $this->timer) * 1000);
        $this->queryLogger->log($type, $sql, $time, $bind, $result);
    }
}