<?php

namespace Javer\InfluxDB\DataFixtures\Purger;

use Doctrine\Common\DataFixtures\Purger\PurgerInterface;
use Javer\InfluxDB\ODM\Mapping\ClassMetadata;
use Javer\InfluxDB\ODM\MeasurementManager;

final class MeasurementPurger implements PurgerInterface
{
    public function __construct(
        private MeasurementManager $measurementManager,
    )
    {
    }

    public function setMeasurementManager(MeasurementManager $measurementManager): void
    {
        $this->measurementManager = $measurementManager;
    }

    public function getMeasurementManager(): MeasurementManager
    {
        return $this->measurementManager;
    }

    public function purge(): void
    {
        foreach ($this->measurementManager->getMetadataFactory()->getAllMetadata() as $metadata) {
            assert($metadata instanceof ClassMetadata);

            $this->measurementManager->getClient()->dropMeasurement($metadata->getMeasurement());
        }
    }
}
