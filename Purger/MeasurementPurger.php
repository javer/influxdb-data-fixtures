<?php

namespace Javer\InfluxDB\DataFixtures\Purger;

use Doctrine\Common\DataFixtures\Purger\PurgerInterface;
use Javer\InfluxDB\ODM\MeasurementManager;

/**
 * Class MeasurementPurger
 *
 * @package Javer\InfluxDB\DataFixtures\Purger
 */
class MeasurementPurger implements PurgerInterface
{
    public const PURGE_MODE_DELETE   = 1;
    public const PURGE_MODE_TRUNCATE = 2;

    private MeasurementManager $measurementManager;

    private int $purgeMode = self::PURGE_MODE_TRUNCATE;

    /**
     * MeasurementPurger constructor.
     *
     * @param MeasurementManager $measurementManager
     */
    public function __construct(MeasurementManager $measurementManager)
    {
        $this->measurementManager = $measurementManager;
    }

    /**
     * Set the purge mode
     *
     * @param integer $mode
     */
    public function setPurgeMode(int $mode): void
    {
        $this->purgeMode = $mode;
    }

    /**
     * Get the purge mode
     *
     * @return integer
     */
    public function getPurgeMode(): int
    {
        return $this->purgeMode;
    }

    /**
     * Set measurementManager.
     *
     * @param MeasurementManager $measurementManager
     */
    public function setMeasurementManager(MeasurementManager $measurementManager): void
    {
        $this->measurementManager = $measurementManager;
    }

    /**
     * Returns measurementManager.
     *
     * @return MeasurementManager
     */
    public function getMeasurementManager(): MeasurementManager
    {
        return $this->measurementManager;
    }

    /**
     * {@inheritDoc}
     */
    public function purge(): void
    {
        $database = $this->measurementManager->getDatabase();

        foreach ($this->measurementManager->getMetadataFactory()->getAllMetadata() as $metadata) {
            if ($this->getPurgeMode() === self::PURGE_MODE_DELETE) {
                $database->query(sprintf('DELETE FROM "%s"', $metadata->getMeasurement()));
            } else {
                $database->query(sprintf('DROP MEASUREMENT "%s"', $metadata->getMeasurement()));
            }
        }
    }
}
