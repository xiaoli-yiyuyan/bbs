<footer class="copyright"></footer>
<footer class="footer-bar bar-fixed">
    <a href="" class="footer-bar_item<?=($index == 0 ? ' active' : '')?>">
        <i class="icon-svg svg-secret"></i>
        <span>推荐</span>
    </a>
    <a href="" class="footer-bar_item<?=($index == 1 ? ' active': '')?>">
        <i class="icon-svg svg-workset"></i>
        <span>版块</span>
    </a>
    <a href="" class="footer-bar_add footer-bar_item<?=($index == 2 ? ' active': '')?>">
        <i class="icon-svg svg-add"></i>
    </a>
    <a href="" class="footer-bar_item<?=($index == 3 ? ' active': '')?>">
        <i class="icon-svg svg-star"></i>
        <span>动态</span>
    </a>
    <a href="<?=href('/user/index')?>" class="footer-bar_item<?=($index == 3 ? ' active': '')?>">
        <i class="icon-svg svg-user"></i>
        <span>我</span>
    </a>
</footer>