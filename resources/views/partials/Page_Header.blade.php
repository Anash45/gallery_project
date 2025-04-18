<section class="page-header mt-0">

    <div class="page-header__shape-3 float-bob-y">
        <img src="<?php echo asset('assets/images/shapes/page-header-shape-3.png'); ?>" alt="">
    </div>
    <div class="container">
        <div class="page-header__inner">
            <ul class="thm-breadcrumb list-unstyled">
                <li><a href="<?php echo url('index.php'); ?>"><?php echo $Title; ?></a></li>
                <li><span class="fa fa-angle-right"></span></li>
                <li><?php echo $Title2; ?></li>
            </ul>
            @if ($SubTitle != null)
                <h2><?php echo $SubTitle; ?></h2>
            @endif
        </div>
    </div>
</section>
