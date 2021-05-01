<?php

namespace Javer\InfluxDB\DataFixtures\Executor;

use Doctrine\Common\DataFixtures\Executor\AbstractExecutor;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Javer\InfluxDB\DataFixtures\Purger\MeasurementPurger;
use Javer\InfluxDB\ODM\MeasurementManager;

class MeasurementExecutor extends AbstractExecutor
{
    private MeasurementManager $measurementManager;

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
     * @param FixtureInterface[] $fixtures
     * @param bool               $append
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
