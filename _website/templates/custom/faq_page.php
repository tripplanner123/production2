<?php defined('DIR') OR exit; ?>
<main class="site__content">
    <div class="content">
        <div class="page-content page-content--transfer">
           
            <div class="container">
                <div class="transfer-header text-center">
                    <!-- <span class="transfer-icon d-inline-block"></span> -->
                    <!-- <div class="clear"></div> -->
                    <h2 class="transfer-heading d-inline-block position-relative" style="font-size: 26px"><?php echo $title; ?></h2>
                </div>
                
                   <?php
                   // echo "<pre>";
                   // print_r(get_defined_vars());
                   // echo "</pre>";
                    $i = 1;
                    $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
                    foreach (array_reverse($lists) AS $item):
                    ?>     
                    <div class="transfer-content bg-white" style="margin-bottom: 20px;"> 
                        <div class="block faq fix">
                            <div class="title" style="cursor: pointer" onclick="$('.text-<?=$i?>').slideToggle()">
                                <h3><?php echo ucfirst(strtolower($item["title"])); ?></h3>
                            </div>
                            <!-- .title -->
                            <div class="text text-<?=$i?>" style="display: none; padding-top: 20px">
                                <?php 
                                if(preg_match($reg_exUrl, $item["description"], $url)){
                                    $urlx = "<a href=\"".strip_tags($url[0])."\">".strip_tags($url[0])."</a>";
                                    echo preg_replace($reg_exUrl, $urlx, $item["description"]);

                                }else{
                                    echo $item["description"];
                                }
                                ?>
                            </div>
                        </div>
                       
                    </div>
                    <?php
                    $i++;
                    endforeach;
                    ?> 
                
            </div>
        </div>
    </div>
</main>