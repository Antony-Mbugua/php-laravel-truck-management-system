<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class DocumentType extends Enum
{

    const PDF = 'pdf';

    const DOCX = 'docx';

    const IMAGE = 'image';

}
