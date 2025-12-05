<?php $__env->startSection('content'); ?>
<div class="container home">
    <section class="hero">
        <div class="swiper heroSwiper" id="heroSwiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide"><img src="<?php echo e(asset('assets/images/slide01.png')); ?>" alt=""></div>
                <div class="swiper-slide"><img src="<?php echo e(asset('assets/images/slide02.png')); ?>" alt=""></div>
                <div class="swiper-slide"><img src="<?php echo e(asset('assets/images/slide03.png')); ?>" alt=""></div>
            </div>
            <div class="swiper-pagination" id="heroPagination"></div>
        </div>
    </section>
    <section class="about">
        <h2><?php echo e($contentDetails->title); ?></h2>
        <?php echo $contentDetails->content; ?>

    </section>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.front-master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/sg-events/resources/views/frontend/landing.blade.php ENDPATH**/ ?>