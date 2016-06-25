<?php

class phpHtml {

    public $url = '';
    public $title = '';

    public function register_js($url, $echo = 0) {
        $js = '<script src="' . $url . '"></script>';
        if ($echo == 0) {
            return $js;
        } else {
            echo $js;
        }
    }

    public function register_css($url, $echo = 0) {
        $css = '<link rel="stylesheet" href="' . $url . '">';
        if ($echo == 0) {
            return $css;
        } else {
            echo $css;
        }
    }

    public function image($echo = 0, $file, $width = null, $heigth = null, $attr = null, $url = null, $id = null, $class = null, $style = null) {
        if ($url == null) {
            $img = '<img src="' . $this->url . '/view/files/img/' . $file . '"';
        } else {
            $img = '<img src="' . $url . '"';
        }
        if ($id != null) {
            $img .= ' id="' . $id . '"';
        }
        if ($class != null) {
            $img .= ' class="' . $class . '"';
        }
        if ($style != null) {
            $img .=" style='" . $style . "'";
        }
        if ($width != null) {
            $img .= " width='" . $width . "'";
        }
        if ($heigth != null) {
            $img .= " heigth='" . $heigth . "'";
        }
        $img .= '/>';
        if ($echo == 0) {
            return $img;
        } else {
            echo $img;
        }
    }

    public function image_src($echo, $image) {
        if ($echo == 0) {
            return '' . $this->url . '/view/files/img/' . $image . '';
        } else {
            echo '' . $this->url . '/view/files/img/' . $image . '';
        }
    }

    public function title() {
        $name = '';
        $pagename = $this->title;
        $page = new pagecontrol();
        $pages = $page->getPages($page);
        if ($pages[1] == null) {
            $name .= 'Home - ';
        } else {
            foreach ($pages as $path) {
                if ($path == end($pages)) {
                    $name .= urldecode(ucfirst(str_replace('-', ' ', $path)));
                }
            }
            $name .= ' - ';
        }
        $name .= $pagename;
        return '<title>' . $name . '</title>';
    }

    public function message_Warning($msg) {
        return "<div class='nNote nWarning'><p>" . $msg . "</p></div>";
    }

    public function message_Information($msg) {
        return "<div class='nNote nInformation'><p>" . $msg . "</p></div>";
    }

    public function message_Success($msg) {
        return "<div class='nNote nSuccess'><p>" . $msg . "</p></div>";
    }

    public function message_Failure($msg) {
        return "<div class='nNote nFailure'><p>" . $msg . "</p></div>";
    }

    public function get_icon($echo, $icon) {
        $ico = '<i class = "glyphicon glyphicon-' . $icon . '"></i>';
        if ($echo == 0) {
            return $ico;
        } else {
            echo $ico;
        }
    }

    public function redirect($link, $html = 0, $time = 0) {
        if ($html == 0) {
            header("Location: $link"); /* Redirect browser */
            exit; /* Make sure that code below does not get executed when we redirect. */
        } else if ($html == 1) {
            ?>
            <meta http-equiv="refresh" content="<?php echo $time ?>;URL=<?php echo $link ?>">
            <?php
        }
    }

    public function refresh($time = 0) {
        echo "<meta HTTP-EQUIV='refresh' CONTENT='" . $time . ";'>";
    }

    public function printa($array, $type = 0) {
        if ($type == 0) {
            echo '<pre>';
            print_r($array);
            echo '</pre>';
        } else if ($type == 1) {
            $var = '<pre>';
            $var .= print_r($array, true);
            $var .= '</pre>';
            return $var;
        }
    }

    public function sethtml($jsList, $cssList, $title, $type) {
        if ($type == 'top') {
            $html = '<html>';
            $html .= '<head>';
            $html .= '<meta charset="utf-8">';
            $html .= '<meta http-equiv="X-UA-Compatible" content="IE=edge">';
            $html .= '<meta name="viewport" content="width=device-width, initial-scale=1">';
            $html .= '<title>';
            $html .= $title;
            $html .= '</title>';
            foreach ($cssList as $cssFile) {
                $html .= $cssFile;
            }
            if (isset($jsList['header'])) {
                foreach ($jsList['header'] as $jsFile) {
                    $html .= $jsFile;
                }
            }
            $html .= '</head>';
            $html .= '<body>';

            echo $html;
        } else if ($type = 'bottom') {
            $html = '';
            if (isset($jsList['footer'])) {
                foreach ($jsList['footer'] as $jsFile) {
                    $html .= $jsFile;
                }
            }
            $html .= '</body>';
            $html .= '</html>';
            echo $html;
        }
    }

    public function newmodal($modaid, $modalheader = null, $modalbody, $modalfooter = null) {
        $html = '<div class="modal fade" id="' . $modaid . '" tabindex="-1" role="dialog" aria-labelledby="' . $modaid . 'Label">';
        $html .= '<div class="modal-dialog" style="width:50%" role="document">';
        $html .= '<div class="modal-content">';
        if ($modalheader) {
            $html .= '<div class="modal-header">';
            $html .= '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
            $html .= '<h4 class="modal-title" id="' . $modaid . 'Label">' . $modalheader . '</h4>';
            $html .= '</div>';
        }
        $html .= '<div class="modal-body">';
        echo $html;
        include $modalbody;
        $html = '';
        if ($modalfooter) {
            $html .= '<div class="modal-footer">';
            $html .= '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
            $html .= '<button type="button" class="btn btn-primary">Save changes</button>';
            $html .= '</div>';
        }
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        echo $html;
    }

}
?>