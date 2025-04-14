<?php
    use PHPUnit\Framework\TestCase;
    class TemplateParserTest extends TestCase {
        public function testSubstituiVariavelNome() {
            $template = "Olá, {nome}!";
            $substituido = str_replace('{nome}', 'Anderson', $template);
            $this->assertEquals("Olá, Anderson!", $substituido);
        }
    }