<?php

namespace Javer\InfluxDB\DataFixtures\Executor;

use Doctrine\Common\DataFixtures\Executor\AbstractExecutor;
use Javer\InfluxDB\DataFixtures\Purger\MeasurementPurger;
use Javer\InfluxDB\ODM\MeasurementManager;

/**
 * Class MeasurementExecutor
 *
 * @package Javer\InfluxDB\DataFixtures\Executor
 */
class MeasurementExecutor extends AbstractExecutor
{
    private MeasurementManager $measurementManager;

    /**
     * MeasurementExecutor constructor.
     *
     * @param MeasurementManager     $measurementManager
     * @param MeasurementPurger|null $purger
     */
    public function __construct(MeasurementManager $measurementManager, ?MeasurementPurger $purger = null)
    {
        $this->measurementManager = $measurementManager;

        if ($purger !== null) {
            $this->purger = $purger;
            $this->purger->setMeasurementManager($measurementManager);
        }

        parent::__construct($measurementManager);
    }

    /**
     * Execute.
     *
     * @param array   $fixtures
     * @param boolean $append
     */
    public function execute(array $fixtures, $append = false): void
    {
        if ($append === false) {
            $this->purge();
        }

        foreach ($fixtures as $fixture) {
            $this->load($this->measurementManager, $fixture);
        }
    }
}
