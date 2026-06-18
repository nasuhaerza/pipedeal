<?php

namespace App\Enums;

enum UserRole: string
{
    case SUPER_ADMIN = 'super_admin';
    case COMPANY_ADMIN = 'company_admin';
    case BUSINESS_DEVELOPMENT = 'business_development';
}
