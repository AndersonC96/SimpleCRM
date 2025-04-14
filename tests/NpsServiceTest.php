<?php
    use PHPUnit\Framework\TestCase;
    class NpsServiceTest extends TestCase {
        public function testCalculoBasicoDeNps() {
            $notas = [10, 9, 8, 7, 6, 0];
            $promotores = 2; // notas 9,10
            $neutros = 2;    // 8,7
            $detratores = 2; // 6,0
            $total = count($notas);
            $nps = (($promotores - $detratores) / $total) * 100;
            $this->assertEquals(0, $nps);
        }
    }