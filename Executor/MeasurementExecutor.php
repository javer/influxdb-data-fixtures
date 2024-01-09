<?php

namespace Javer\InfluxDB\DataFixtures\Executor;

use Doctrine\Common\DataFixtures\Executor\AbstractExecutor;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Javer\InfluxDB\DataFixtures\Purger\MeasurementPurger;
use Javer\InfluxDB\ODM\MeasurementManager;

final class MeasurementExecutor extends AbstractExecutor
{
    public function __construct(
        private readonly MeasurementManager $measurementManager,
        ?MeasurementPurger $purger = null,
    )
    {
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
