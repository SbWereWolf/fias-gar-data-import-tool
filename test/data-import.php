<?php

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\LogRecord;
use SbWereWolf\BatchFileScripting\Configuration\EnvReader;
use SbWereWolf\BatchFileScripting\Convertation\DurationPrinter;
use SbWereWolf\FiasGarDataImport\Cli\ImportCommand;
use SbWereWolf\FiasGarDataImport\Cli\ImportOptions;
use SbWereWolf\FiasGarDataImport\Import\Processor\AddHouseTypes;
use SbWereWolf\FiasGarDataImport\Import\Processor\AddressObjectDivision;
use SbWereWolf\FiasGarDataImport\Import\Processor\AddressObjectParams;
use SbWereWolf\FiasGarDataImport\Import\Processor\AddressObjects;
use SbWereWolf\FiasGarDataImport\Import\Processor\AddressObjectTypes;
use SbWereWolf\FiasGarDataImport\Import\Processor\AdministrativeHierarchy;
use SbWereWolf\FiasGarDataImport\Import\Processor\Apartments;
use SbWereWolf\FiasGarDataImport\Import\Processor\ApartmentsParams;
use SbWereWolf\FiasGarDataImport\Import\Processor\ApartmentTypes;
use SbWereWolf\FiasGarDataImport\Import\Processor\CarPlaces;
use SbWereWolf\FiasGarDataImport\Import\Processor\CarPlacesParams;
use SbWereWolf\FiasGarDataImport\Import\Processor\ChangeHistory;
use SbWereWolf\FiasGarDataImport\Import\Processor\Houses;
use SbWereWolf\FiasGarDataImport\Import\Processor\HousesParams;
use SbWereWolf\FiasGarDataImport\Import\Processor\HouseTypes;
use SbWereWolf\FiasGarDataImport\Import\Processor\MunicipalHierarchy;
use SbWereWolf\FiasGarDataImport\Import\Processor\NormativeDocuments;
use SbWereWolf\FiasGarDataImport\Import\Processor\NormativeDocumentsKinds;
use SbWereWolf\FiasGarDataImport\Import\Processor\NormativeDocumentsTypes;
use SbWereWolf\FiasGarDataImport\Import\Processor\ObjectLevels;
use SbWereWolf\FiasGarDataImport\Import\Processor\OperationTypes;
use SbWereWolf\FiasGarDataImport\Import\Processor\ParamTypes;
use SbWereWolf\FiasGarDataImport\Import\Processor\ReestrObjects;
use SbWereWolf\FiasGarDataImport\Import\Processor\Rooms;
use SbWereWolf\FiasGarDataImport\Import\Processor\RoomsParams;
use SbWereWolf\FiasGarDataImport\Import\Processor\RoomTypes;
use SbWereWolf\FiasGarDataImport\Import\Processor\Steads;
use SbWereWolf\FiasGarDataImport\Import\Processor\SteadsParams;

$startMoment = hrtime(true);

$message = 'Script is starting';
echo $message . PHP_EOL;

$pathParts = [__DIR__, '..', 'vendor', 'autoload.php',];
$path = implode(DIRECTORY_SEPARATOR, $pathParts);
require_once($path);

$logger = new Logger('common');

$logsPath = [
    __DIR__,
    'logs',
    pathinfo(__FILE__, PATHINFO_FILENAME) . '-' . time() . '.log',
];
$path = implode(DIRECTORY_SEPARATOR, $logsPath);

$writeHandler = new StreamHandler($path);
$logger->pushHandler($writeHandler);

$logger->pushProcessor(function ($record) {
    /** @var LogRecord $record */
    echo "{$record->datetime} {$record->message}" . PHP_EOL;

    return $record;
});

$logger->notice($message);

$configurationPath = [__DIR__, 'pdo.env',];
$path = implode(DIRECTORY_SEPARATOR, $configurationPath);
(new EnvReader($path))->defineConstants();

$connection = (new PDO(
    constant('DSN'),
    constant('LOGIN'),
    constant('PASSWORD'),
));

$schema = constant('SCHEMA');
$connection->exec("SET search_path TO {$schema}");

$directory = constant('FILES_PATH');
$command = new ImportCommand($connection, $logger, $directory);

$doAddNewWithCheck = constant('DO_IMPORT_WITH_CHECK') !== 'FALSE';
$options = new ImportOptions(
    $doAddNewWithCheck,
    [
        AddHouseTypes::class =>
            'AS_ADDHOUSE_TYPES_20*.{x,X}{m,M}{l,L}',
        AddressObjectTypes::class =>
            'AS_ADDR_OBJ_TYPES_20*.{x,X}{m,M}{l,L}',
        ApartmentTypes::class =>
            'AS_APARTMENT_TYPES_20*.{x,X}{m,M}{l,L}',
        HouseTypes::class =>
            'AS_HOUSE_TYPES_20*.{x,X}{m,M}{l,L}',
        NormativeDocumentsKinds::class =>
            'AS_NORMATIVE_DOCS_KINDS_20*.{x,X}{m,M}{l,L}',
        NormativeDocumentsTypes::class =>
            'AS_NORMATIVE_DOCS_TYPES_20*.{x,X}{m,M}{l,L}',
        ObjectLevels::class =>
            'AS_OBJECT_LEVELS_20*.{x,X}{m,M}{l,L}',
        OperationTypes::class =>
            'AS_OPERATION_TYPES_20*.{x,X}{m,M}{l,L}',
        ParamTypes::class =>
            'AS_PARAM_TYPES_20*.{x,X}{m,M}{l,L}',
        RoomTypes::class =>
            'AS_ROOM_TYPES_20*.{x,X}{m,M}{l,L}',
    ],
    '{1,2,3,4,5,6,7,8,9,0}{1,2,3,4,5,6,7,8,9,0}',
    [
        AddressObjects::class =>
            'AS_ADDR_OBJ_20*.{x,X}{m,M}{l,L}',
        AddressObjectDivision::class =>
            'AS_ADDR_OBJ_DIVISION_20*.{x,X}{m,M}{l,L}',
        AddressObjectParams::class =>
            'AS_ADDR_OBJ_PARAMS_20*.{x,X}{m,M}{l,L}',
        AdministrativeHierarchy::class =>
            'AS_ADM_HIERARCHY_20*.{x,X}{m,M}{l,L}',
        Apartments::class =>
            'AS_APARTMENTS_20*.{x,X}{m,M}{l,L}',
        ApartmentsParams::class =>
            'AS_APARTMENTS_PARAMS_20*.{x,X}{m,M}{l,L}',
        CarPlaces::class =>
            'AS_CARPLACES_20*.{x,X}{m,M}{l,L}',
        CarPlacesParams::class =>
            'AS_CARPLACES_PARAMS_20*.{x,X}{m,M}{l,L}',
        ChangeHistory::class =>
            'AS_CHANGE_HISTORY_20*.{x,X}{m,M}{l,L}',
        Houses::class =>
            'AS_HOUSES_20*.{x,X}{m,M}{l,L}',
        HousesParams::class =>
            'AS_HOUSES_PARAMS_20*.{x,X}{m,M}{l,L}',
        MunicipalHierarchy::class =>
            'AS_MUN_HIERARCHY_20*.{x,X}{m,M}{l,L}',
        NormativeDocuments::class =>
            'AS_NORMATIVE_DOCS_20*.{x,X}{m,M}{l,L}',
        ReestrObjects::class =>
            'AS_REESTR_OBJECTS_20*.{x,X}{m,M}{l,L}',
        Rooms::class =>
            'AS_ROOMS_20*.{x,X}{m,M}{l,L}',
        RoomsParams::class =>
            'AS_ROOMS_PARAMS_20*.{x,X}{m,M}{l,L}',
        Steads::class =>
            'AS_STEADS_20*.{x,X}{m,M}{l,L}',
        SteadsParams::class =>
            'AS_STEADS_PARAMS_20*.{x,X}{m,M}{l,L}',
    ],
);

$rowsRead = 0;
$successOperations = 0;
$commitPortion = (int)constant('BATCH_SIZE');
$formatted = number_format($commitPortion, 0, ',', ' ');

$message =
    "Run import FIAS GAR files from `$directory`," .
    " with commit each `$formatted` operations";
$logger->notice($message);

$start = hrtime(true);
$connection->beginTransaction();
foreach (
    $command->run($options, $commitPortion) as $isSuccess
) {
    $rowsRead++;
    if ($isSuccess) {
        $successOperations++;
    }

    $letCommit = $successOperations % $commitPortion == 0;
    if ($letCommit) {
        $connection->commit();

        $finish = hrtime(true);
        $duration = $finish - $start;

        $timeParts = new DurationPrinter();
        $printout = $timeParts->printNanoseconds($duration);
        $formatted = number_format($rowsRead, 0, ',', ' ');
        $scriptAllocated = memory_get_usage(true) / 1024 / 1024;

        $message =
            "Batch duration is $printout," .
            "rows was read is `$formatted`," .
            "mem allocated is `$scriptAllocated`Mb," .
            "import processing with `$successOperations`" .
            " success Operations";
        $logger->info($message);

        $start = hrtime(true);
        $connection->beginTransaction();
    }
}

$hasTransaction = $connection->inTransaction();
if ($hasTransaction) {
    $connection->commit();

    $finish = hrtime(true);
    $duration = $finish - $start;

    $timeParts = new DurationPrinter();
    $printout = $timeParts->printNanoseconds($duration);
    $formatted = number_format($rowsRead, 0, ',', ' ');
    $scriptAllocated = memory_get_usage(true) / 1024 / 1024;

    $message =
        "Batch duration is $printout," .
        "rows was read is `$formatted`," .
        "mem allocated is `$scriptAllocated`Mb," .
        "import processing with `$successOperations`" .
        " success Operations";
    $logger->info($message);
}

$formatted = number_format($rowsRead, 0, ',', ' ');
$scriptMaxMem =
    round(memory_get_peak_usage(true) / 1024 / 1024, 1);

$message =
    "Rows was read is `$formatted`," .
    " import was processed with `$successOperations`" .
    " success operations," .
    " max mem allocated is `$scriptMaxMem`Mb";
$logger->notice($message);

$finishMoment = hrtime(true);

$totalTime = $finishMoment - $startMoment;
$timeParts = new DurationPrinter();
$printout = $timeParts->printNanoseconds($totalTime);

$message = "Import duration is $printout";
$logger->notice($message);

$message = 'Script is finished';
$logger->notice($message);

$logger->close();
