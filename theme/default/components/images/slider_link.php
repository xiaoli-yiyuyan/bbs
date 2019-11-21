<?php
    $setting = useComp(':setting');
?>

<style>
.imgg {
    display: block;
    width: 100%;
}
.imggs {
    display: block;
    width: 100%;
    height: 100%;
}
</style>
<div class="swiper-container">
    <div class="swiper-wrapper">
        <?php foreach ($setting['slider_list'] as $item) { ?>
        <div class="swiper-slide">
            <img class="imgg" src="<?=$item['img']?>" alt="">
        </div>
        <?php } ?>
    </div>
    <!-- Add Pagination -->
    <div class="swiper-pagination"></div>
</div>
