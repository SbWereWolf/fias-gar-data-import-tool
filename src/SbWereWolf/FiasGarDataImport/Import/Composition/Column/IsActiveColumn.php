<?php

namespace SbWereWolf\FiasGarDataImport\Import\Composition\Column;


use SbWereWolf\FiasGarDataImport\Import\Composition\IntColumn;

class IsActiveColumn extends IntColumn
{
    protected const COLUMN_NAME = 'ISACTIVE';
    protected const PARAMETER_NAME = ':ISACTIVE';

    public static function convertToDbValue($val): int
    {
        $res = 0;
        switch ($val) {
            case 'true':
                $res = 1;
                break;
            case '1':
                $res = 1;
                break;
            case 'false':
                $res = 0;
                break;
            case '0':
                $res = 0;
                break;
        }

        return $res;
    }

    public function getParam(): string
    {
        return static::PARAMETER_NAME;
    }

    protected function getColumnName(): string
    {
        return static::COLUMN_NAME;
    }
}