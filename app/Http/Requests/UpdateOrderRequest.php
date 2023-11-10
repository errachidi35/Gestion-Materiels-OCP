<?php

namespace App\Http\Requests;

use App\Order;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateOrderRequest extends FormRequest
{

    public function rules()
    {
        return [
            'client_name' => [
                'required',
            ],
            'client_contact' => [
                'required',
            ],
            'materials.*'    => [
                'integer',
            ],
            'materials'      => [
                'array',
            ],
        ];
    }
}