<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CNPJRule implements Rule
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
        $cnpj = preg_replace('/[\D]/', '',  $value);
        // Valida  // tips: usar a regra do laravel digits:14  [ https://laravel.com/docs/6.x/validation#rule-digits ]
        //        // Valida tamanho
        if (strlen($cnpj) !== 14) {
            return false;
        }
        // Valida primeiro dígito verificador
        for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++) {
            $soma +=  $cnpj[$i] * $j;
            $j = ($j === 2) ? 9 : $j - 1;
        }
        $resto = $soma % 11;
        if ($cnpj[12] !== (string) ($resto < 2 ? 0 : 11 - $resto)) {
            return false;
        }
        // Valida segundo dígito verificador
        for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++) {
            $soma += $cnpj[$i] * $j;
            $j = ($j === 2) ? 9 : $j - 1;
        }
        $resto = $soma % 11;
        return $cnpj[13] ===  (string) ($resto < 2 ? 0 : 11 - $resto);
    }
    
    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
//      Recomendado usar o recurso de tradução do Laravel, porém outras formas de retornar abaixo.
        return trans('validation.cnpj');
//        return 'O :attribute não é válido.';
//        return 'The :attribute is not valid.';
    }
}
