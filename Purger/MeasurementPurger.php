<?php

namespace Javer\InfluxDB\DataFixtures\Purger;

use Doctrine\Common\DataFixtures\Purger\PurgerInterface;
use Javer\InfluxDB\ODM\Mapping\ClassMetadata;
use Javer\InfluxDB\ODM\MeasurementManager;

class MeasurementPurger implements PurgerInterface
{
    public const PURGE_MODE_DELETE   = 1;
    public const PURGE_MODE_TRUNCATE = 2;

    private MeasurementManager $measurementManager;

    private int $purgeMode = self::PURGE_MODE_TRUNCATE;

    public function __construct(MeasurementManager $measurementManager)
    {
        $this->measurementManager = $measurementManager;
    }

    public function setPurgeMode(int $mode): void
    {
        $this->purgeMode = $mode;
    }

    public function getPurgeMode(): int
    {
        return $this->purgeMode;
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
        $database = $this->measurementManager->getDatabase();

        foreach ($this->measurementManager->getMetadataFactory()->getAllMetadata() as $metadata) {
            assert($metadata instanceof ClassMetadata);

            if ($this->getPurgeMode() === self::PURGE_MODE_DELETE) {
                $database->query(sprintf('DELETE FROM "%s"', $metadata->getMeasurement()));
            } else {
                $database->query(sprintf('DROP MEASUREMENT "%s"', $metadata->getMeasurement()));
            }
        }
    }
}
