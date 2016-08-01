<?php

namespace Guardian\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Request extends FormRequest
{
    /**
     * @return \Symfony\Component\HttpFoundation\ParameterBag
     */
    public function getForm()
    {
        return $this->isJson() ? $this->json() : $this->request;
    }
}