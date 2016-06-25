<?php

class pagecontrol {

    function start() {
        $url = $_SERVER['REQUEST_URI'];
        $pages = explode('/', $url);
        $var['pages'] = $pages;
        $var['proto'] = strtolower(preg_replace('/[^a-zA-Z]/', '', $_SERVER['SERVER_PROTOCOL'])) . '://';
        $var['domain'] = $_SERVER['SERVER_NAME'];
        $var['complete'] = $var['proto'] . $var['domain'] . $url;
        $var['urlmaster'] = $url;
        for ($i = 0; $i < count($var['pages']); $i++) {
            $var['url'][$i] = $var['proto'] . $var['domain'];
            for ($i2 = 0; $i2 < $i + 1; $i2++) {
                $var['url'][$i] .= $var['pages'][$i2] . '/';
            }
        }
        $bget = explode('?', $url);
        if (isset($bget[1])) {
            $var['get'] = $_GET;
            for ($i = 0; $i < count($var['pages']); $i++) {
                $var['url'][$i] = $var['domain'];
                for ($i2 = 0; $i2 < count($i + 1); $i2++) {
                    $var['url'][$i] .= $var['pages'][$i2] . '/';
                }
                $rem = explode('?', $var['pages'][$i]);
                if (isset($rem[1])) {
                    $var['pages'][$i] = $rem[0];
                } else {
                    $var['pages'][$i] = $var['pages'][$i];
                }
            }
        }
        return $var;
    }

    public function getPages($start) {
        return $start['pages'];
    }

    public function getQuery($start) {
        return $start['get'];
    }

    public function getDomain($start) {
        return $start['domain'];
    }

    public function getProto($start) {
        return $start['proto'];
    }

    public function getCompleteurl($start) {
        return $start['complete'];
    }

    public function getChildList($start) {
        return $start['url'];
    }

    public function setPageStruct($root, $headers, $footer, $pagepath = null, $pagecustom = null) {
        $page = $this->start();

        $html = new phpHtml();
        $html->url = $page['proto'] . $page['domain'];
        $form = new form();
        //$form->configdatabase('usuario', 'configdatabase.json'); //leio o arquivo com todas as tabelas para a instalacao na base de dados
        $form->requetwait($_POST, 'usuario'); // fico aguardando os posts
        
        // topo
        if ($headers) {
            foreach ($headers as $header) {
                include $root . '/view/elements/' . $header . '.php';
            }
        }
        if ($pagecustom) {
            if (file_exists($root . '/view/page/' . $pagecustom . '.php')) {
                include $root . '/view/page/' . $pagecustom . '.php';
            } else {
                include $root . '/view/page/404.php';
            }
        } else {
            if ($page["pages"][1] == null) {
                include $root . '/view/page/' . $pagepath . '/index.php';
            } else {
                if (file_exists($root . '/view/page/' . $pagepath . '/' . $page['pages'][1] . '.php')) {
                    include $root . '/view/page/' . $pagepath . '/' . $page['pages'][1] . '.php';
                } else {
                    include $root . '/view/page/' . $pagepath . '/404.php';
                }
            }
        }
        if ($footer) {
            include $root . '/view/elements/' . $footer . '.php';
        }
    }

}

?>