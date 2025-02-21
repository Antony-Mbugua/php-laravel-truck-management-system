<?php

namespace App\Enums;

enum DocumentType: string
{
    case PDF = 'pdf';
    case DOCX = 'docx';
    case IMAGE = 'image';
}