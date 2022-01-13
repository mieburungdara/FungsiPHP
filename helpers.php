<?php

if (!function_exists('debugVar'))
{
    /**
     * Print value of a variable in <pre> tag
     */
    function debugVar($var)
    {
        echo '<pre>';
        print_r($var);
        echo '</pre>';
    }
}
if (!function_exists('is_image_type'))
{
    /**
     * check if a type(string) is image type
     * @param  string  $type   MIME type string
     * @param  boolean $strict set to true if checking specifically one type of image.
     * @return boolean         if MIME type is image
     */
    function is_image_type($type, $strict = true)
    {
        if ($strict)
        {
            $allowed = array(
                'image/gif',
                'image/jpeg',
                'image/pjpeg',
                'image/png',
                'image/svg+xml',
                'image/bmp',
            );
            return in_array($type, $allowed);
        }
        else
        {
            return strstr($type, 'image') != -1;
        }
    }
}
if (!function_exists('add_days_to_ts'))
{
    /**
     * add X days to a timestamp
     * @param integer $days number of days to add
     * @param integer $ts   original timestamp
     * @return integer      result timestamp
     */
    function add_days_to_ts($days, $ts)
    {
        $sign = '';
        if ($days > 0)
        {
            $sign = '+';
        }

        return strtotime($sign . $days . ' days', $ts);
    }
}

if (!function_exists('days_between_timestamps'))
{
    /**
     * get days difference between 2 timestamps
     * @param  integer $ts1 timestamp to compare
     * @param  integer $ts2 timestamp to compare
     * @return integer      days between $ts1 and $ts2
     */
    function days_between_timestamps($ts1, $ts2)
    {
        $days = ceil(($ts1 - $ts2) / 60 / 60 / 24);

        //format -0 to 0
        if ($days < 1 && $days > -1)
        {
            $days = 0;
        }
        return $days;
    }
}

if (!function_exists('turn_on_error_reporting'))
{
    /**
     * turn on all error reporting
     */
    function turn_on_error_reporting()
    {
        ini_set('display_startup_errors', 1);
        ini_set('display_errors', 1);
        error_reporting(-1);
    }
}

if (!function_exists('downloadFile'))
{
    /**
     * Download file from a $url and store into a $path on server
     */
    function downloadFile($url, $path)
    {
        $newfname = $path;
        $file = fopen($url, "rb");
        if ($file)
        {
            $newf = fopen($newfname, "wb");

            if ($newf)
            {
                while (!feof($file))
                {
                    fwrite($newf, fread($file, 1024 * 8), 1024 * 8);
                }
            }
        }

        if ($file)
        {
            fclose($file);
        }

        if ($newf)
        {
            fclose($newf);
        }
    }
}

if (!function_exists('file_exists_url'))
{
    /**
     * check if remote file exists using url
     * @param  string $url  url to file
     * @return boolean      false if not found.
     */
    function file_exists_url($url)
    {
        $file = $url;
        $file_headers = @get_headers($file);
        if ($file_headers[0] == 'HTTP/1.1 404 Not Found')
        {
            return $exists = false;
        }
        else
        {
            return $exists = true;
        }
    }
}

if (!function_exists('image_to_data'))
{
    function image_to_data($image)
    {
        $type = pathinfo($image, PATHINFO_EXTENSION);
        $data = file_get_contents($image);
        return 'data:image/' . $type . ';base64,' . base64_encode($data);
    }
}
function resize_image_max($image, $max_width, $max_height)
{
    $w = imagesx($image); //current width
    $h = imagesy($image); //current height
    if ((!$w) || (!$h))
    {
        $GLOBALS['errors'][] = 'Image could not be resized because it was not a valid image.';
        return false;
    }

    if (($w <= $max_width) && ($h <= $max_height))
    {
        return $image;
    } //no resizing needed

    //try max width first...
    $ratio = $max_width / $w;
    $new_w = $max_width;
    $new_h = $h * $ratio;

    //if that didn't work
    if ($new_h > $max_height)
    {
        $ratio = $max_height / $h;
        $new_h = $max_height;
        $new_w = $w * $ratio;
    }

    $new_image = imagecreatetruecolor($new_w, $new_h);
    imagecopyresampled($new_image, $image, 0, 0, 0, 0, $new_w, $new_h, $w, $h);
    return $new_image;
}

if (!function_exists('tgbot_curl'))
{
    function tgbot_curl($method, $token, $param)
    {
        $ch = curl_init("https://api.telegram.org/bot" . $token . $method);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, ($param));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}

if (!function_exists('is_mobile'))
{
    function is_mobile()
    {
        if (isset($_SERVER['HTTP_USER_AGENT']))
        {
            // echo $_SERVER['HTTP_USER_AGENT'];
            $is_mobiles = is_numeric(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'mobile'));
            return $is_mobiles ? true : false;
        }
    }
}
if (!function_exists('tutup'))
{
    function tutup($text)
    {
        $key = '123Dor';
        $method = 'blowfish';
        // $method = 'bf-ofb';
        $encrypted_message = openssl_encrypt($text, $method, $key);
        $encrypted_message = bin2hex($encrypted_message);
        return $encrypted_message;
    }
}
if (!function_exists('buka'))
{
    function buka($text)
    {
        $key = '123Dor';
        $method = 'blowfish';
        // $method = 'bf-ofb';
        $text = hex2bin($text);
        $encrypted_message = openssl_decrypt($text, $method, $key);
        return $encrypted_message;
    }
}
if (!function_exists('pecah'))
{
    function pecah($text, $key)
    {
        // $key = '123Dor';
        $method = 'blowfish';
        // $method = 'bf-ofb';
        $text = hex2bin($text);
        $encrypted_message = openssl_decrypt($text, $method, $key);
        return $encrypted_message;
    }
}
if (!function_exists('gabung'))
{
    function gabung($text, $key)
    {
        // $key = '123Dor';
        $method = 'blowfish';
        // $method = 'bf-ofb';
        $encrypted_message = openssl_encrypt($text, $method, $key);
        $encrypted_message = bin2hex($encrypted_message);
        return $encrypted_message;
    }
}

if (!function_exists('formatBytes'))
{
    function formatBytes($size, $precision = 1)
    {
        $base = log($size, 1024);
        $suffixes = array('', 'KB', 'MB', 'GB', 'TB');
        return round(pow(1024, $base - floor($base)), $precision) - 0.1 . ' ' . $suffixes[floor($base)];
    }
}
if (!function_exists('humanize_second'))
{
    function humanize_second($seconds_time)
    {
        $hours = floor($seconds_time / 3600);
        $minutes = floor(($seconds_time - $hours * 3600) / 60);
        $seconds = floor($seconds_time - ($hours * 3600) - ($minutes * 60));

        if ($minutes < 10)
        {
            $minutes = '0' . $minutes;
        }
        if ($seconds < 10)
        {
            $seconds = '0' . $seconds;
        }
        if ($hours != 00 || $hours != 0)
        {
            return $hours . ':' . $minutes . ':' . $seconds;
        }
        else
        {
            return $minutes . ':' . $seconds;
        }
    }
}
if (!function_exists('crypto_rand_secure'))
{
    function crypto_rand_secure($min, $max)
    {
        $range = $max - $min;
        if ($range < 1)
        {
            return $min;
        }
        $log = ceil(log($range, 2));
        $bytes = (int)($log / 8) + 1;
        $bits = (int)$log + 1;
        $filter = (int)(1 << $bits) - 1;
        do
        {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd& $filter;
        } while ($rnd > $range);
        return $min + $rnd;
    }
}

if (!function_exists('randomize'))
{
    function randomize($length = 7)
    {
        $token = '';
        $codeAlphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $codeAlphabet .= 'abcdefghijklmnopqrstuvwxyz';
        $codeAlphabet .= '0123456789';
        $max = strlen($codeAlphabet);
        for ($i = 0; $i < $length; $i++)
        {
            $token .= $codeAlphabet[crypto_rand_secure(0, $max - 1)];
        }
        return $token;
    }
}
if (!function_exists('load_js'))
{
    function load_js()
    {
        $files = glob("{assets/*.js}", GLOB_BRACE);
        for ($i = 0; $i < count($files); $i++)
        {
            echo '<script type="text/javascript">';
            include $files[$i];
            echo '</script>';
        }
    }
}

if (!function_exists('load_js_folder'))
{
    function load_js_folder($path)
    {
        // $path = "{assets/*.js}"
        $files = glob($path, GLOB_BRACE);
        for ($i = 0; $i < count($files); $i++)
        {
            echo '<script type="text/javascript">';
            include $files[$i];
            echo '</script>';
        }
    }
}

if (!function_exists('rupiah'))
{
    function rupiah($angka)
    {
        $hasil_rupiah = "Rp " . number_format($angka, 2, ',', '.');
        return $hasil_rupiah;
    }
}
if (!function_exists('getReferer'))
{
    /**
     * Return referer page.
     *
     * @return string|false
     */
    function getReferer()
    {
        return isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : false;
    }
}

if (!function_exists('pre'))
{
    /**
     * print_r's Variable in <pre> tags.
     *
     * @param mixed $variable variable to print_r
     *
     * @return void
     */
    function pre($variable)
    {
        echo '<pre>';
        print_r($variable);
        echo '</pre>';
    }
}

if (!function_exists('text_ordinal'))
{
    /**
     *  Takes a number and adds “th, st, nd, rd, th” after it.
     *
     * @param int $cardinal Number to add termination
     *
     * @return string
     */
    function text_ordinal($cardinal)
    {
        $test_c = abs($cardinal) % 10;
        $ext = ((abs($cardinal) % 100 < 21 && abs($cardinal) % 100 > 4)
            ? 'th'
            : (($test_c < 4)
                ? ($test_c < 3)
                ? ($test_c < 2)
                ? ($test_c < 1)
                ? 'th'
                : 'st'
                : 'nd'
                : 'rd'
                : 'th'));

        return $cardinal . $ext;
    }
}

if (!function_exists('compressPage'))
{
    /**
     * Captures output via ob_get_contents(), tries to enable gzip, removes whitespace from captured output and echos back.
     */
    function compressPage()
    {
        register_shutdown_function(function () {
            $buffer = preg_replace(['/\>[^\S ]+/s', '/[^\S ]+\</s', '/(\s)+/s'], ['>', '<', '\\1'], ob_get_contents());
            ob_end_clean();
            if (!((ini_get('zlib.output_compression') == 'On' ||
            ini_get('zlib.output_compression_level') > 0) ||
            ini_get('output_handler') == 'ob_gzhandler') &&
            !empty($_SERVER['HTTP_ACCEPT_ENCODING']) &&
            extension_loaded('zlib') &&
            strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== false
            )
            {
                ob_start('ob_gzhandler');
            }
            echo $buffer;
        });
    }
}

if (!function_exists('debugx'))
{
    /**
     * Dump information about a variable.
     *
     * @param mixed $variable Variable to debug
     *
     * @return void
     */
    function debugx($variable)
    {
        ob_start();
        var_dump($variable);
        $output = ob_get_clean();
        $maps = ['string' => "/(string\((?P<length>\d+)\)) (?P<value>\"(?<!\\\).*\")/i", 'array' => "/\[\"(?P<key>.+)\"(?:\:\"(?P<class>[a-z0-9_\\\]+)\")?(?:\:(?P<scope>public|protected|private))?\]=>/Ui", 'countable' => "/(?P<type>array|int|string)\((?P<count>\d+)\)/", 'resource' => "/resource\((?P<count>\d+)\) of type \((?P<class>[a-z0-9_\\\]+)\)/", 'bool' => "/bool\((?P<value>true|false)\)/", 'float' => "/float\((?P<value>[0-9\.]+)\)/", 'object' => "/object\((?P<class>\S+)\)\#(?P<id>\d+) \((?P<count>\d+)\)/i"];
        foreach ($maps as $function => $pattern)
        {
            $output = preg_replace_callback($pattern, function ($matches) use ($function) {
                switch ($function)
                {
                    case 'string':
                        $matches['value'] = htmlspecialchars($matches['value']);

                        return '<span style="color: #0000FF;">string</span>(<span style="color: #1287DB;">' . $matches['length'] . ')</span> <span style="color: #6B6E6E;">' . $matches['value'] . '</span>';

                    case 'array':
                        $key = '<span style="color: #008000;">"' . $matches['key'] . '"</span>';
                        $class = '';
                        $scope = '';
                        if (isset($matches['class']) && !empty($matches['class']))
                        {
                            $class = ':<span style="color: #4D5D94;">"' . $matches['class'] . '"</span>';
                        }
                        if (isset($matches['scope']) && !empty($matches['scope']))
                        {
                            $scope = ':<span style="color: #666666;">' . $matches['scope'] . '</span>';
                        }

                        return '[' . $key . $class . $scope . ']=>';

                    case 'countable':
                        $type = '<span style="color: #0000FF;">' . $matches['type'] . '</span>';
                        $count = '(<span style="color: #1287DB;">' . $matches['count'] . '</span>)';

                        return $type . $count;

                    case 'bool':
                        return '<span style="color: #0000FF;">bool</span>(<span style="color: #0000FF;">' . $matches['value'] . '</span>)';

                    case 'float':
                        return '<span style="color: #0000FF;">float</span>(<span style="color: #1287DB;">' . $matches['value'] . '</span>)';

                    case 'resource':
                        return '<span style="color: #0000FF;">resource</span>(<span style="color: #1287DB;">' . $matches['count'] . '</span>) of type (<span style="color: #4D5D94;">' . $matches['class'] . '</span>)';

                    case 'object':
                        return '<span style="color: #0000FF;">object</span>(<span style="color: #4D5D94;">' . $matches['class'] . '</span>)#' . $matches['id'] . ' (<span style="color: #1287DB;">' . $matches['count'] . '</span>)';

                }
            }, $output);
        }
        $header = '';
        list($debugfile) = debug_backtrace();

        if (!empty($debugfile['file']))
        {
            $header = '<h4 style="border-bottom:1px solid #bbb;font-weight:bold;margin:0 0 10px 0;padding:3px 0 10px 0">' . $debugfile['file'] . '</h4>';
        }

        echo '<pre style="background-color: #CDDCF4;border: 1px solid #bbb;border-radius: 4px;-moz-border-radius:4px;-webkit-border-radius\:4px;font-size:12px;line-height:1.4em;margin:30px;padding:7px">' . $header . $output . '</pre>';
    }
}

if (!function_exists('expandShortUrl'))
{
    /**
     * Get information on a short URL. Find out where it forwards.
     *
     * @param string $shortURL shortened URL
     *
     * @return mixed full url or false
     */
    function expandShortUrl($shortURL)
    {
        if (empty($shortURL))
        {
            return false;
        }

        $headers = get_headers($shortURL, 1);
        if (isset($headers['Location']))
        {
            return $headers['Location'];
        }

        $data = curl($shortURL);

        preg_match_all('/<[\s]*meta[\s]*http-equiv="?' . '([^>"]*)"?[\s]*' . 'content="?([^>"]*)"?[\s]*[\/]?[\s]*>/si', $data, $match);

        if (isset($match) && is_array($match) && count($match) == 3)
        {
            $originals = $match[0];
            $names = $match[1];
            $values = $match[2];
            if ((isset($originals) && isset($names) && isset($values)) && count($originals) == count($names) && count($names) == count($values))
            {
                $metaTags = [];
                for ($i = 0, $limit = count($names); $i < $limit; $i++)
                {
                    $metaTags[$names[$i]] = ['html' => htmlentities($originals[$i]), 'value' => $values[$i]];
                }
            }
        }

        if (isset($metaTags['refresh']['value']) && !empty($metaTags['refresh']['value']))
        {
            $returnData = explode('=', $metaTags['refresh']['value']);
            if (isset($returnData[1]) && !empty($returnData[1]))
            {
                return $returnData[1];
            }
        }

        return false;
    }
}

if (!function_exists('curl'))
{
    /**
     * Make a Curl call.
     *
     * @param string     $url        URL to curl
     * @param string     $method     GET or POST, Default GET
     * @param mixed      $data       Data to post, Default false
     * @param mixed      $headers    Additional headers, example: array ("Accept: application/json")
     * @param bool       $returnInfo Whether or not to retrieve curl_getinfo()
     * @param bool|array $auth       Basic authentication params. If array with keys 'username' and 'password' specified, CURLOPT_USERPWD cURL option will be set
     *
     * @return array|string if $returnInfo is set to True, array is returned with two keys, contents (will contain response) and info (information regarding a specific transfer), otherwise response content is returned
     */
    function curl($url, $method = 'GET', $data = false, $headers = false, $returnInfo = false, $auth = false)
    {
        $ch = curl_init();
        $info = null;
        if (strtoupper($method) == 'POST')
        {
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            if ($data !== false)
            {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            }
        }
        else
        {
            if ($data !== false)
            {
                if (is_array($data))
                {
                    $dataTokens = [];
                    foreach ($data as $key => $value)
                    {
                        array_push($dataTokens, urlencode($key) . '=' . urlencode($value));
                    }
                    $data = implode('&', $dataTokens);
                }
                curl_setopt($ch, CURLOPT_URL, $url . '?' . $data);
            }
            else
            {
                curl_setopt($ch, CURLOPT_URL, $url);
            }
        }

        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

        if ($headers !== false)
        {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }

        if ($auth !== false && strlen($auth['username']) > 0 && strlen($auth['password']) > 0)
        {
            curl_setopt($ch, CURLOPT_USERPWD, $auth['username'] . ':' . $auth['password']);
        }

        $contents = curl_exec($ch);
        if ($returnInfo)
        {
            $info = curl_getinfo($ch);
        }

        curl_close($ch);

        if ($returnInfo)
        {
            return ['contents' => $contents, 'info' => $info];
        }

        return $contents;
    }
}
if (!function_exists('minutesToText'))
{

    /**
     * Convert minutes to real time.
     *
     * @param int  $minutes       time in minutes
     * @param bool $returnAsWords return time in words (example one hour and 20 minutes) if value is True or (1 hour and 20 minutes) if value is false, default false
     *
     * @return string
     */
    function minutesToText($minutes, $returnAsWords = false)
    {
        return secondsToText($minutes * 60, $returnAsWords);
    }
}

if (!function_exists('secondsToText'))
{ /**
  * Convert seconds to real time.
  *
  * @param int  $seconds       time in seconds
  * @param bool $returnAsWords return time in words (example one minute and 20 seconds) if value is True or (1 minute and 20 seconds) if value is false, default false
  *
  * @return string
  */
    function secondsToText($seconds, $returnAsWords = false)
    {
        $periods = [
            'year' => 3.156e+7,
            'month' => 2.63e+6,
            'week' => 604800,
            'day' => 86400,
            'hour' => 3600,
            'minute' => 60,
            'second' => 1,
        ];

        $parts = [];
        foreach ($periods as $name => $dur)
        {
            $div = floor($seconds / $dur);

            if ($div == 0)
            {
                continue;
            }

            if ($div == 1)
            {
                $parts[] = ($returnAsWords ? numberToWord($div) : $div) . ' ' . $name;
            }
            else
            {
                $parts[] = ($returnAsWords ? numberToWord($div) : $div) . ' ' . $name . 's';
            }

            $seconds %= $dur;
        }

        $last = array_pop($parts);

        if (empty($parts))
        {
            return $last;
        }

        return implode(', ', $parts) . ' and ' . $last;
    }
}
if (!function_exists('numberToWord'))
{
    /**
     * Convert number to word representation.
     *
     * @param int $number number to convert to word
     *
     * @throws \Exception
     *
     * @return string converted string
     */
    function numberToWord($number)
    {
        $hyphen = '-';
        $conjunction = ' and ';
        $separator = ', ';
        $negative = 'negative ';
        $decimal = ' point ';
        $fraction = null;
        $dictionary = [
            0 => 'zero',
            1 => 'one',
            2 => 'two',
            3 => 'three',
            4 => 'four',
            5 => 'five',
            6 => 'six',
            7 => 'seven',
            8 => 'eight',
            9 => 'nine',
            10 => 'ten',
            11 => 'eleven',
            12 => 'twelve',
            13 => 'thirteen',
            14 => 'fourteen',
            15 => 'fifteen',
            16 => 'sixteen',
            17 => 'seventeen',
            18 => 'eighteen',
            19 => 'nineteen',
            20 => 'twenty',
            30 => 'thirty',
            40 => 'fourty',
            50 => 'fifty',
            60 => 'sixty',
            70 => 'seventy',
            80 => 'eighty',
            90 => 'ninety',
            100 => 'hundred',
            1000 => 'thousand',
            1000000 => 'million',
            1000000000 => 'billion',
            1000000000000 => 'trillion',
            1000000000000000 => 'quadrillion',
            1000000000000000000 => 'quintillion',
        ];

        if (!is_numeric($number))
        {
            throw new \Exception('NaN');
        }

        if (($number >= 0 && (int)$number < 0) || (int)$number < 0 - PHP_INT_MAX)
        {
            throw new \Exception('numberToWord only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX);
        }

        if ($number < 0)
        {
            return $negative . numberToWord(abs($number));
        }

        if (strpos($number, '.') !== false)
        {
            list($number, $fraction) = explode('.', $number);
        }

        switch (true)
        {
            case $number < 21:
                $string = $dictionary[$number];
                break;

            case $number < 100:
                $tens = ((int)($number / 10)) * 10;
                $units = $number % 10;
                $string = $dictionary[$tens];

                if ($units)
                {
                    $string .= $hyphen . $dictionary[$units];
                }

                break;

            case $number < 1000:
                $hundreds = $number / 100;
                $remainder = $number % 100;
                $string = $dictionary[$hundreds] . ' ' . $dictionary[100];

                if ($remainder)
                {
                    $string .= $conjunction . numberToWord($remainder);
                }

                break;

            default:
                $baseUnit = pow(1000, floor(log($number, 1000)));
                $numBaseUnits = (int)($number / $baseUnit);
                $remainder = $number % $baseUnit;
                $string = numberToWord($numBaseUnits) . ' ' . $dictionary[$baseUnit];

                if ($remainder)
                {
                    $string .= $remainder < 100 ? $conjunction : $separator;
                    $string .= numberToWord($remainder);
                }

                break;
        }

        if (null !== $fraction && is_numeric($fraction))
        {
            $string .= $decimal;
            $words = [];

            foreach (str_split((string)$fraction) as $number)
            {
                $words[] = $dictionary[$number];
            }

            $string .= implode(' ', $words);
        }

        return $string;
    }
}

if (!function_exists('getBrowser'))
{
    /**
     * Get user browser.
     *
     * @return string
     */
    function getBrowser()
    {
        $u_agent = $_SERVER['HTTP_USER_AGENT'];
        $browserName = $ub = $platform = 'Unknown';
        if (preg_match('/linux/i', $u_agent))
        {
            $platform = 'Linux';
        }
        elseif (preg_match('/macintosh|mac os x/i', $u_agent))
        {
            $platform = 'Mac OS';
        }
        elseif (preg_match('/windows|win32/i', $u_agent))
        {
            $platform = 'Windows';
        }

        if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent))
        {
            $browserName = 'Internet Explorer';
            $ub = 'MSIE';
        }
        elseif (preg_match('/Firefox/i', $u_agent))
        {
            $browserName = 'Mozilla Firefox';
            $ub = 'Firefox';
        }
        elseif (preg_match('/Chrome/i', $u_agent))
        {
            $browserName = 'Google Chrome';
            $ub = 'Chrome';
        }
        elseif (preg_match('/Safari/i', $u_agent))
        {
            $browserName = 'Apple Safari';
            $ub = 'Safari';
        }
        elseif (preg_match('/Opera/i', $u_agent))
        {
            $browserName = 'Opera';
            $ub = 'Opera';
        }
        elseif (preg_match('/Netscape/i', $u_agent))
        {
            $browserName = 'Netscape';
            $ub = 'Netscape';
        }

        $known = ['Version', $ub, 'other'];
        $pattern = '#(?<browser>' . implode('|', $known) . ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
        preg_match_all($pattern, $u_agent, $matches);
        $i = count($matches['browser']);
        $version = $matches['version'][0];
        if ($i != 1 && strripos($u_agent, 'Version') >= strripos($u_agent, $ub))
        {
            $version = $matches['version'][1];
        }
        if ($version == null || $version == '')
        {
            $version = '?';
        }

        return implode(', ', [$browserName, 'Version: ' . $version, $platform]);
    }
}
if (!function_exists('isMobile'))
{
    /**
     * Detect if user is on mobile device.
     * @return bool
     * @todo Put everything to an array & then implode it?
     */
    function isMobile()
    {
        if (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop'
        . '|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i'
        . '|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)'
        . '|vodafone|wap|windows ce|xda|xiino/i', $_SERVER['HTTP_USER_AGENT'])
        || preg_match(
        '/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)'
        . '|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi'
        . '(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co'
        . '(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)'
        . '|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|'
        . 'haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|'
        . 'i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|'
        . 'kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|'
        . 'm1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|'
        . 't(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)'
        . '\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|'
        . 'phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|'
        . 'r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|'
        . 'mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy'
        . '(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)'
        . '|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|'
        . '70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',
        substr($_SERVER['HTTP_USER_AGENT'], 0, 4)
        ))
        {
            return true;
        }
        return false;
    }
}

if (!function_exists('getClientIP'))
{ /**
  * Returns the IP address of the client.
  * @param bool $headerContainingIPAddress Default false
  * @return string
  */
    function getClientIP($headerContainingIPAddress = null)
    {
        if (!empty($headerContainingIPAddress))
        {
            return isset($_SERVER[$headerContainingIPAddress]) ? trim($_SERVER[$headerContainingIPAddress]) : false;
        }

        $knowIPkeys = [
            'HTTP_CLIENT_IP',
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_FORWARDED',
            'HTTP_X_CLUSTER_CLIENT_IP',
            'HTTP_FORWARDED_FOR',
            'HTTP_FORWARDED',
            'REMOTE_ADDR',
        ];

        foreach ($knowIPkeys as $key)
        {
            if (array_key_exists($key, $_SERVER) !== true)
            {
                continue;
            }
            foreach (explode(',', $_SERVER[$key]) as $ip)
            {
                $ip = trim($ip);
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false)
                {
                    return $ip;
                }
            }
        }

        return false;
    }
}

if (!function_exists('isAjax'))
{
    /**
     * Determine if current page request type is ajax.
     * @return bool
     */
    function isAjax()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])
        && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
        {
            return true;
        }

        return false;
    }
}

if (!function_exists('generateServerSpecificHash'))
{
    /**
     * Generate Server Specific hash.
     * @method generateServerSpecificHash
     * @return string
     */
    function generateServerSpecificHash()
    {
        return (isset($_SERVER['SERVER_NAME']) && !empty($_SERVER['SERVER_NAME']))
        ? md5($_SERVER['SERVER_NAME'])
        : md5(pathinfo(__FILE__, PATHINFO_FILENAME));
    }
}

if (!function_exists('rgb2hex'))
{

    /**
     * Takes RGB color value and converts to a HEX color code
     * Could be used as Recipe::rgb2hex("rgb(0,0,0)") or Recipe::rgb2hex(0,0,0).
     * @param mixed $r Full rgb,rgba string or red color segment
     * @param mixed $g null or green color segment
     * @param mixed $b null or blue color segment
     * @return string hex color value
     */
    function rgb2hex($r, $g = null, $b = null)
    {
        if (strpos($r, 'rgb') !== false || strpos($r, 'rgba') !== false)
        {
            if (preg_match_all('/\(([^\)]*)\)/', $r, $matches) && isset($matches[1][0]))
            {
                list($r, $g, $b) = explode(',', $matches[1][0]);
            }
            else
            {
                return false;
            }
        }

        $result = '';
        foreach ([$r, $g, $b] as $c)
        {
            $hex = base_convert($c, 10, 16);
            $result .= ($c < 16) ? ('0' . $hex) : $hex;
        }

        return '#' . $result;
    }
}

if (!function_exists('hex2rgb'))
{
    /**
     * Takes HEX color code value and converts to a RGB value.
     * @param string $color Color hex value, example: #000000, #000 or 000000, 000
     * @return string color rbd value
     */
    function hex2rgb($color)
    {
        $color = str_replace('#', '', $color);

        $hex = strlen($color) == 3
        ? [$color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2]]
        : [$color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5]];

        list($r, $g, $b) = $hex;

        return sprintf(
            'rgb(%s, %s, %s)',
            hexdec($r),
            hexdec($g),
            hexdec($b)
        );
    }
}
if (!function_exists('objectToArray'))
{
    /**
     * Convert object to the array.
     * @param object $object PHP object
     * @throws \Exception
     * @return array
     */
    function objectToArray($object)
    {
        if (is_object($object))
        {
            return json_decode(json_encode($object), true);
        }
        else
        {
            throw new \Exception('Not an object');
        }
    }
}
if (!function_exists('arrayToObject'))
{
    /**
     * Convert array to the object.
     * @param array $array PHP array
     * @throws \Exception
     * @return object
     */
    function arrayToObject(array $array = [])
    {
        if (!is_array($array))
        {
            throw new \Exception('Not an array');
        }

        $object = new \stdClass();
        if (is_array($array) && count($array) > 0)
        {
            foreach ($array as $name => $value)
            {
                if (is_array($value))
                {
                    $object->{ $name} = arrayToObject($value);
                }
                else
                {
                    $object->{ $name} = $value;
                }
            }
        }
        else
        {
            throw new \Exception('Not an array');
        }

        return $object;
    }
}

if (!function_exists('upload_to_tg'))
{
    function upload_to_tg($files)
    {
        $TG = 'https://telegra.ph';
        $links = [];
        $curl = curl_init();
        $options = [
            CURLOPT_URL => $TG . '/upload/',
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POST => 1,
            CURLOPT_HTTPHEADER => [
                'Content-Type: multipart/form-data',
                'Accept: application/json, text/javascript, */*; q=0.01',
                'X-Requested-With' => 'XMLHttpRequest',
                'Referer' => $TG,
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.150 Safari/537.36',
            ],
        ];
        foreach ((array)$files as $file)
        {
            $options[CURLOPT_POSTFIELDS] = [
                'file' => new \CurlFile($file),
            ];
            @curl_setopt_array($curl, $options);
            if (!$result = @curl_exec($curl))
            {
                return false;
            }
            $response = json_decode($result, true);
            if (isset($response['error']))
            {
                return false;
            }
            $links[] = $TG . $response[0]['src'] ?? null;
        }
        curl_close($curl);
        return $links;
    }
}

if (!function_exists('convertSpecialCharToNormalChar'))
{
    function convertSpecialCharToNormalChar($text)
    {
        $target = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '!', '?', '.', ',', '"', "'"];
        $specialList = [
            'serifBold' => ['𝐚', '𝐛', '𝐜', '𝐝', '𝐞', '𝐟', '𝐠', '𝐡', '𝐢', '𝐣', '𝐤', '𝐥', '𝐦', '𝐧', '𝐨', '𝐩', '𝐪', '𝐫', '𝐬', '𝐭', '𝐮', '𝐯', '𝐰', '𝐱', '𝐲', '𝐳', '𝐀', '𝐁', '𝐂', '𝐃', '𝐄', '𝐅', '𝐆', '𝐇', '𝐈', '𝐉', '𝐊', '𝐋', '𝐌', '𝐍', '𝐎', '𝐏', '𝐐', '𝐑', '𝐒', '𝐓', '𝐔', '𝐕', '𝐖', '𝐗', '𝐘', '𝐙', '𝟎', '𝟏', '𝟐', '𝟑', '𝟒', '𝟓', '𝟔', '𝟕', '𝟖', '𝟗', '❗', '❓', '.', ',', '"', "'"],
            'serifItalic' => ['𝑎', '𝑏', '𝑐', '𝑑', '𝑒', '𝑓', '𝑔', 'ℎ', '𝑖', '𝑗', '𝑘', '𝑙', '𝑚', '𝑛', '𝑜', '𝑝', '𝑞', '𝑟', '𝑠', '𝑡', '𝑢', '𝑣', '𝑤', '𝑥', '𝑦', '𝑧', '𝐴', '𝐵', '𝐶', '𝐷', '𝐸', '𝐹', '𝐺', '𝐻', '𝐼', '𝐽', '𝐾', '𝐿', '𝑀', '𝑁', '𝑂', '𝑃', '𝑄', '𝑅', '𝑆', '𝑇', '𝑈', '𝑉', '𝑊', '𝑋', '𝑌', '𝑍', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '!', '?', '.', ',', '"', "'"],
            'serifBoldItalic' => ['𝒂', '𝒃', '𝒄', '𝒅', '𝒆', '𝒇', '𝒈', '𝒉', '𝒊', '𝒋', '𝒌', '𝒍', '𝒎', '𝒏', '𝒐', '𝒑', '𝒒', '𝒓', '𝒔', '𝒕', '𝒖', '𝒗', '𝒘', '𝒙', '𝒚', '𝒛', '𝑨', '𝑩', '𝑪', '𝑫', '𝑬', '𝑭', '𝑮', '𝑯', '𝑰', '𝑱', '𝑲', '𝑳', '𝑴', '𝑵', '𝑶', '𝑷', '𝑸', '𝑹', '𝑺', '𝑻', '𝑼', '𝑽', '𝑾', '𝑿', '𝒀', '𝒁', '𝟎', '𝟏', '𝟐', '𝟑', '𝟒', '𝟓', '𝟔', '𝟕', '𝟖', '𝟗', '❗', '❓', '.', ',', '"', "'"],
            'sans' => ['𝖺', '𝖻', '𝖼', '𝖽', '𝖾', '𝖿', '𝗀', '𝗁', '𝗂', '𝗃', '𝗄', '𝗅', '𝗆', '𝗇', '𝗈', '𝗉', '𝗊', '𝗋', '𝗌', '𝗍', '𝗎', '𝗏', '𝗐', '𝗑', '𝗒', '𝗓', '𝖠', '𝖡', '𝖢', '𝖣', '𝖤', '𝖥', '𝖦', '𝖧', '𝖨', '𝖩', '𝖪', '𝖫', '𝖬', '𝖭', '𝖮', '𝖯', '𝖰', '𝖱', '𝖲', '𝖳', '𝖴', '𝖵', '𝖶', '𝖷', '𝖸', '𝖹', '𝟢', '𝟣', '𝟤', '𝟥', '𝟦', '𝟧', '𝟨', '𝟩', '𝟪', '𝟫', '!', '?', '.', ',', '"', "'"],
            'sansBold' => ['𝗮', '𝗯', '𝗰', '𝗱', '𝗲', '𝗳', '𝗴', '𝗵', '𝗶', '𝗷', '𝗸', '𝗹', '𝗺', '𝗻', '𝗼', '𝗽', '𝗾', '𝗿', '𝘀', '𝘁', '𝘂', '𝘃', '𝘄', '𝘅', '𝘆', '𝘇', '𝗔', '𝗕', '𝗖', '𝗗', '𝗘', '𝗙', '𝗚', '𝗛', '𝗜', '𝗝', '𝗞', '𝗟', '𝗠', '𝗡', '𝗢', '𝗣', '𝗤', '𝗥', '𝗦', '𝗧', '𝗨', '𝗩', '𝗪', '𝗫', '𝗬', '𝗭', '𝟬', '𝟭', '𝟮', '𝟯', '𝟰', '𝟱', '𝟲', '𝟳', '𝟴', '𝟵', '❗', '❓', '.', ',', '"', "'"],
            'sansItalic' => ['𝘢', '𝘣', '𝘤', '𝘥', '𝘦', '𝘧', '𝘨', '𝘩', '𝘪', '𝘫', '𝘬', '𝘭', '𝘮', '𝘯', '𝘰', '𝘱', '𝘲', '𝘳', '𝘴', '𝘵', '𝘶', '𝘷', '𝘸', '𝘹', '𝘺', '𝘻', '𝘈', '𝘉', '𝘊', '𝘋', '𝘌', '𝘍', '𝘎', '𝘏', '𝘐', '𝘑', '𝘒', '𝘓', '𝘔', '𝘕', '𝘖', '𝘗', '𝘘', '𝘙', '𝘚', '𝘛', '𝘜', '𝘝', '𝘞', '𝘟', '𝘠', '𝘡', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '!', '?', '.', ',', '"', "'"],
            'sansBoldItalic' => ['𝙖', '𝙗', '𝙘', '𝙙', '𝙚', '𝙛', '𝙜', '𝙝', '𝙞', '𝙟', '𝙠', '𝙡', '𝙢', '𝙣', '𝙤', '𝙥', '𝙦', '𝙧', '𝙨', '𝙩', '𝙪', '𝙫', '𝙬', '𝙭', '𝙮', '𝙯', '𝘼', '𝘽', '𝘾', '𝘿', '𝙀', '𝙁', '𝙂', '𝙃', '𝙄', '𝙅', '𝙆', '𝙇', '𝙈', '𝙉', '𝙊', '𝙋', '𝙌', '𝙍', '𝙎', '𝙏', '𝙐', '𝙑', '𝙒', '𝙓', '𝙔', '𝙕', '𝟎', '𝟏', '𝟐', '𝟑', '𝟒', '𝟓', '𝟔', '𝟕', '𝟖', '𝟗', '❗', '❓', '.', ',', '"', "'"],
            'script' => ['𝒶', '𝒷', '𝒸', '𝒹', 'ℯ', '𝒻', 'ℊ', '𝒽', '𝒾', '𝒿', '𝓀', '𝓁', '𝓂', '𝓃', 'ℴ', '𝓅', '𝓆', '𝓇', '𝓈', '𝓉', '𝓊', '𝓋', '𝓌', '𝓍', '𝓎', '𝓏', '𝒜', 'ℬ', '𝒞', '𝒟', 'ℰ', 'ℱ', '𝒢', 'ℋ', 'ℐ', '𝒥', '𝒦', 'ℒ', 'ℳ', '𝒩', '𝒪', '𝒫', '𝒬', 'ℛ', '𝒮', '𝒯', '𝒰', '𝒱', '𝒲', '𝒳', '𝒴', '𝒵', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '!', '?', '.', ',', '"', "'"],
            'scriptBold' => ['𝓪', '𝓫', '𝓬', '𝓭', '𝓮', '𝓯', '𝓰', '𝓱', '𝓲', '𝓳', '𝓴', '𝓵', '𝓶', '𝓷', '𝓸', '𝓹', '𝓺', '𝓻', '𝓼', '𝓽', '𝓾', '𝓿', '𝔀', '𝔁', '𝔂', '𝔃', '𝓐', '𝓑', '𝓒', '𝓓', '𝓔', '𝓕', '𝓖', '𝓗', '𝓘', '𝓙', '𝓚', '𝓛', '𝓜', '𝓝', '𝓞', '𝓟', '𝓠', '𝓡', '𝓢', '𝓣', '𝓤', '𝓥', '𝓦', '𝓧', '𝓨', '𝓩', '𝟎', '𝟏', '𝟐', '𝟑', '𝟒', '𝟓', '𝟔', '𝟕', '𝟖', '𝟗', '❗', '❓', '.', ',', '"', "'"],
            'fraktur' => ['𝔞', '𝔟', '𝔠', '𝔡', '𝔢', '𝔣', '𝔤', '𝔥', '𝔦', '𝔧', '𝔨', '𝔩', '𝔪', '𝔫', '𝔬', '𝔭', '𝔮', '𝔯', '𝔰', '𝔱', '𝔲', '𝔳', '𝔴', '𝔵', '𝔶', '𝔷', '𝔄', '𝔅', 'ℭ', '𝔇', '𝔈', '𝔉', '𝔊', 'ℌ', 'ℑ', '𝔍', '𝔎', '𝔏', '𝔐', '𝔑', '𝔒', '𝔓', '𝔔', 'ℜ', '𝔖', '𝔗', '𝔘', '𝔙', '𝔚', '𝔛', '𝔜', 'ℨ', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '!', '?', '.', ',', '"', "'"],
            'frakturBold' => ['𝖆', '𝖇', '𝖈', '𝖉', '𝖊', '𝖋', '𝖌', '𝖍', '𝖎', '𝖏', '𝖐', '𝖑', '𝖒', '𝖓', '𝖔', '𝖕', '𝖖', '𝖗', '𝖘', '𝖙', '𝖚', '𝖛', '𝖜', '𝖝', '𝖞', '𝖟', '𝕬', '𝕭', '𝕮', '𝕯', '𝕰', '𝕱', '𝕲', '𝕳', '𝕴', '𝕵', '𝕶', '𝕷', '𝕸', '𝕹', '𝕺', '𝕻', '𝕼', '𝕽', '𝕾', '𝕿', '𝖀', '𝖁', '𝖂', '𝖃', '𝖄', '𝖅', '𝟎', '𝟏', '𝟐', '𝟑', '𝟒', '𝟓', '𝟔', '𝟕', '𝟖', '𝟗', '❗', '❓', '.', ',', '"', "'"],
            'monospace' => ['𝚊', '𝚋', '𝚌', '𝚍', '𝚎', '𝚏', '𝚐', '𝚑', '𝚒', '𝚓', '𝚔', '𝚕', '𝚖', '𝚗', '𝚘', '𝚙', '𝚚', '𝚛', '𝚜', '𝚝', '𝚞', '𝚟', '𝚠', '𝚡', '𝚢', '𝚣', '𝙰', '𝙱', '𝙲', '𝙳', '𝙴', '𝙵', '𝙶', '𝙷', '𝙸', '𝙹', '𝙺', '𝙻', '𝙼', '𝙽', '𝙾', '𝙿', '𝚀', '𝚁', '𝚂', '𝚃', '𝚄', '𝚅', '𝚆', '𝚇', '𝚈', '𝚉', '𝟶', '𝟷', '𝟸', '𝟹', '𝟺', '𝟻', '𝟼', '𝟽', '𝟾', '𝟿', '！', '？', '．', '，', '"', '＇'],
            'fullwidth' => ['ａ', 'ｂ', 'ｃ', 'ｄ', 'ｅ', 'ｆ', 'ｇ', 'ｈ', 'ｉ', 'ｊ', 'ｋ', 'ｌ', 'ｍ', 'ｎ', 'ｏ', 'ｐ', 'ｑ', 'ｒ', 'ｓ', 'ｔ', 'ｕ', 'ｖ', 'ｗ', 'ｘ', 'ｙ', 'ｚ', 'Ａ', 'Ｂ', 'Ｃ', 'Ｄ', 'Ｅ', 'Ｆ', 'Ｇ', 'Ｈ', 'Ｉ', 'Ｊ', 'Ｋ', 'Ｌ', 'Ｍ', 'Ｎ', 'Ｏ', 'Ｐ', 'Ｑ', 'Ｒ', 'Ｓ', 'Ｔ', 'Ｕ', 'Ｖ', 'Ｗ', 'Ｘ', 'Ｙ', 'Ｚ', '０', '１', '２', '３', '４', '５', '６', '７', '８', '９', '！', '？', '．', '，', '"', '＇'],
            'doublestruck' => ['𝕒', '𝕓', '𝕔', '𝕕', '𝕖', '𝕗', '𝕘', '𝕙', '𝕚', '𝕛', '𝕜', '𝕝', '𝕞', '𝕟', '𝕠', '𝕡', '𝕢', '𝕣', '𝕤', '𝕥', '𝕦', '𝕧', '𝕨', '𝕩', '𝕪', '𝕫', '𝔸', '𝔹', 'ℂ', '𝔻', '𝔼', '𝔽', '𝔾', 'ℍ', '𝕀', '𝕁', '𝕂', '𝕃', '𝕄', 'ℕ', '𝕆', 'ℙ', 'ℚ', 'ℝ', '𝕊', '𝕋', '𝕌', '𝕍', '𝕎', '𝕏', '𝕐', 'ℤ', '𝟘', '𝟙', '𝟚', '𝟛', '𝟜', '𝟝', '𝟞', '𝟟', '𝟠', '𝟡', '❕', '❔', '.', ',', '"', "'"],
            'capitalized' => ['ᴀ', 'ʙ', 'ᴄ', 'ᴅ', 'ᴇ', 'ꜰ', 'ɢ', 'ʜ', 'ɪ', 'ᴊ', 'ᴋ', 'ʟ', 'ᴍ', 'ɴ', 'ᴏ', 'ᴘ', 'q', 'ʀ', 'ꜱ', 'ᴛ', 'ᴜ', 'ᴠ', 'ᴡ', 'x', 'ʏ', 'ᴢ', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '﹗', '﹖', '﹒', '﹐', '"', "'"],
            'circled' => ['ⓐ', 'ⓑ', 'ⓒ', 'ⓓ', 'ⓔ', 'ⓕ', 'ⓖ', 'ⓗ', 'ⓘ', 'ⓙ', 'ⓚ', 'ⓛ', 'ⓜ', 'ⓝ', 'ⓞ', 'ⓟ', 'ⓠ', 'ⓡ', 'ⓢ', 'ⓣ', 'ⓤ', 'ⓥ', 'ⓦ', 'ⓧ', 'ⓨ', 'ⓩ', 'Ⓐ', 'Ⓑ', 'Ⓒ', 'Ⓓ', 'Ⓔ', 'Ⓕ', 'Ⓖ', 'Ⓗ', 'Ⓘ', 'Ⓙ', 'Ⓚ', 'Ⓛ', 'Ⓜ', 'Ⓝ', 'Ⓞ', 'Ⓟ', 'Ⓠ', 'Ⓡ', 'Ⓢ', 'Ⓣ', 'Ⓤ', 'Ⓥ', 'Ⓦ', 'Ⓧ', 'Ⓨ', 'Ⓩ', '⓪', '①', '②', '③', '④', '⑤', '⑥', '⑦', '⑧', '⑨', '!', '?', '.', ',', '"', "'"],
            'parenthesized' => ['⒜', '⒝', '⒞', '⒟', '⒠', '⒡', '⒢', '⒣', '⒤', '⒥', '⒦', '⒧', '⒨', '⒩', '⒪', '⒫', '⒬', '⒭', '⒮', '⒯', '⒰', '⒱', '⒲', '⒳', '⒴', '⒵', '🄐', '🄑', '🄒', '🄓', '🄔', '🄕', '🄖', '🄗', '🄘', '🄙', '🄚', '🄛', '🄜', '🄝', '🄞', '🄟', '🄠', '🄡', '🄢', '🄣', '🄤', '🄥', '🄦', '🄧', '🄨', '🄩', '⓿', '⑴', '⑵', '⑶', '⑷', '⑸', '⑹', '⑺', '⑻', '⑼', '!', '?', '.', ',', '"', "'"],
            'underlinedSingle' => ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '!', '?', '.', ',', '"', "'"],
            'underlinedDouble' => ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '!', '?', '.', ',', '"', "'"],
            'strikethroughSingle' => ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '!', '?', '.', ',', '"', "'"],
            'crosshatch' => ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '!', '?', '.', ',', '"', "'"],
        ];

        foreach ($specialList as $list)
        {
            $text = str_replace($list, $target, $text);
        }

        return $text;
    }
}
