<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CPFRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
//      Recebe só os números
        $cpf = preg_replace('/\D/', '', $value);
//      Verifica se o CPF tem 11 dígitos
//      tips: usar a regra do laravel digits:11  [ https://laravel.com/docs/6.x/validation#rule-digits ]
        if (strlen($cpf) !== 11) {
            return false;
        }
//      Calculo para validação do numero
        for ($i = 9; $i < 11; $i++) {
            for ($j = 0, $char = 0; $char < $i; $char++) {
                $j += $cpf{$char} * (($i + 1) - $char);
            }
            $j = ((10 * $j) % 11) % 10;
            if ($cpf{$char} !== $j) {
                return false;
            }
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
//      Recomendado usar o recurso de tradução do Laravel, porém outras formas de retornar abaixo.
        return trans('validation.cpf');
//        return 'O :attribute não é válido.';
//        return 'The :attribute is not valid.';


    }
}
