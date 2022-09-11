<?php
$myshops=array();
//system SETTINGS start
$system_url="https://www.example.com"; //change to your site URL
$system_domain="example.com";
$limit_requests="10"; //limit requests in seconds, using cookie sessions.
//shop 1 custom settings start
$shopid=1; //unique shop ID
$sitedomain[$shopid]='https://www.amazon.de/'; 
$siteurl[$shopid]='https://www.amazon.de/s?k=[keyword]';
$sitename[$shopid]="Amazon";
$itemid[$shopid]='//div[@data-component-type="s-search-result"]';
$itemname[$shopid]='.//h2//a//span';
$itemprice[$shopid]='.//span[@class="a-price-whole"]';
$itemcur[$shopid]='.//span[@class="a-price-symbol"]';
$itemlink[$shopid]='.//h2/a/@href';
//shop 1 custom settings end
$myshops[$shopid]=$shopid;
//
//shop 2 custom settings start
$shopid=2; //unique shop ID
$sitedomain[$shopid]='https://kaup24.ee/';
$siteurl[$shopid]='https://kaup24.ee/et/search?q=[keyword]';
$sitename[$shopid]="Kaup24";
$itemid[$shopid]='//div[@class="product-item-inner-hover pbot"]';
$itemname[$shopid]='.//p[@class="product-name"]';
$itemprice[$shopid]='.//div[@class="product-price"]//span[contains(@class, "price ")]/text()[normalize-space()]';
$itemcur[$shopid]='.//div[@class="product-price"]//small';
$itemlink[$shopid]='.//p[@class="product-name"]/a/@href';
//shop 2 custom settings end
$myshops[$shopid]=$shopid;
//
//shop 3 custom settings start
$shopid=3; //unique shop ID
$sitedomain[$shopid]='https://www.soov.ee/'; 
$siteurl[$shopid]='https://soov.ee/keyword-[keyword]/listings.html';
$sitename[$shopid]="Soov";
$itemid[$shopid]='//div[@class="item-list"]';
$itemname[$shopid]='.//h5//a';
$itemprice[$shopid]='.//h2';
//$itemcur[$shopid]='';
$itemlink[$shopid]='.//h5/a/@href';
//shop 3 custom settings end
$myshops[$shopid]=$shopid;
//
//shop 4 custom settings start
$shopid=4; //unique shop ID
$sitedomain[$shopid]='https://www.ebay.com/';
$siteurl[$shopid]='https://www.ebay.com/sch/i.html?_nkw=[keyword]';
$sitename[$shopid]="ebay";
$itemid[$shopid]='//ul//li[@class="s-item s-item__pl-on-bottom"]';
$itemname[$shopid]='.//a[@class="s-item__link"]//div[@class="s-item__title"]';
$itemprice[$shopid]='.//span[@class="s-item__price"]';
//$itemcur[$shopid]='';
$itemlink[$shopid]='.//a[@class="s-item__link"]/@href';
//shop 4 custom settings end
$myshops[$shopid]=$shopid;
//
?>