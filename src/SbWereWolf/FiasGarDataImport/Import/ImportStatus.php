<?php

declare(strict_types=1);

namespace SbWereWolf\FiasGarDataImport\Import;

use JsonSerializable;
use SbWereWolf\JsonSerializable\JsonSerializeTrait;

class ImportStatus implements JsonSerializable
{
    use JsonSerializeTrait;

    private int $successInserts;
    private int $insertAffected;
    private int $failureInserts;
    private int $successUpdates;
    private int $updateAffected;
    private int $failureUpdates;

    /**
     * @param int $successInserts
     * @param int $insertAffected
     * @param int $failureInserts
     * @param int $successUpdates
     * @param int $updateAffected
     * @param int $failureUpdates
     */
    public function __construct(
        int $successInserts,
        int $insertAffected,
        int $failureInserts,
        int $successUpdates,
        int $updateAffected,
        int $failureUpdates,
    ) {
        $this->successInserts = $successInserts;
        $this->insertAffected = $insertAffected;
        $this->failureInserts = $failureInserts;
        $this->successUpdates = $successUpdates;
        $this->updateAffected = $updateAffected;
        $this->failureUpdates = $failureUpdates;
        /*$this->scriptMem = $scriptMem;
        $this->scriptAllocated = $scriptAllocated;
        $this->scriptMaxMem = $scriptMaxMem;*/
    }

    /**
     * @return int
     */
    public function getSuccessInserts(): int
    {
        return $this->successInserts;
    }

    /**
     * @return int
     */
    public function getInsertAffected(): int
    {
        return $this->insertAffected;
    }

    /**
     * @return int
     */
    public function getFailureInserts(): int
    {
        return $this->failureInserts;
    }

    /**
     * @return int
     */
    public function getSuccessUpdates(): int
    {
        return $this->successUpdates;
    }

    /**
     * @return int
     */
    public function getUpdateAffected(): int
    {
        return $this->updateAffected;
    }

    /**
     * @return int
     */
    public function getFailureUpdates(): int
    {
        return $this->failureUpdates;
    }
}