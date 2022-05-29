<?php

namespace App\Helpers;

class Constant
{
    const HTTP_RESPONSE_STATUSES = [
        'success'             => ['code' => 200, 'label' => 'Success'],
        'failed'              => ['code' => 400, 'label' => 'Failed'],
        'validationError'     => ['code' => 422, 'label' => 'Validation Error'],
        'authenticationError' => ['code' => 401, 'label' => 'Authentication Error'],
        'authorizationError'  => ['code' => 403, 'label' => 'Authorization Error'],
        'serverError'         => ['code' => 500, 'label' => 'Server Error'],
    ];
}