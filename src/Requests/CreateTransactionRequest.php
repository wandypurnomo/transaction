<?php


namespace Wandxx\Transaction\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Wandxx\Support\Interfaces\DefaultRequestInterface;

class CreateTransactionRequest extends FormRequest implements DefaultRequestInterface
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [];
    }

    public function data(): array
    {
        return [
            "code" => Str::random(),
        ];
    }
}