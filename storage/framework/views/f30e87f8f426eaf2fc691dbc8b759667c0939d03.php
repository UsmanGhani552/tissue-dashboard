<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>C4hcs</title>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/styles.css')); ?>">
    <link rel='stylesheet' href='https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    </head>

<body>
    <!-- off canvas html start -->
    <div class="parent">
        <div class="container-fluid">
            <div class="row">
                
                <?php echo $__env->make('layout.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <div class="col-lg-6 tabSec expand">
                    <header>
                        <nav class="navbar navbar-expand-lg">
                            <div class="container-fluid">
                                <!-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                        </button> -->
                                <div class="headerRow" id="">
                                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                        <button class="btn btn-primary triggerBtn2" type="button">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                <path
                                                    d="M432 48H208c-17.7 0-32 14.3-32 32V96H128V80c0-44.2 35.8-80 80-80H432c44.2 0 80 35.8 80 80V304c0 44.2-35.8 80-80 80H416V336h16c17.7 0 32-14.3 32-32V80c0-17.7-14.3-32-32-32zM48 448c0 8.8 7.2 16 16 16H320c8.8 0 16-7.2 16-16V256H48V448zM64 128H320c35.3 0 64 28.7 64 64V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V192c0-35.3 28.7-64 64-64z" />
                                            </svg>
                                        </button>
                                        <h2>Dashboard</h2>
                                    </ul>
                                    <a href="<?php echo e(route('error-files')); ?>" class="btn btn-danger">Error Files</a>
                                    
                                </div>
                            </div>
                        </nav>
                    </header>
                    <?php echo $__env->yieldContent('content'); ?>

                </div>
            </div>
        </div>
    </div>
    <!-- Tab panes -->
    <!-- off canvas html start -->


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script>
        const toggleButton = document.querySelector('.triggerBtn');
        const toggleButton2 = document.querySelector('.triggerBtn2');
        const tabContent = document.querySelector('.tabSec');
        const sideBar = document.querySelector('.sidebar');

        // Add click event listener to toggle button
        toggleButton.addEventListener('click', () => {
            tabContent.classList.toggle('expand');
            sideBar.classList.toggle('expand');
        });
        toggleButton2.addEventListener('click', () => {
            tabContent.classList.toggle('expand');
            sideBar.classList.toggle('expand');
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#mainTable').DataTable({
                scrollX: true, // Enable horizontal scrolling
                scrollY: '220px',
                scrollCollapse: true,
                ordering: false,
                paging: false, // Enable horizontal scrolling
                // "paging": true, // Enable pagination
                // "pageLength": 4, // Set number of rows per page
                // language: {
                //     paginate: {
                //         previous: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l192 192c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L77.3 256 246.6 86.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-192 192z"/></svg>',
                //         next: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"/></svg>'
                //     }
                // }
            });
        });
        $(document).ready(function() {
            $('.table.dataTable').DataTable({
                scrollY: '250px',
                scrollCollapse: true,
                ordering: false,
                paging: false,
            });
        });
    </script>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>

</html>
<?php /**PATH D:\Downloads\laragon\www\compare\resources\views/layout/master.blade.php ENDPATH**/ ?>