<?php

namespace SbWereWolf\FiasGarDataImport\Import;

use JsonSerializable;
use PDO;
use PDOStatement;
use SbWereWolf\FiasGarDataImport\Import\Composition\Composer;
use SbWereWolf\JsonSerializable\JsonSerializeTrait;

abstract class Importer implements JsonSerializable
{
    use JsonSerializeTrait;

    protected int $region = -1;
    protected PDOStatement $select;
    protected PDOStatement $update;
    protected PDOStatement $insert;
    protected Composer $compositor;
    private PDO $connection;
    private Telemetry $telemetry;

    public function __construct(PDO $connection)
    {
        $this->telemetry = new Telemetry();
        $this->connection = $connection;

        $this->prepareSelect();
        $this->prepareInsert();
        $this->prepareUpdate();
    }

    protected function prepareSelect(): PDOStatement
    {
        $sql = $this->getCompositor()->makeSelectQuery();
        $this->select = $this->getConnection()->prepare($sql);

        $bindings = $this->getCompositor()->makeSelectBindings();
        foreach ($bindings as $param => $var) {
            $this->getSelect()->bindParam($param, $bindings[$param]);
        }

        return $this->select;
    }

    protected function getCompositor(): Composer
    {
        return $this->compositor;
    }

    /**
     * @return PDO
     */
    protected function getConnection(): PDO
    {
        return $this->connection;
    }

    /**
     * @return PDOStatement
     */
    protected function getSelect(): PDOStatement
    {
        return $this->select;
    }

    protected function prepareInsert(): PDOStatement
    {
        $sql = $this->getCompositor()->makeInsertQuery();
        $this->insert = $this->getConnection()->prepare($sql);

        $bindings = $this->getCompositor()->makeBindings();
        foreach ($bindings as $param => $var) {
            $this->getInsert()->bindParam($param, $bindings[$param]);
        }

        return $this->insert;
    }

    /**
     * @return PDOStatement
     */
    protected function getInsert(): PDOStatement
    {
        return $this->insert;
    }

    protected function prepareUpdate(): PDOStatement
    {
        $sql = $this->getCompositor()->makeUpdateQuery();
        $this->update = $this->getConnection()->prepare($sql);

        $bindings = $this->getCompositor()->makeBindings();
        foreach ($bindings as $param => $var) {
            $this->getUpdate()->bindParam($param, $bindings[$param]);
        }

        return $this->update;
    }

    /**
     * @return PDOStatement
     */
    protected function getUpdate(): PDOStatement
    {
        return $this->update;
    }

    /**
     * Импортировать данные для заданного региона
     * @param array $data
     * @param int $region
     * @return bool
     */
    public function importData(array $data, int $region = 0): bool
    {
        $this->define($data, $region);
        $isSuccess = $this->assimilate(false);

        return $isSuccess;
    }

    /**
     * @param array $data
     * @param int $region
     * @return void
     */
    protected function define(array $data, int $region): void
    {
        if ($region !== 0) {
            $this->region = $region;
        }
        $this->getCompositor()->bindData($data);
    }

    /**
     * @return bool
     */
    private function assimilate(bool $doAddNewWithCheck = true): bool
    {
        $rows = [];
        if ($doAddNewWithCheck) {
            $this->getSelect()->execute();
            $rows = $this->getSelect()->fetchAll(PDO::FETCH_ASSOC);
        }

        $isSuccess = false;
        $isExists = !empty($rows);
        if ($isExists) {
            $isSuccess = $this->getUpdate()->execute();
        }
        if (!$isExists) {
            $isSuccess = $this->getInsert()->execute();
        }

        $this->getTelemetry()->registrate(
            $isExists,
            $isSuccess,
            $this->getInsert()->rowCount(),
            $this->getUpdate()->rowCount(),
        );

        return $isSuccess;
    }

    /**
     * @return Telemetry
     */
    private function getTelemetry(): Telemetry
    {
        return $this->telemetry;
    }

    /**
     * Обновить данные для заданного региона
     * @param array $data
     * @param int $region
     * @return bool
     */
    public function updateData(array $data, int $region = 0): bool
    {
        $this->define($data, $region);
        $isSuccess = $this->assimilate();

        return $isSuccess;
    }

    public function getReport(): ImportStatus
    {
        $report = $this->getTelemetry()->reportStatus();

        return $report;
    }
}