<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NotGenericStoreName implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$value) {
            return;
        }

        $genericTerms = [
            'loja',
            'lojinha',
            'lojão',
            'lojao',
            'receita',
            'receitas',
            'amigurumi',
            'artesanato',
            'artesanatos',
            'crochê',
            'croche',
            'tricô',
            'trico',
            'confecção',
            'confeccao',
            'ateliê',
            'atelie',
        ];

        $prepositions = ['de', 'do', 'da', 'dos', 'das', 'a', 'o', 'as', 'os', 'e'];

        // Normaliza o nome da loja removendo acentos e convertendo para minúsculas
        $normalizedValue = mb_strtolower($value, 'UTF-8');
        $normalizedValue = $this->removeAccents($normalizedValue);

        // Remove pontuação e caracteres especiais
        $normalizedValue = preg_replace('/[^\w\s]/u', ' ', $normalizedValue);

        // Divide em palavras
        $words = preg_split('/\s+/', trim($normalizedValue));
        $words = array_filter($words);

        if (empty($words)) {
            $fail('O nome da loja não pode estar vazio.');
            return;
        }

        // Conta quantas palavras são genéricas ou preposições
        $genericCount = 0;
        foreach ($words as $word) {
            if (in_array($word, $genericTerms) || in_array($word, $prepositions)) {
                $genericCount++;
            }
        }

        // Se mais de 80% das palavras são genéricas, rejeita
        $genericPercentage = ($genericCount / count($words)) * 100;

        if ($genericPercentage >= 80) {
            $fail('O nome da loja é muito genérico. Por favor, escolha um nome mais específico e único para sua loja.');
        }

        // Verifica se o nome contém apenas termos genéricos (mesmo que seja uma palavra)
        if (count($words) <= 3 && $genericCount === count($words)) {
            $fail('O nome da loja é muito genérico. Por favor, escolha um nome mais específico e único para sua loja.');
        }
    }

    /**
     * Remove acentos de uma string
     */
    private function removeAccents(string $string): string
    {
        $map = [
            'á' => 'a', 'à' => 'a', 'ã' => 'a', 'â' => 'a', 'ä' => 'a',
            'é' => 'e', 'è' => 'e', 'ê' => 'e', 'ë' => 'e',
            'í' => 'i', 'ì' => 'i', 'î' => 'i', 'ï' => 'i',
            'ó' => 'o', 'ò' => 'o', 'õ' => 'o', 'ô' => 'o', 'ö' => 'o',
            'ú' => 'u', 'ù' => 'u', 'û' => 'u', 'ü' => 'u',
            'ç' => 'c', 'ñ' => 'n',
        ];

        return strtr($string, $map);
    }
}
