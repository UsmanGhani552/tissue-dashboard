<div class="col-lg-6">
    <div class="sidebar" data-bs-scroll="true" tabindex="-1" id="Id1" aria-labelledby="Enable both scrolling & backdrop">
        <div class="sidebar-body">
            <div class="logoDiv">
                <div class="logo">
                    <img src="<?php echo e(asset('assets/images/Natera_logo.png')); ?>" alt="hello">
                </div>
                <button class="btn btn-primary triggerBtn navbar-toggler" type="button">
                    <span class="navbar-toggler-icon">
                        <svg class="expand" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                            <path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z" />
                        </svg>
                        <svg class="hidden" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                            <path d="M438.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-160-160c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L338.8 224 32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l306.7 0L233.4 393.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l160-160z" />
                        </svg>
                        
                        
                    </span>
                </button>
            </div>
            <div class="offcanvasnav">
                <div class="nav-buttons">
                    <!-- <a class="btn btn-primary" href="#" role="button">Button</a> -->
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        
                        <li class="nav-item" role="presentation">
                            <button class="nav-link
                                <?php echo e(request()->routeIs('receiving.index') ? 'active' : ''); ?>

                                <?php echo e(request()->routeIs('receiving-show') ? 'active' : ''); ?>

                                
                                " id="settings-tab">
                                <a href="<?php echo e(route('receiving.index')); ?>">
                                    
                                    <img src="<?php echo e(asset('assets/images/icon/received-samples.svg')); ?>" alt="">
                                    Received Samples
                                </a>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link
                                <?php echo e(request()->routeIs('manifest.index') ? 'active' : ''); ?>

                                <?php echo e(request()->routeIs('manifest-show') ? 'active' : ''); ?>

                                
                                " id="settings-tab">
                                <a href="<?php echo e(route('manifest.index')); ?>">
                                    
                                    <img src="<?php echo e(asset('assets/images/icon/manifest.svg')); ?>" alt="">
                                    Received Manifest
                                </a>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link
                                <?php echo e(request()->routeIs('find-match') ? 'active' : ''); ?>

                                
                                " id="settings-tab">
                                <a href="<?php echo e(route('find-match')); ?>">
                                    
                                    <img src="<?php echo e(asset('assets/images/icon/reconcile.svg')); ?>" alt="">
                                    Reconcile
                                </a>
                            </button>
                        </li>
                        
                        <li class="nav-item" role="presentation">
                            <button class="nav-link
                                <?php echo e(request()->routeIs('sheet1.index') ? 'active' : ''); ?>

                                <?php echo e(request()->routeIs('sheet1-show') ? 'active' : ''); ?>

                                
                                " id="settings-tab">
                                <a href="<?php echo e(route('sheet1.index')); ?>">
                                    
                                    <img src="<?php echo e(asset('assets/images/icon/receiving.svg')); ?>" alt="">
                                    Receiving 1
                                </a>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link
                                <?php echo e(request()->routeIs('sheet2.index') ? 'active' : ''); ?>

                                <?php echo e(request()->routeIs('sheet2-show') ? 'active' : ''); ?>

                                
                                " id="settings-tab">
                                <a href="<?php echo e(route('sheet2.index')); ?>">
                                    
                                    <img src="<?php echo e(asset('assets/images/icon/archive-samples.svg')); ?>" alt="">
                                    Archive Samples
                                </a>
                            </button>
                        </li>
                        
                        <li class="nav-item" role="presentation">
                            <button class="nav-link
                                <?php echo e(request()->routeIs('recompile') ? 'active' : ''); ?>

                                
                                " id="settings-tab">
                                <a href="<?php echo e(route('recompile')); ?>">
                                    
                                    <img src="<?php echo e(asset('assets/images/icon/consolidate.svg')); ?>" alt="">
                                    Consolidate
                                </a>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link
                                <?php echo e(request()->routeIs('personlis_bsm') ? 'active' : ''); ?>

                                
                                " id="settings-tab">
                                <a href="<?php echo e(route('personalis_bsm')); ?>">
                                    
                                    <img src="<?php echo e(asset('assets/images/icon/productivity.svg')); ?>" alt="">
                                    Productivity
                                </a>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link
                                <?php echo e(request()->routeIs('personalis_bsm_2') ? 'active' : ''); ?>

                                
                                " id="settings-tab">
                                <a href="<?php echo e(route('personalis_bsm_2')); ?>">
                                    <img src="<?php echo e(asset('assets/images/icon/tracking.svg')); ?>" alt="">
                                    Tracking
                                </a>
                            </button>
                        </li>
                        
                    </ul>
                </div>
            </div>
            <div class="profile-dropdown dropdown-center">
                <div class="dropup open">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="triggerId" data-bs-toggle="dropdown">
                        <div class="row">
                            <div class="col-4">
                                <img src="assets/images/blank.png" alt="">
                            </div>
                            <div class="col-8">
                                <h4>Natera</h4>
                                <p>Admin</p>
                            </div>
                        </div>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="triggerId">
                        <a class="dropdown-item" href="<?php echo e(route('logout')); ?>">LogOut</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<?php /**PATH D:\Downloads\laragon\www\tissue-dashboard\resources\views/layout/sidebar.blade.php ENDPATH**/ ?>