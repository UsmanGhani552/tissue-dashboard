
<?php $__env->startSection('content'); ?>
    <div class="tab-content">
        <div class="tab-pane active" id="currentweek" role="tabpanel" aria-labelledby="currentweek-tab">
            <div class="container-fluid current-head">
                <div class="row">
                    <div class="col-md-6 p-0">
                        <h2>Total Records</h2>
                    </div>

                    <div class="col-md-6 text-end">
                        <a id="import-button" class="import-btn btn g-button forms">
                            <span id="button-text">Import</span>
                            <span id="button-spinner" class="spinner-border spinner-border-sm d-none"></span>
                        </a>
                        <a href="<?php echo e(route('personalis_bsm_2.show')); ?>" class="btn g-button">Show</a>
                        <a href="<?php echo e(route('personalis_bsm_2.export')); ?>" class="btn g-button">Export</a>
                        <a href="<?php echo e(route('personalis_bsm_2.delete-all')); ?>" class="btn r-button">Delete All</a>
                    </div>
                </div>
            </div>

            <!-- Status Messages -->
            <div id="status-message" class="mt-3">
                <?php if(session()->has('success')): ?>
                    <div class="alert alert-success">
                        <?php echo e(session()->get('success')); ?>

                    </div>
                <?php endif; ?>
                <?php if(session()->has('error')): ?>
                    <div class="alert alert-danger">
                        <?php echo e(session()->get('error')); ?>

                    </div>
                <?php endif; ?>
            </div>

            <!-- Progress Bar (hidden by default) -->
            <div class="progress mt-3 d-none" id="progress-container">
                <div id="progress-bar" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                    style="width: 0%"></div>
            </div>

            <!-- Results Container (hidden by default) -->
            <div class="mt-3" id="results-container" style="display: none;">
                <div class="alert alert-info">
                    <div id="processed-count" class="mb-2"></div>
                    <div id="remaining-count" class="mb-2"></div>
                </div>
            </div>

            <div class="mainTable">
                <div class="container-fluid">
                    <div class="bottomTable">
                        <table class="table dataTable">
                            <thead class="">
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="overflow-auto">
                                <?php $__currentLoopData = $personalis_bsm_2_sheets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $personalis_bsm_2_sheet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($personalis_bsm_2_sheet->id); ?></td>
                                        <td><?php echo e($personalis_bsm_2_sheet->name); ?></td>
                                        <td>
                                            <div class="dropdown open">
                                                <a class="btn r-button"
                                                    href="<?php echo e(route('personalis_bsm_2.delete', $personalis_bsm_2_sheet->id)); ?>">Delete</a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        $(document).ready(function () {
            const button = $('#import-button');
            const buttonText = $('#button-text');
            const buttonSpinner = $('#button-spinner');
            const statusDiv = $('#status-message');
            const progressContainer = $('#progress-container');
            const progressBar = $('#progress-bar');
            const resultsContainer = $('#results-container');
            const processedCount = $('#processed-count');
            const remainingCount = $('#remaining-count');

            let totalJobs = 0;
            let checkInterval;

            button.click(function (e) {
                e.preventDefault();

                // Reset UI
                button.prop('disabled', true);
                buttonText.text('Processing...');
                buttonSpinner.removeClass('d-none');
                statusDiv.html('<div class="alert alert-info">Preparing import...</div>');
                progressContainer.addClass('d-none');
                resultsContainer.hide();

                // Start the import
                $.ajax({
                    url: '<?php echo e(route("personalis_bsm_2.import")); ?>',
                    method: 'POST',
                    data: {
                        _token: '<?php echo e(csrf_token()); ?>'
                    },
                    success: function (response) {
                        statusDiv.html('<div class="alert alert-success">' + response.message + '</div>');
                        buttonSpinner.addClass('d-none');
                        buttonText.text('import');
                    },
                    error: function (xhr) {
                        buttonSpinner.addClass('d-none');
                        statusDiv.html('<div class="alert alert-danger">Something went wrong</div>');
                    }
                });
            });

            function startQueueProcessing() {
                progressContainer.removeClass('d-none');
                progressBar.css('width', '0%');
                resultsContainer.show();

                // Call repeatedly every few seconds
                checkInterval = setInterval(function () {
                    // $.get('<?php echo e(route("process.queue")); ?>'); // this triggers 1 job per call

                    $.get('<?php echo e(route("queue.status")); ?>', function (response) {
                        const processed = response.processed || 0;
                        const remaining = response.size || 0;
                        const total = response.total || totalJobs;
                        if(totalJobs === 0) {
                            totalJobs = total;
                        }

                        const progressPercent = Math.round((processed / total) * 100);
                        progressBar.css('width', progressPercent + '%');
                        processedCount.html('<strong>Processed:</strong> ' + processed + ' jobs');
                        remainingCount.html('<strong>Remaining:</strong> ' + remaining + ' jobs');

                        if (remaining <= 0) {
                            clearInterval(checkInterval);
                            statusDiv.append('<div class="alert alert-success mt-2">All jobs completed successfully!</div>');
                            button.prop('disabled', false);
                            buttonText.text('Import');
                            buttonSpinner.addClass('d-none');
                            progressBar.removeClass('progress-bar-animated').removeClass('progress-bar-striped')
                                .addClass('bg-success');
                            setTimeout(function () {
                                window.location.reload();
                            }, 3000);
                        }
                    });
                }, 3000); // every 3 seconds
            }

            function checkQueueStatus() {
                clearInterval(checkInterval);

                checkInterval = setInterval(function () {
                    $.get('<?php echo e(route("queue.status")); ?>', function (response) {
                        const processed = response.processed || 0;
                        const remaining = response.size || 0;
                        const total = response.total || totalJobs;

                        // Update progress bar
                        const progressPercent = Math.round((processed / total) * 100);
                        progressBar.css('width', progressPercent + '%');

                        // Update counters
                        processedCount.html('<strong>Processed:</strong> ' + processed + ' jobs');
                        remainingCount.html('<strong>Remaining:</strong> ' + remaining + ' jobs');

                        // Check if completed
                        if (remaining <= 0) {
                            clearInterval(checkInterval);
                            statusDiv.append('<div class="alert alert-success mt-2">All jobs completed successfully!</div>');
                            button.prop('disabled', false);
                            buttonText.text('Import');
                            buttonSpinner.addClass('d-none');
                            progressBar.removeClass('progress-bar-animated').removeClass('progress-bar-striped')
                                .addClass('bg-success');
                            // Reload the page after 3 seconds to show new data
                            setTimeout(function () {
                                window.location.reload();
                            }, 3000);
                        }
                    }).fail(function () {
                        clearInterval(checkInterval);
                        showError('Error checking queue status');
                    });
                }, 2000); // Check every 2 seconds
            }

            function showError(message) {
                clearInterval(checkInterval);
                statusDiv.html('<div class="alert alert-danger">' + message + '</div>');
                button.prop('disabled', false);
                buttonText.text('Import');
                buttonSpinner.addClass('d-none');
            }
        });
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Downloads\laragon\www\tissue-dashboard\resources\views/personalis_bsm2/index.blade.php ENDPATH**/ ?>