<?php

function addUpdateParamsToUrl($params, $url)
{
    $url_parts = parse_url($url);
    if (isset($url_parts['query'])) {
        parse_str($url_parts['query'], $_params);
    } else {
        $_params = [];
    }
    $_params = array_merge_recursive($_params, $params);
    $url_parts['query'] = http_build_query($_params);
    return buildUrl($url_parts);
}

function buildUrl($urlParts)
{
    $scheme = isset($urlParts['scheme']) ? $urlParts['scheme'] : 'http';
    $host = $urlParts['host'];
    $path = isset($urlParts['path']) ? $urlParts['path'] : '';
    $query = isset($urlParts['query']) ? $urlParts['query'] : '';
    $url = $scheme . '://' . $host . $path . '?' . $query;
    return $url;
}

function result($success = false, $message = '', $data = null)
{
    return new Result($success, $message, $data);
}

function isMobile()
{
    $userAgent = $_SERVER['HTTP_USER_AGENT'];
    if (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $userAgent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($userAgent, 0, 4))) {
        return true;
    } else {
        return false;
    }
}

function deleteFileOrDirectory($path)
{
    if (File::isDirectory($path)) {
        return File::deleteDirectory($path);
    } else if (File::isFile($path)) {
        return File::delete($path);
    }
    return false;
}

function deleteFileOrDirectoryInPublic($dirPath)
{
    if ($dirPath) {
        $dirPath = trim($dirPath);
        if (strlen($dirPath) > 0) {
            $dirPath = $_SERVER['DOCUMENT_ROOT'] . $dirPath;
            return deleteFileOrDirectory($dirPath);
        }
    }
}

function getBusinessPageUrl($id)
{
    return baseSiteUrl() . "/company/detail/" . $id;
}

function downloadfile($file)
{
    if (file_exists($file)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        readfile($file);
        exit;
    }
}

function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function current_url()
{
    return 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
}

function current_uri()
{
    return $_SERVER['REQUEST_URI'];
}

//dangnv
function baseSiteUrl()
{
    return isset($_SERVER['HTTP_HOST']) ? 'http://' . $_SERVER['HTTP_HOST'] : 'http://localhost';
}

//dangnv fix phone with VN
function phoneWithCountryCode($phoneCode, $phone)
{
    if ($phoneCode == '084' || $phoneCode == '+84') {//VN
        if (!startsWith($phone, '0')) {
            $phoneCode = '0';
        } else {
            $phoneCode = '';
        }
    }
    return $phoneCode . $phone;
}

function hidePhoneNumber($phone)
{
    $phone = trim($phone);
    $phone = substr($phone, 0, -4);
    return $phone . "xxxx";
}

function hideOrderName($str)
{
    $str = trim($str);
    return strlen($str) < 5 ? show(strlen($str)) : substr($str, 0, -4) . 'xxxx';
}

function show($int)
{
    switch ($int) {
        case 1:
            return 'x';
        case 2:
            return 'xx';
        case 3:
            return 'xxx';
        case 4:
            return 'xxx';
        default:
            return 'xxxx';
    }
}

function buildParams($params = [])
{
    $params = array_merge($_GET, $params);
    $newQueryString = http_build_query($params);
    if ($newQueryString != '') {
        return '?' . $newQueryString;
    }
}

function rebuildUrl($params = [])
{
    $params = array_merge($_GET, $params);
    $newQueryString = http_build_query($params);
    $parseRes = parse_url($_SERVER  ['REQUEST_URI']);
    if ($newQueryString != '') {
        return $parseRes['path'] . '?' . $newQueryString;
    }
    return baseUrl();
}

function referUrl()
{
    return $_SERVER['HTTP_REFERER'];
}

function strAcronym($str, $acronym = '')
{
    $words = explode(' ', $str);
    foreach ($words as $word) {
        $acronym .= strtoupper(substr($word, 0, 1));
    }
    return $acronym;
}

function curl_url_get_async($url)
{
    $parts = parse_url($url);

    $fp = fsockopen($parts['host'],
        isset($parts['port']) ? $parts['port'] : 80,
        $errno, $errstr, 30);

    $out = "GET " . $parts['path'] . "?" . $parts['query'] . " HTTP/1.1\r\n";
    $out .= "Host: " . $parts['host'] . "\r\n";
    $out .= "Content-Type: application/x-www-form-urlencoded\r\n";
    $out .= "Connection: Close\r\n\r\n";
    fwrite($fp, $out);
    fclose($fp);
}

//TODO - should include posting a file.
function curl_url_post_async($url, $params)
{
    $post_params_string = http_build_query($params);
    $parts = parse_url($url);
    $fp = fsockopen($parts['host'], isset($parts['port']) ? $parts['port'] : 80, $errno, $errstr, 30);
    $out = "POST " . $parts['path'] . " HTTP/1.1\r\n";
    $out .= "Host: " . $parts['host'] . "\r\n";
    $out .= "Content-Type: application/x-www-form-urlencoded\r\n";
    $out .= "Content-Length: " . strlen($post_params_string) . "\r\n";
    $out .= "Connection: Close\r\n\r\n";
    if (isset($post_params_string)) $out .= $post_params_string;
    fwrite($fp, $out);
    fclose($fp);
}

function isChrome()
{
    return strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome');
}


/**
 * Send email
 * @param string $view
 * @param array $data
 * @param string $to |array [{name: $name, email: $email}]
 * @param string $subject
 * @param $attachment
 * @param $toType (CC or BC)
 */
function sendEmailByQueue($view, $data, $to, $subject, $attachment = null, $toType = 'cc')
{
    \Mail::queue($view, $data, function ($message) use ($to, $subject, $attachment, $toType) {
        $message->from(
            config('mail.from.address'),
            config('mail.from.name')
        );

        if (is_array($to)) {
            foreach ($to as $email) {
                if ($toType == 'bcc') {
                    $message->bcc($email);
                } else {
                    $message->cc($email);
                }
            }
        } else {
            $message->to($to);
        }
        $message->subject($subject);

        try {
            if ($attachment && file_exists($attachment)) {
                $message->attach($attachment, ['as' => 'attachment', 'mime' => mime_content_type($attachment)]);
            }
        } catch (Exception $exception) {

        }
    });
}

function sendEmail($view, $data, $to, $subject, $attachment = null, $toType = 'cc')
{
    \Mail::send($view, $data, function ($message) use ($to, $subject, $attachment, $toType) {
        $message->from(
            config('mail.from.address'),
            config('mail.from.name')
        );

        if (is_array($to)) {
            foreach ($to as $email) {
                if ($toType == 'bcc') {
                    $message->bcc($email);
                } else {
                    $message->cc($email);
                }

            }
        } else {
            $message->to($to);
        }
        $message->subject($subject);
        if ($attachment) {
            $message->attach($attachment);
        }
    });
}

function facebookUserAvatarById($fbId)
{
    return 'http://graph.facebook.com/' . $fbId . '/picture?type=large';
}

function googlePlusUserAvatarById($userId)
{
    return 'https://plus.google.com/s2/photos/profile/' . $userId . '?sz=300';
}

function sendMessage($message)
{
    $content = array(
        "en" => $message
    );

    $fields = array(
        'app_id' => "4e5ac4d7-a490-4221-a3a2-40d53b25211f",
        'included_segments' => array('All'),
        'data' => array("foo" => "bar"),
        'contents' => $content
    );

    $fields = json_encode($fields);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
        'Authorization: Basic ZmY4NzQ5NmItMzAyZS00NGFhLWE1Y2MtNzE3MTgxZjUzZjRi'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}

function sendMessageForAndroid($message)
{
    $content = array(
        "en" => $message
    );

    $fields = array(
        'app_id' => "b7dcdd59-4485-49e8-ab7b-a90d4cacee57",
        'include_player_ids' => array("7d9ad0f3-f5b5-472c-9b66-73aed788926a"),
        'data' => array("foo" => "bar"),
        'contents' => $content
    );

    $fields = json_encode($fields);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
        'Authorization: Basic MjY2NDc5Y2YtYzJhYi00NWIxLTk2MjQtZTdiMDA2ZGQyNjBi'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}

function sendMessageForAndroidBySegment($message, $segment)
{
    $content = array(
        "en" => $message
    );

    $fields = array(
        'app_id' => "b7dcdd59-4485-49e8-ab7b-a90d4cacee57",
        'included_segments' => $segment,
        'data' => array("foo" => "bar"),
        'contents' => $content
    );

    $fields = json_encode($fields);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
        'Authorization: Basic MjY2NDc5Y2YtYzJhYi00NWIxLTk2MjQtZTdiMDA2ZGQyNjBi'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}

