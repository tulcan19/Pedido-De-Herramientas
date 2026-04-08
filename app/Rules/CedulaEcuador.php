<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CedulaEcuador implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$this->validarCedula($value)) {
            $fail('La cédula ingresada no es válida para Ecuador.');
        }
    }

    /**
     * Algoritmo de validación de cédula ecuatoriana (Modulo 10).
     */
    private function validarCedula($cedula): bool
    {
        // Validar longitud y que sean solo números
        if (!preg_match('/^[0-9]{10}$/', $cedula)) {
            return false;
        }

        // Obtener código de provincia (primeros 2 dígitos)
        $provincia = (int) substr($cedula, 0, 2);
        if ($provincia < 1 || $provincia > 24) {
            return false;
        }

        // Obtener tercer dígito (debe ser menor a 6 para personas naturales)
        $tercerDigito = (int) $cedula[2];
        if ($tercerDigito > 5) {
            return false;
        }

        // Algoritmo de modulo 10
        $coeficientes = [2, 1, 2, 1, 2, 1, 2, 1, 2];
        $suma = 0;

        for ($i = 0; $i < 9; $i++) {
            $valor = (int) $cedula[$i] * $coeficientes[$i];
            if ($valor > 9) {
                $valor -= 9;
            }
            $suma += $valor;
        }

        $digitoVerificador = (int) $cedula[9];
        $residuo = $suma % 10;
        $resultado = ($residuo === 0) ? 0 : 10 - $residuo;

        return $resultado === $digitoVerificador;
    }
}
