<?php

/**
 * Description of phpapijson
 *
 * @author guilherme
 */
class phpapijson {

    private $token = 'D5mpOeTWUP+aWGGYPh95VEZNWM5OZKkRhvNbVy0eyUI=';
    private $user = 'dev';
    private $pass = 'dev';
    private $url = 'http://api.labconnect.com.br/';
    public $action = '';
    public $base = '';
    public $table = '';
    public $data = array();
    public $where = array();
    public $where_type = '=';
    public $limit = 100;
    public $colun = '';
    public $orderby = null;
    public $orderby_type = null;

    private function post() {
        $post = array(
            'auth' => $this->token,
            'auth_data[user]' => $this->user,
            'auth_data[pass]' => $this->pass,
            'action' => $this->action,
            'base' => $this->base,
            'table' => $this->table,
            'limit' => $this->limit,
            'coluns' => $this->colun,
            'debug' => '1',
        );
        if (!empty($this->data)) {
            $post['data'] = $this->data;
        }
        if (!empty($this->where)) {
            $post['where'] = $this->where;
        }
        if (!empty($this->where_type)) {
            $post['where_type'] = $this->where_type;
        }
        if (!empty($this->orderby)) {
            $post['orderby'] = $this->orderby;
        }
        if (!empty($this->orderby_type)) {
            $post['orderby_type'] = $this->orderby_type;
        }


        return $post;
    }

    private function send_post($url, $post) {
        $postdata = http_build_query($post);
        $opts = array('http' =>
            array(
                'method' => 'POST',
                'header' => 'Content-type: application/x-www-form-urlencoded',
                'content' => $postdata
            )
        );
        $context = stream_context_create($opts);
        $result = file_get_contents($url, false, $context);
        return $result;
    }

    public function send_data() {
        $result = $this->send_post($this->url, $this->post());
        return $result;
    }

    public function get_result($json) {
        $array = json_decode($json, true);
        if (isset($array[0])) {
            if (isset($array[0]['result'])) {
                return $array[0]['result'];
            } else if (isset($array['erro'])) {
                return $array['erro'];
            }
        }
    }

    public function get_lines($json) {
        $array = json_decode($json, true);
        return $array[1]['lines'];
    }

    public function get_debug($json) {
        $array = json_decode($json, true);
        return $array[2]['debug'];
    }

    private function killzone($var) {
        echo '<pre>';
        print_r($var);
        echo '</pre>';
        die();
    }

    private function tolog($text) {
        $myfile = fopen("log.txt", "a+") or die("Unable to open file!");
        $txt = date('d/m/Y') . ' - ' . date('H:i:s') . ' | ' . $text . "\n";
        if (fwrite($myfile, $txt)) {
            
        }
        fclose($myfile);
    }

}
