
<?php $__env->startSection('content'); ?>
    <div class="tab-content">


        <div class="tab-pane active" id="currentweek" role="tabpanel" aria-labelledby="currentweek-tab">
            <div class="container-fluid current-head">
                <div class="row">
                    <div class="col-lg-2">
                        <h2>Total Records</h2>
                    </div>
                    <div class="col-lg-10 margin-top" style="margin-top:-20px">
                        <form method="GET" action="<?php echo e(route('personalis_bsm_2.show')); ?>">
                            <div class="row g-3 align-items-end">
                                <div class="col-md-2">
                                    <label for="date" class="form-label">Date</label>
                                    <input type="date" id="date" name="date" class="form-control"
                                        value="<?php echo e(request('date')); ?>">
                                </div>

                                <div class="col-md-2">
                                    <label for="from_date" class="form-label">From</label>
                                    <input type="date" id="from_date" name="from_date" class="form-control"
                                        value="<?php echo e(request('from_date')); ?>">
                                </div>

                                <div class="col-md-2">
                                    <label for="to_date" class="form-label">To</label>
                                    <input type="date" id="to_date" name="to_date" class="form-control"
                                        value="<?php echo e(request('to_date')); ?>">
                                </div>

                                <div class="col-md-2 d-grid">
                                    <label class="form-label invisible">Export</label>
                                    <a href="<?php echo e(route('personalis_bsm_2.export')); ?>" class="btn btn-success">Export</a>
                                </div>

                                <div class="col-md-2 d-grid">
                                    <label class="form-label invisible">Search</label>
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>

                                <div class="col-md-2 d-grid">
                                    <label class="form-label invisible">Back</label>
                                    <a href="<?php echo e(route('personalis_bsm_2')); ?>" class="btn btn-secondary">Back</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="mainTable">
                    <div class="container-fluid">
                        <div class="bottomTable">
                            <table class="table">
                                <thead class="">
                                    <tr>
                                        <th>Submitter Id</th>
                                        <th>Tracking</th>
                                        <th>Ship date</th>
                                        
                                    </tr>
                                </thead>
                                <tbody class="overflow-auto">
                                    <?php $__currentLoopData = $personalisBsm2s; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $personalisBsm2): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($personalisBsm2->submitter_id); ?></td>
                                            <td><?php echo e($personalisBsm2->tracking_id); ?></td>
                                            
                                            <td><?php echo e($personalisBsm2->ship_date); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                            <table class="table">
                                <thead class="">
                                    <tr>
                                        <th>Shipped Percentage</th>
                                    </tr>
                                </thead>
                                <tbody class="overflow-auto">
                                    <tr>
                                        <td>
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-striped bg-success progress-bar-animated"
                                                    role="progressbar" style="width: <?php echo e($shippedPercentage); ?>%;"
                                                    aria-valuenow="250" aria-valuemin="200" aria-valuemax="100">
                                                    <?php echo e(number_format($shippedPercentage, 0)); ?>%</div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                                <?php echo e($personalisBsm2s->links()); ?>

                            </table>
                        </div>
                    </div>
                </div>


            </div>

        </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Downloads\laragon\www\tissue-dashboard\resources\views/personalis_bsm2/show.blade.php ENDPATH**/ ?>