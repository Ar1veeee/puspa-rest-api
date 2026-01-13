<?php

namespace App\Enums;

enum AssessmentType: string
{
    case PAEDAGOG_ASSESSOR = 'paedagog_assessor';
    case WICARA_ASSESSOR = 'wicara_assessor';
    case FISIO_ASSESSOR = 'fisio_assessor';
    case OKUPASI_ASSESSOR = 'okupasi_assessor';

    case UMUM_PARENT = 'umum_parent';
    case WICARA_PARENT = 'wicara_parent';
    case PAEDAGOG_PARENT = 'paedagog_parent';
    case OKUPASI_PARENT = 'okupasi_parent';
    case FISIO_PARENT = 'fisio_parent';


    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
