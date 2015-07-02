<?php

require_once("Spider.php");

class SpiderSintegra extends Spider {

    private $pattern  = '/<td.+titulo[^>]*>([^<]+)\s*:?\s*<\/td>\s*<td.+valor[^>]*>([^<]+)<\/td>/misU';

    public function search($cnpj) {
        $webpage = $this->request(
            'www.sintegra.es.gov.br/resultado.php',
            'POST', '',
            array('num_cnpj' => $cnpj, 'botao' => 'Consultar')
        );

        $webpage = utf8_encode($webpage);

        preg_match_all($this->pattern , $webpage, $matches);

        $titles = $matches[1];
        foreach ($titles as $k => $v) $titles[$k] = $this->sanitize($v);

        $values = $matches[2];
        foreach ($values as $k => $v) $values[$k] = $this->sanitize($v);

        $result = array_combine($titles, $values);

        return json_encode($result);
    }

    private function sanitize($str) {
        $str = preg_replace('/^\s*|&nbsp;|\:|\s*$/m', '', $str);
        return html_entity_decode($str, ENT_QUOTES, 'UTF-8');
    }
}