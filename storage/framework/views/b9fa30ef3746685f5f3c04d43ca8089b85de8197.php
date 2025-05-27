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
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                        <g clip-path="url(#clip0_31_58)">
                                            <path d="M10.6667 8.6665C10.3563 9.08049 9.95364 9.4165 9.49079 9.64793C9.02794 9.87935 8.51757 9.99984 8.00008 9.99984C7.4826 9.99984 6.97222 9.87935 6.50937 9.64793C6.04652 9.4165 5.64391 9.08049 5.33342 8.6665C5.0721 9.01875 4.74327 9.31544 4.3661 9.53928C3.98893 9.76312 3.57097 9.90962 3.13659 9.97025C2.70221 10.0309 2.26011 10.0044 1.83607 9.8924C1.41202 9.78039 1.01452 9.58507 0.666748 9.31784V12.6665C0.667807 13.5502 1.01934 14.3975 1.64423 15.0224C2.26912 15.6473 3.11635 15.9988 4.00008 15.9998H12.0001C12.8838 15.9988 13.731 15.6473 14.3559 15.0224C14.9808 14.3975 15.3324 13.5502 15.3334 12.6665V9.31584C14.9858 9.58317 14.5884 9.77863 14.1644 9.89079C13.7404 10.003 13.2984 10.0296 12.864 9.96916C12.4296 9.90872 12.0116 9.76241 11.6344 9.53876C11.2572 9.31511 10.9282 9.0186 10.6667 8.6665Z" fill="#42526E" fill-opacity="0.5" />
                                            <path d="M14.4667 2.08738C14.3377 1.49344 14.0084 0.961912 13.5341 0.581886C13.0598 0.201859 12.4692 -0.00356479 11.8614 4.68218e-05H11.3334V2.00005C11.3334 2.17686 11.2632 2.34643 11.1382 2.47145C11.0131 2.59648 10.8436 2.66671 10.6667 2.66671C10.4899 2.66671 10.3204 2.59648 10.1953 2.47145C10.0703 2.34643 10.0001 2.17686 10.0001 2.00005V4.68218e-05H6.00008V2.00005C6.00008 2.17686 5.92984 2.34643 5.80482 2.47145C5.67979 2.59648 5.51023 2.66671 5.33342 2.66671C5.1566 2.66671 4.98703 2.59648 4.86201 2.47145C4.73699 2.34643 4.66675 2.17686 4.66675 2.00005V4.68218e-05H4.13875C3.53087 -0.00353217 2.94025 0.201987 2.4659 0.582145C1.99155 0.962303 1.66232 1.49399 1.53341 2.08805L0.681415 5.93338L0.666748 6.68005C0.667624 6.94269 0.720222 7.20259 0.82154 7.44491C0.922858 7.68722 1.07091 7.90721 1.25725 8.09231C1.63357 8.46613 2.14298 8.67515 2.67341 8.67338C2.93606 8.67251 3.19596 8.61991 3.43827 8.51859C3.68059 8.41727 3.90058 8.26922 4.08568 8.08288C4.27077 7.89654 4.41736 7.67557 4.51706 7.43259C4.61676 7.1896 4.66762 6.92936 4.66675 6.66671C4.66675 6.4899 4.73699 6.32033 4.86201 6.19531C4.98703 6.07029 5.1566 6.00005 5.33342 6.00005C5.51023 6.00005 5.67979 6.07029 5.80482 6.19531C5.92984 6.32033 6.00008 6.4899 6.00008 6.66671C6.00008 7.19715 6.21079 7.70585 6.58587 8.08093C6.96094 8.456 7.46965 8.66671 8.00008 8.66671C8.53051 8.66671 9.03922 8.456 9.4143 8.08093C9.78937 7.70585 10.0001 7.19715 10.0001 6.66671C10.0001 6.4899 10.0703 6.32033 10.1953 6.19531C10.3204 6.07029 10.4899 6.00005 10.6667 6.00005C10.8436 6.00005 11.0131 6.07029 11.1382 6.19531C11.2632 6.32033 11.3334 6.4899 11.3334 6.66671C11.3334 7.19715 11.5441 7.70585 11.9192 8.08093C12.2943 8.456 12.803 8.66671 13.3334 8.66671C13.8638 8.66671 14.3726 8.456 14.7476 8.08093C15.1227 7.70585 15.3334 7.19715 15.3334 6.66671V6.07138L14.4667 2.08738Z" fill="#42526E" fill-opacity="0.5" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_31_58">
                                                <rect width="16" height="16" fill="white" />
                                            </clipPath>
                                        </defs>
                                    </svg>
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
<?php /**PATH /home/u749698746/domains/koderspedia.net/public_html/tissue-dashboard/resources/views/layout/sidebar.blade.php ENDPATH**/ ?>