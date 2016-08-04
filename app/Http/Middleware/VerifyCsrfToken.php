<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
        '/api/v1/branches',
    ];

    /**
     * @var array
     */
    protected $prefixes = ['#^api#'];

    protected function shouldPassThrough($request)
    {
        foreach ($this->prefixes as $prefix) {
            if (preg_match($prefix, $request->path())) {
                return true;
            }
        }
        return parent::shouldPassThrough($request);
    }

}
