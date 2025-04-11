<?php
    namespace Tisim\SimpleCrm\Services;
    class NpsCalculatorService {
        /**
        * Recebe um array de notas (0-10) e retorna score NPS
        */
        public static function calculate(array $ratings): int {
            $total = count($ratings);
            if ($total === 0) return 0;
            $promoters = count(array_filter($ratings, fn($n) => $n >= 9));
            $detractors = count(array_filter($ratings, fn($n) => $n <= 6));
            $passives = count(array_filter($ratings, fn($n) => $n > 6 && $n <9));
            return round((($promoters - $detractors) / $total) * 100);
        }
    }