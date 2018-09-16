<?php

namespace Mini\Libs;

class Helper {
    static public function p($obj) {
        echo "<pre>";
        print_r($obj);
        echo "</pre>";
    }

    static public function startsWith($haystack, $needle) {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }

    static public function endsWith($haystack, $needle) {
        $length = strlen($needle);

        return $length === 0 ||
            (substr($haystack, -$length) === $needle);
    }

    static public function string_contains($haystack, $needle) {
        if (strpos($haystack, $needle) !== false) {
            return true;
        }
        return false;
    }

    static public function hide_email($email) {
        $output = "";
        for ($i = 0; $i < strlen($email); $i++) {
            $output .= '&#' . ord($email[$i]) . ';';
        }
        return $output;
    }

    static public function curl($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    static public function remove_slashes_at_start_and_end($string) {
        if (self::startsWith($string, "/")) {
            $string = substr($string, 1);
        }
        if (self::endsWith($string, "/")) {
            $string = substr($string, 0, -1);
        }
        return $string;
    }

    static public function minify_html_output($buffer) {
        $re = '%# Collapse ws everywhere but in blacklisted elements.
        (?>             # Match all whitespans other than single space.
          [^\S ]\s*     # Either one [\t\r\n\f\v] and zero or more ws,
        | \s{2,}        # or two or more consecutive-any-whitespace.
        ) # Note: The remaining regex consumes no text at all...
        (?=             # Ensure we are not in a blacklist tag.
          (?:           # Begin (unnecessary) group.
            (?:         # Zero or more of...
              [^<]++    # Either one or more non-"<"
            | <         # or a < starting a non-blacklist tag.
              (?!/?(?:textarea|pre)\b)
            )*+         # (This could be "unroll-the-loop"ified.)
          )             # End (unnecessary) group.
          (?:           # Begin alternation group.
            <           # Either a blacklist start tag.
            (?>textarea|pre)\b
          | \z          # or end of file.
          )             # End alternation group.
        )  # If we made it here, we are not in a blacklist tag.
        %ix';
        $buffer = preg_replace($re, " ", $buffer);
        return $buffer;
    }

    static public function console_log($obj) {
        echo "<script>console.log(" . print_r($obj) . "); </script>";
    }

    static public function responsive_image($array) {
        /*Array is like:
        array(
            [0] => {
                        src: "",
                        attribute: "min-width",
                        value: 500px
                    }
            [1] => {                    //last element is default and has alt-value
                        src: "",
                        alt: ""
                    }
        )
        */
        ?>
        <picture>
            <?php foreach ($array as $key => $img) {
                if ($key + 1 != sizeof($array)) { ?>
                    <source srcset="<?php echo $img->src; ?>"
                            media="(<?php echo $img->attribute; ?>: <?php echo $img->value; ?>)">
                <?php } else {
                    if (!isset($img->alt)) {
                        $img->alt = "";
                    }
                    if (!isset($img->class)) {
                        $img->class = "img-responsive";
                    }
                    ?>
                    <img src="<?php echo $img->src; ?>" alt="<?php echo $img->alt; ?>"
                         class="<?php echo $img->class; ?>">
                <?php }
            } ?>
        </picture>
        <?php
    }

    public static function log($type, $data = "") {
        switch ($type) {
            case "404":
                $filename = "404.txt";

                $content = new \stdClass();
                $content->url = $_SERVER['REQUEST_URI'];
                if (isset($_SERVER['HTTP_REFERER'])) {
                    $content->referrer = $_SERVER['HTTP_REFERER'];
                }
                $content->date = date('Y-m-d H:i:s');

                if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                    $content->ip = $_SERVER['HTTP_CLIENT_IP'];
                } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                    $content->ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                } else {
                    $content->ip = $_SERVER['REMOTE_ADDR'];
                }
                $content = json_encode($content);

                break;
        }

        $path = ROOT . "logs/" . $filename;
        $logdatei = fopen($path, "a");
        fputs($logdatei, $content . "\n");
        fclose($logdatei);
    }
}
