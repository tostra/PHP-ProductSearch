<?php
function get_web_page($url){
	{
    $options = array(
        CURLOPT_RETURNTRANSFER => true,     // return web page
        CURLOPT_HEADER         => false,    // don't return headers
        CURLOPT_FOLLOWLOCATION => true,     // follow redirects
        CURLOPT_ENCODING       => "",       // handle all encodings
        CURLOPT_USERAGENT      => "Mozilla/5.0 (compatible; PHP-ProductSearchHelper; +https://www.github.com/tostra/PHP-ProductSearchHelper)", // who am i
        CURLOPT_AUTOREFERER    => true,     // set referer on redirect
        CURLOPT_CONNECTTIMEOUT => 10,      // timeout on connect
        CURLOPT_TIMEOUT        => 10,      // timeout on response
        CURLOPT_MAXREDIRS      => 5,       // stop after 5 redirects
		CURLOPT_SSL_VERIFYPEER => false,
	    CURLOPT_SSL_VERIFYHOST => false,
    );

    $ch      = curl_init( $url );
    curl_setopt_array( $ch, $options );
	curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept-Language: en']);
    $content = curl_exec( $ch );
    $err     = curl_errno( $ch );
    $errmsg  = curl_error( $ch );
    $header  = curl_getinfo( $ch );
    curl_close( $ch );
    $header['content'] = $content;
    return $header;
}
}
function performsearch($k, $s){
//shop var URL start
global $siteurl;
global $sitename;
global $itemid;
global $itemname;
global $itemprice;
global $itemlink;
global $sitedomain;
global $productlist;
global $myshops;
global $limit_requests;
global $itemcur;
$ret = 0;
if (isset($siteurl[$s]) and isset($myshops[$s]) and isset($_COOKIE["chkcookie"]) and !empty(trim($k))){
$k = urlencode($k);
$urlmake = $siteurl[$s];
$urlmake = str_replace("[keyword]", $k, $urlmake);
//shop var URL end
//get shops HTML
$result = get_web_page($urlmake);
if ($result['http_code'] == 200){
$html = $result['content'];
$dom = new DOMDocument();
$internalErrors = libxml_use_internal_errors(true);
$dom->loadHTML('<?xml encoding="UTF-8">' . $html);
$xpath = new DOMXPath($dom);
$rows = $xpath->query(''.$itemid[$s].'');  // id one product
$i=count($productlist);
foreach ($rows as $row) {
	if (isset($itemname[$s])) {
	 $desc = $xpath->query(''.$itemname[$s].'', $row);
    if ($desc->length > 0) {
        $productlist[$i]['name'] = trim($desc->item(0)->nodeValue);
		$ret = 1;//return success we got something
    } else {
	$productlist[$i]['name'] = "no description";
		}
		}
	if (isset($itemprice[$s])) {
	$price = $xpath->query(''.$itemprice[$s].'', $row);
    if ($price->length > 0) {
       $productlist[$i]['price']  = trim($price->item(0)->nodeValue);
    } else {
	$productlist[$i]['price']  = "no price";
		}
		 } else {
	$productlist[$i]['price']  = "no price";
		}
			if (isset($itemcur[$s])) {
	$cur = $xpath->query(''.$itemcur[$s].'', $row);
    if ($cur->length > 0) {
       $productlist[$i]['cur']  = trim($cur->item(0)->nodeValue);
    } else {
	$productlist[$i]['cur']  = "";
		}
		 } else {
	$productlist[$i]['cur']  = "";
		}
		if (isset($itemlink[$s])) {
	$link = $xpath->query(''.$itemlink[$s].'', $row);
    if ($link ->length > 0) {
        $gtthislink  = trim($link ->item(0)->nodeValue);
		if (!preg_match('/https:\/\//', $gtthislink)) {
				$addressx=substr($gtthislink, 0, 1);
if ($addressx == "/") {
$gtthislink=substr($gtthislink, 1);
}
	        $productlist[$i]['link']  = ''.$sitedomain[$s].''.$gtthislink.'';
} else {
	        $productlist[$i]['link']  = $gtthislink;
	}
     } else {
	$productlist[$i]['link'] = "";
		}
		} else {
	$productlist[$i]['link'] = "";
		}
		if ($sitename[$s]) {
	$productlist[$i]['site'] = ''.$sitename[$s].'';
	}
	$i=$i+1;
}
}
}
//get shops HTML end
 return $ret;
}
?>