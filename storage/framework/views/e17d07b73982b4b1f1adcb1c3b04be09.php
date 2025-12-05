<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="<?php echo e(asset('css/style.css?v=3.0')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/responsive.css?v=2.0')); ?>">
    <link rel="icon" type="image/x-icon" href="<?php echo e(asset('assets/images/favicon.png')); ?>">
    <title><?php echo e(config('app.name')); ?></title>
</head>
<body>
    <div class="wrapper">
        <!-- start the header -->
        <header class="login_header">
            <div class="site_logo">
                <a href="<?php echo e(route('landing')); ?>"><img src="<?php echo e(asset('assets/images/logo.png')); ?>" alt="<?php echo e(config('app.name')); ?>"></a>
            </div>
            <nav class="nav">
                <ul>
                    <?php
                    $ambassadorProgramInfo = getActivePrograms('ambassador');
                    $lifestyleProgramInfo = getActivePrograms('lifestyle');
                    $rechargeupdateProgramInfo = getActivePrograms('rechargeupdate');
                    ?>

                    <!-- code to display navigation for the Ambassador program -->
                    <?php if(isset($ambassadorProgramInfo)): ?>
                        <li>
                            <a href="<?php echo e(route('register-for-program', $ambassadorProgramInfo->alias)); ?>"><?php echo e($ambassadorProgramInfo->button_text?$ambassadorProgramInfo->button_text:'Ambassador Program'); ?></a>
                        </li>
                    <?php else: ?>
                        <li>
                            <a href="javascript:void(0)" onclick="alert('Current Registrations for the Program are discontinued. Please check back with us next month.'); return false;">Ambassador Program</a>
                        </li>
                    <?php endif; ?>
                    <div class="separator"></div>

                    <!-- code to display navigation for the LifeStyle program -->
                    <?php if(isset($lifestyleProgramInfo)): ?>
                        <li>
                            <a href="<?php echo e(route('register-lifestyle-program', $lifestyleProgramInfo->alias)); ?>"><?php echo e($lifestyleProgramInfo->button_text?$lifestyleProgramInfo->button_text:'Life Style Program'); ?></a>
                        </li>
                    <?php else: ?>
                        <li>
                            <a href="javascript:void(0)" onclick="alert('Current Registrations for the Program are discontinued. Please check back with us next month.'); return false;">Life Style Day</a>
                        </li>
                    <?php endif; ?>
                    <div class="separator"></div>
                     <!-- code to display navigation for the LifeStyle program -->
                    <?php if(isset($rechargeupdateProgramInfo)): ?>
                        <li>
                            <a href="<?php echo e(route('recharge-update-program', $rechargeupdateProgramInfo->alias)); ?>"><?php echo e($rechargeupdateProgramInfo->button_text?$rechargeupdateProgramInfo->button_text:'Recharge Update'); ?></a>
                        </li>
                    <?php else: ?>
                        <li>
                            <a href="javascript:void(0)" onclick="alert('Current Registrations for the Program are discontinued. Please check back with us next month.'); return false;">Recharge Update</a>
                        </li>
                    <?php endif; ?>
                    <div class="separator"></div>
                    <li><a href="<?php echo e(route('registration')); ?>" >LCU 7.0</a></li>
                </ul>
            </nav>
        </header>

        <div class="wrapper">
            <?php echo $__env->yieldContent('content'); ?>
        </div>

        <!-- start the footer -->
        <footer class="footer">
            <div class="foot_item">
               <p><a href="<?php echo e(route('privacy-policy')); ?>">Privacy Policy </a> &nbsp&nbsp&nbsp&nbsp&nbsp <a href="<?php echo e(route('term-condition')); ?>">Terms & Conditions </a></p>
            </div>
            <div class="foot_item">
                <p>Copyright <?php echo e(config('app.name')); ?> <?php echo e(date('Y')); ?></p>
            </div>
        </footer>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
    var swiper = new Swiper("#heroSwiper", {
        autoplay: true,
        pagination: {
        el: "#heroPagination",
        },
    });
    </script>
</body>
</html>
<?php /**PATH /var/www/html/sg-events/resources/views/layouts/front-master.blade.php ENDPATH**/ ?>