<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PlacaRule implements Rule
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
        // Valida  // tips: usar a regra do laravel digits:7  [ https://laravel.com/docs/6.x/validation#rule-digits ]
        $placa = preg_replace('/[^A-Za-z\d]/','',$value);
        if (strlen($placa)!== 7 ){
            return false;
        }
        //Valida o padrão da placa do mercosul SSS9S99 e placa atual SSS-9999
        if(preg_match('/[A-Z]{3}[\d][A-Z][\d]{2}/',$placa) || preg_match('/^[a-zA-Z]{3}\d{4}/',$placa)){
            return true;
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        //      Recomendado usar o recurso de tradução do Laravel, porém outras formas de retornar abaixo.
        return trans('validation.placa');
//        return 'O :attribute não é válido.';
//        return 'The :attribute is not valid.';
    
    }
}
