<?php

require_once __DIR__ . '/../mysql-webservice-json-api/phpapijson.php';

class form {

    public function newform($inputs, $formMethod, $flag, $custom, $submit, $formAction = null, $formEnctype = null) {
        $form = '<form id="' . $flag . '" method="' . $formMethod . '"';
        if (isset($formAction)) {
            $form .= ' action="' . $formAction . '"';
        } else {
            $form .= ' action="' . $formAction . '"';
        }
        if (isset($formEnctype)) {
            $form .= ' enctype="' . $formEnctype . '"';
        }
        $form .= '>';
        foreach ($inputs as $input) {
            if (isset($input['id'])) {
                $form .= $this->setinput($this->getinputtype($input), $input);
            } else {
                $this->tolog('not found id in input');
            }
        }
        $form .= $custom;
        $form .='<button type="submit">' . $submit . '</button>';
        $form .='<input type="hidden" name="flag" value="' . $flag . '">';
        $form .='</form>';
        return $form;
    }

    public function requetwait($wait, $base = null) {
        if (isset($wait) && isset($wait['flag'])) {
            $flag = explode('_', $wait['flag']);
            if (isset($flag[1])) {
                if ($base) {
                    $requestbd = new phpapijson();
                    $requestbd->base = $base;
                    $requestbd->action = $this->getaction($flag[1]);
                    $requestbd->table = $flag[0];
                    foreach ($wait as $key => $value) {
                        if ($key != 'flag') {
                            $data[$key] = $value;
                        }
                    }
                } else {
                 //   $this->tolog('no database selected');
                }
            } else {
               // $this->tolog('no action on this flag ' . $wait['flag']);
            }
        }
    }

    public function configdatabase($base, $configfile) {
        $config = json_decode(file_get_contents($configfile), true);
        var_dump($config);
    }

    private function getaction($input) {
        if ($input == 'new') {
            $out = 'insert';
        } else if ($input == 'update') {
            $out = 'update';
        } else {
            $out = false;
          ///  $this->tolog('action not found');
        }
        return $out;
    }

    private function newinput($input, $template = 'input') {
        $inputfile = file_get_contents(__DIR__ . '/templates/' . $template . '.html');
        $inputrender = $inputfile;
        foreach ($input as $key => $value) {
            $inputrender = str_replace('{' . $key . '}', $value, $inputrender);
        }
        $inputrender = str_replace('{name}', $input['id'], $inputrender);
        $inputrender = str_replace('{class}', '', $inputrender);
        $inputrender = str_replace('{placeholder}', '', $inputrender);
        $inputrender = str_replace('{type}', 'text', $inputrender);
        $inputrender = str_replace('{label}', '', $inputrender);
        $inputrender = str_replace('{value}', '', $inputrender);
        return $inputrender;
    }

    private function getinputtype($input) {
        if (!isset($input['type'])) {
            $type = 'text';
        } else {
            $type = $input['type'];
        }
        return $type;
    }

    private function setinput($type, $input) {
        if ($type == 'text' || $type == 'email' || $type == 'number' || $type == 'password' || $type == 'file') {
            $inputform = $this->newinput($input, 'input');
        } else if ($type == 'checkbox') {
            $inputform = $this->newinput($input, 'checkbox');
        } else {
        //    $this->tolog('not input type found');
            $inputform = '';
        }
        return $inputform;
    }

    private function tolog($text) {
        $myfile = fopen("log.txt", "a+") or die("Unable to open file!");
        $txt = date('d/m/Y') . ' - ' . date('H:i:s') . ' | ' . $text . "\n";
        fwrite($myfile, $txt);
        fclose($myfile);
    }

}
