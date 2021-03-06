<?php defined('DIR') OR exit; ?>

<div id="cart-message-modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <form action="?" class="change-password-form">
                <div class="modal-header flex-column align-items-center">
                    <img src="_website/images/logo.svg" width="100" height="50" alt="" class="change-password-form__icon">
                    <!-- <h4 class="change-password-form__title"><?=l("message")?></h4> -->
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22px" height="22px" viewBox="0 0 20.17 20.17">
                        <path fill="#4d4d4f" d="M19.74,17.68l-7.63-7.63,7.56-7.57A1.46,1.46,0,0,0,17.61.43L10.05,8,2.49.43A1.46,1.46,0,0,0,.43,2.49L8,10.05.43,17.62a1.46,1.46,0,0,0,2.07,2.06l7.56-7.57,7.62,7.62a1.46,1.46,0,0,0,2.07-2.06Z"></path>
                    </svg>
                </button>
                </div>
                <div class="modal-body">
                    <p style="font-size: 18px;"><?=l("checkyouremail")?></p>
                </div>
            </form>
        </div>
    </div>
</div>

<?php 
$select = db_fetch("SELECT `content` FROM `pages` WHERE `id`=131 AND `language`='".l()."'");
?>
<div id="purchase-terms-modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header flex-column align-items-center">
                <h4 class="change-password-form__title" style="font-size: 2.5rem"><?=l("siterule")?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22px" height="22px" viewBox="0 0 20.17 20.17">
                        <path fill="#4d4d4f" d="M19.74,17.68l-7.63-7.63,7.56-7.57A1.46,1.46,0,0,0,17.61.43L10.05,8,2.49.43A1.46,1.46,0,0,0,.43,2.49L8,10.05.43,17.62a1.46,1.46,0,0,0,2.07,2.06l7.56-7.57,7.62,7.62a1.46,1.46,0,0,0,2.07-2.06Z"></path>
                    </svg>
                </button>
            </div>
            <div class="modal-body" style="max-height: 350px; overflow: auto;">
                <div class="text-holder" style="font-size: 12px;color: #BABABA;">
                    <?=strip_tags($select['content'], '<p><br>')?>
                </div>
            </div>
            
        </div>
    </div>
</div>

<?php 
if(isset($_GET["result"]) && ($_GET["result"]=="success" || $_GET["result"]=="fail")):
if($_GET["result"]=="success"){
    $select = db_fetch("SELECT `content` FROM `pages` WHERE `id`=178 AND `language`='".l()."'");
}else if($_GET["result"]=="fail"){
    $select = db_fetch("SELECT `content` FROM `pages` WHERE `id`=177 AND `language`='".l()."'");
}else{
    $select['content'] = "";
}
?>
<div id="purchase-status" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body" style="max-height: 350px; overflow: auto;">
                <div class="text-holder" style="font-size: 12px;color: #BABABA;">
                    <?=strip_tags($select['content'], '<p><br>')?>
                </div>
            </div>
            <div class="modal-footer justify-content-center pt-0" style="margin-top: 20px;">
                <a href="/" class="button button--yellow button--small text-uppercase"><?=l("close")?></a>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $("#purchase-status").modal("show");
</script>
<?php endif; ?>

<main class="site__content">
    <div class="content">
        <div class="page-header">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-12">
                        <h2 class="page-title text-center text-lg-left"><?php echo $title ?></h2>
                    </div>
                    
                </div>
            </div>
        </div>
        <div class="page-content pt-0">
            <div class="container">
                <?php 
                $order_id='';
                $g_cart = g_cart();
                if(count($g_cart)){                 
                ?>
                <div class="table-responsive">
                    
                    <table class="cart-table w-100">
                        <thead>
                            <tr>
                                <th></th>
                                <th><?=l("tours")?></th>
                                
                                <th><?=l("pickup")?></th>
                                <th><?=l("pickupmodaltitle")?></th>
                                <th><?=l("totalpricefinal")?></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            
                            
                            $totalPriceOut = 0;
                            $x=0;
                            foreach($g_cart as $item):
                            $x++;
                            $doubleWay = "";
                            $guests = "";
                            $totalPriceOut += $item['totalprice'];
                            if(!empty($item['tourplaces'])){
                                $sql = "SELECT `title` FROM `catalogs` WHERE `id` IN(".$item['tourplaces'].") AND `menuid`=36 AND `deleted`=0 AND `language`='".l()."'"; 
                                $fetch = db_fetch_all($sql);
                                $places = array();
                                foreach ($fetch as $v) {
                                    $places[] = $v['title'];
                                }

                                $item['title'] = implode("<br />", $places);
                                $item['image1'] = "/img/plan.png";
                            }

                            // $image1 = $item['image1'];
                            $title = $item['title'];
                            if($item["type"]=="transport"){
                                if($item['startPlaceName2'] && $item['endPlaceName2']){
                                    $title .= "";
                                    $guests = "<table border=\"0\" cellspaceing=\"0\" cellpadding=\"0\">";
                                    $guests .= "<tr>";
                                    $guests .= "<td>";
                                    $guests .= $item["startPlaceName"] . " - " . $item["endPlaceName"];
                                    $guests .= "<br />".l("passenger").": ".($item["guests2"]+$item["children2"]+$item["childrenunder2"])."<br />";
                                    
                                    //start
                                    $currency_123 = "gel";
                                    if(isset($_SESSION["currency_123"])){
                                        $currency_123 = $_SESSION["currency_123"];
                                    }

                                    switch ($currency_123) {
                                        case 'usd':
                                            $guests .= round((int)$item["roud1_price"] / (float)s("currencyusd"))." $";
                                            break;
                                        case 'eur':
                                            $guests .= round((int)$item["roud1_price"] / (float)s("courseeur"))." &euro;";
                                            break;
                                        default:
                                            $guests .= $item["roud1_price"]." <span class=\"lari-symbol\" style=\"font-size:25px !important;\">l</span>";
                                            break;
                                    }                                   
                                    
                                    $guests .= "</td>";
                                    $guests .= "</tr>";

                                    $guests .= "<tr>";
                                    $guests .= "<td>";
                                    $guests .= $item["startPlaceName2"] . " - " . $item["endPlaceName2"];
                                    $guests .= l("passenger").": ".$item["guests2"];
                                    
                                    //start
                                    $currency_123 = "gel";
                                    if(isset($_SESSION["currency_123"])){
                                        $currency_123 = $_SESSION["currency_123"];
                                    }

                                    switch ($currency_123) {
                                        case 'usd':
                                            $guests .= "<br />".round((int)$item["roud2_price"] / (float)s("currencyusd"))." $";
                                            break;
                                        case 'eur':
                                            $guests .= "<br />".round((int)$item["roud2_price"] / (float)s("courseeur"))." &euro;";
                                            break;
                                        default:
                                            $guests .= "<br />".$item["roud2_price"]." <span class=\"lari-symbol\" style=\"font-size:25px !important;\">l</span>";
                                            break;
                                    }
                                    //end
                                    $guests .= "</td>";
                                    $guests .= "</tr>";

                                    $guests .= "</table>";                                    
                                }else{
                                    $title .= $item["startPlaceName"] . " - " . $item["endPlaceName"];
                                    $guests = "<br />".l("passenger").": ".($item["guests"]+$item["children"]+$item["childrenunder"]);
                                }

                                $logoImage = "/_website/images/transport-1-yellow.svg";
                                $logoImage2 = "/_website/images/transport-1-yellow.svg";
                                
                                if(isset($item["transport_name1"]) && $item["transport_name1"] == "Sedan"){
                                    $logoImage = "/_website/images/transport-1-yellow.svg";
                                }else if(isset($item["transport_name1"]) && $item["transport_name1"] == "Minivan"){
                                    $logoImage = "/_website/images/transport-2-yellow.svg";
                                }else if(isset($item["transport_name1"]) && $item["transport_name1"] == "Bus"){
                                    $logoImage = "/_website/images/bus-yellow.svg";
                                }

                                if(isset($item["transport_name2"]) && $item["transport_name2"] == "Sedan"){
                                    $logoImage2 = "/_website/images/transport-1-yellow.svg";
                                }else if(isset($item["transport_name2"]) && $item["transport_name2"] == "Minivan"){
                                    $logoImage2 = "/_website/images/transport-2-yellow.svg";
                                }else if(isset($item["transport_name2"]) && $item["transport_name2"] == "Bus"){
                                    $logoImage2 = "/_website/images/bus-yellow.svg";
                                }                                
                            }else if($item["type"]=="ongoing"){
                                $logoImage = $item["image1"];
                            }
                            ?>
                            <tr 
                                class="cart-items" 
                                id="r<?=$item['id']?>" 
                                data-title="<?=htmlentities($title)?>" 
                                data-title2="<?=htmlentities($item["startPlaceName2"] . " - " . $item["endPlaceName2"])?>" 
                                data-cid="<?=$item['id']?>" 
                                data-date1="<?=$item['startdate']?>" 
                                data-date2="<?=$item['startdate2']?>" 
                                data-transportname1="<?=$item["transport_name1"]?>"  data-transportname2="<?=$item["transport_name2"]?>" data-numberofpessingers1="<?=($item["guests"]+$item["children"]+$item["childrenunder"])?>" 
                                data-numberofpessingers2="<?=($item["guests2"]+$item["children2"]+$item["childrenunder2"])?>" 
                                data-price="<?=(float)$item['totalprice']?>" 
                                data-price1="<?=(float)$item['roud1_price']?>" 
                                data-price2="<?=(float)$item['roud2_price']?>">
                                <td>
                                    <div style="background-image: url('<?=$logoImage?>'); width: 100px; height: 100px; background-repeat: no-repeat; background-position: center; background-size: 50px;"></div>

                                    <?php if($item['startPlaceName2'] && $item['endPlaceName2']){ ?>
                                    <div style="background-image: url('<?=$logoImage2?>'); width: 100px; height: 100px; background-repeat: no-repeat; background-position: center; background-size: 50px;"></div>
                                    <?php } ?>
                                </td>
                                <td>
                                    <span><?=$title?></span><?=$doubleWay.$guests?>
                                </td>
                                <td>
                                    <?php 
                                    $height = ($item['startPlaceName2'] && $item['endPlaceName2']) ? "height: 200px" : "";
                                    ?>
                                    <table border="0" cellspaceing="0" cellpadding="0" style="<?=$height?>">
                                    <tr>
                                        <td>
                                            <p><?=$item['startdate']?> <?=($item['timetrans']) ? $item['timetrans'] : ''?></p>
                                        </td>
                                    </tr>

                                    <?php if($item['startPlaceName2'] && $item['endPlaceName2']): ?>
                                    <tr>
                                        <td>
                                            <p><?=$item['startdate2']?> <?=$item['timetrans2']?></p>
                                        </td>
                                    </tr>
                                    <?php endif; ?>

                                    </table>
                                </td>                             
                                
                                <td>   
                                    <table border="0" cellspaceing="0" cellpadding="0" style="height: 200px">
                                        <tbody>

                                        <tr>
                                            <td>
                                                <p><input type="text" name="pickupPlace___" value="<?=htmlentities($item["wherepickup"])?>" placeholder="<?=l("pickupaddress1")?>" class="form-control pickupPlace___" data-double="false" data-id="<?=$item['id']?>" /></p>
                                            </td>
                                        </tr>
                                        <?php if($item['startPlaceName2'] && $item['endPlaceName2']): ?>
                                        <tr>
                                            <td>
                                                 <p><input type="text" name="pickupPlace2___" value="<?=htmlentities($item["wherepickup2"])?>" placeholder="<?=l("pickupaddress1")?>" class="form-control pickupPlace___" data-double="true" data-id="<?=$item['id']?>" /></p>

                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                        </tbody>
                                    </table>

                                </td>
                                <td>
                                    <?php 
                                    $currency_123 = "gel";
                                    if(isset($_SESSION["currency_123"])){
                                        $currency_123 = $_SESSION["currency_123"];
                                    }
                                    
                                    if($item["type"]=="ongoing"){
                                        $item["roud1_price"] = $item["totalprice"];
                                    }

                                    switch ($currency_123) {
                                        case 'usd':
                                            $totalPrice = round(((int)$item['roud1_price'] + (int)$item['roud2_price']) / (float)s("currencyusd"));
                                            break;
                                        case 'eur':
                                            $totalPrice = round((int)((int)$item['roud1_price'] + (int)$item['roud2_price']) / (float)s("courseeur"));
                                            break;
                                        default:
                                            $totalPrice = (int)$item['roud1_price'] + (int)$item['roud2_price'];
                                            break;
                                    }

                                    ?>
                                    <span class="tdprice"><?=(int)$totalPrice?></span>
                                    <?=currencySign()?>
                                </td>
                                <td class="text-right">
                                    <div class="custom-checkbox-1 d-inline-block">
                                        <input type="checkbox" class="cart-item-select-control custom-checkbox-1__input g-cart-item" id="cart-item-select-control-<?=$item['id']?>" data-id="<?=$item['id']?>" <?=($x==1) ? 'checked="checked"' : ''?>>
                                        <label for="cart-item-select-control-<?=$item['id']?>" class="custom-checkbox-1__label"></label>
                                    </div>
                                </td>
                            </tr>
                            <?php 
                            $order_id=$item['uniq'];
                            
                            endforeach; 
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="siterules">
                    <!-- <label><input type="checkbox" name="siterules"> <?=l("siterule")?></label> -->

                    <div class="custom-checkbox-1 d-inline-block">
                        <input type="checkbox" class="custom-checkbox-1__input" name="siterules" id="siterules" <?=(isset($_SESSION["siterules"]) && $_SESSION["siterules"]=="checked") ? 'checked="checked"' : ''?>>
                        <label for="siterules" class="custom-checkbox-1__label"><a href="#" data-toggle="modal" data-target="#purchase-terms-modal"><?=l("siterule")?></a></label>
                    </div>
                    <script type="text/javascript">
                        <?php if(isset($_SESSION["siterules"]) && $_SESSION["siterules"]=="checked"): ?>
                        $(document).ready(function(){
                            $(".bgcab").removeAttr("disabled");
                        });
                        <?php endif; ?>
                    </script>

                </div>
                <div class="button-group button-group--cart-action-buttons text-lg-right g-buttons-show-hide">
                    
                    <button type="button" class="button button--gray button-group--cart-action-button button-delete text-uppercase g-cart-delete-button"><?=l("delete")?></button>

                    <?php if(isset($_SESSION["beetrip_user"])){ ?>
                    <button type="button" class="button button--yellow button-group--cart-action-button button--buy text-uppercase bgcab" disabled="disabled"><?=l("buy")?></button>
                    <?php }else{ ?>
                    <button type="button" class="button button--yellow text-uppercase button-group--cart-action-button bgcab" data-toggle="modal" data-target="#auth-modal" disabled="disabled"><?=l("buy")?></button>
                    <?php } ?>
                    
                </div>
                <?php 
                }else{
                    echo "<h5>".l("nodata")."</h5>";
                }
                ?>
            </div>
            <div class="container payment-block payment-block--hidden">
                <div class="select-payment-method-title text-center text-lg-left text-uppercase">
                    <?=l("selectpaymentmethod")?>
                </div>
                <div class="payment-tabs">
                    <ul class="nav nav-tabs align-items-center justify-content-center justify-content-lg-start" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link text-center" id="pay-method-2-tab" data-toggle="tab" href="#pay-method-2" role="tab" aria-controls="pay-method-2" aria-selected="false">
                                <span class="payment-method-icon payment-method-icon--2 d-inline-block"></span>
                                <span class="d-block"><?=l("invoicepayment")?></span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <!-- <a class="nav-link text-center" id="pay-method-1-tab" data-toggle="tab" href="#pay-method-1" role="tab" aria-controls="pay-method-1" aria-selected="true">
                                <span class="payment-method-icon payment-method-icon--1 d-inline-block"></span>
                                <span class="d-block">Pay With Card</span>
                            </a> -->
                            
                            <?php 
                            $order_id = "fb657d65d12373dbf6983"; 
                            if($order_id!=""){?>
                            <a class="nav-link text-center g-pay-with-creditcard" href="javascript:void(0)" data-href="https://3dacq.georgiancard.ge/payment/start.wsm?lang=KA&merch_id=D6640FE47F9AE706A041C0D913DCF654&back_url_s=<?=urlencode('https://beetrip.ge/en/cart?result=success')?>&back_url_f=<?=urlencode('https://beetrip.ge/en/cart?result=fail')?>&preauth=N&o.order_id=<?=$order_id?>&o.userid=<?=(isset($_SESSION["beetrip_user"])) ? $_SESSION["beetrip_user"] : ''?>&o.lang=<?=l()?>&o.currency=gel">
                                <span class="payment-method-icon payment-method-icon--1 d-inline-block"></span>
                                <span class="d-block"><?=l("paywithcard")?></span>
                            </a>
                            <?php 
                            }
                            ?>
                        </li>
                    </ul>
                    <!-- method payment -->
                    <div class="tab-content" style="display: none;">
                        <div class="tab-pane fade show active" id="pay-method-2" role="tabpanel" aria-labelledby="pay-method-2-tab">
                            <form action="?">
                                <input type="hidden" id="itemstobuy" value="" />
                                <div class="payment-method-header">
                                    <div class="payment-method-header__title text-uppercase"><?=l("invoicepayment")?></div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="w-100 form-label">
                                                <span class="form-label-text form-label-text--gray d-inline-block"><?=l("company")?></span>
                                                <input type="text" class="form-control g-pay-company" value="" />
                                            </label>
                                        </div>
                                        <div class="form-group">
                                            <label class="w-100 form-label">
                                                <span class="form-label-text form-label-text--gray d-inline-block"><?=l("address")?></span>
                                                <input type="text" class="form-control g-pay-address" value="">
                                            </label>
                                        </div>
                                        <div class="form-group">
                                            <label class="w-100 form-label">
                                                <span class="form-label-text form-label-text--gray d-inline-block"><?=l("idnumber")?></span>
                                                <input type="text" class="form-control g-pay-id" value="">
                                            </label>
                                        </div>
                                        <div class="form-group">
                                            <label class="w-100 form-label">
                                                <span class="form-label-text form-label-text--gray d-inline-block"><?=l("vatid")?></span>
                                                <input type="text" class="form-control g-pay-vat" value="">
                                            </label>
                                        </div>
                                        <button type="button" class="button button--yellow button--payment-submit w-100 text-uppercase"><?=l("order")?></button>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="table-responsive">
                                            <table class="table payment-table payment-table--1">
                                                <!-- result here -->
                                            </table>
                                        </div>
                                        <div class="sum-price-block d-flex justify-content-end">
                                            <div class="sum-price-block__additional-info">+<?=l("freeinsurance")?></div>
                                            <div class="sum-price-block__price">
                                                <div class="sum-price-block__price-key">
                                                    <?=l("totalprice")?>
                                                </div>
                                                <div class="sum-price-block__price-val">
                                                    <span class="theTotalPrice">0</span> <?=currencySign()?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 d-lg-none">
                                        <!--<button type="submit" class="button button--yellow button--payment-submit w-100 text-uppercase">order yys</button> for mobile -->
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div> 




                </div>
            </div>
        </div>
    </div>
</main>
<!-- content -->

<script src="_website/minJs/default.min.js"></script>
<script type="text/javascript" src="_website/js/cart.js"></script>