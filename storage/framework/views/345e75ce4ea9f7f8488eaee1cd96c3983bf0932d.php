
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
                        <div class="row align-items-end">
                            <div class="col">
                                <label for="">Date</label>
                                <input type="date" name="date" class="form-control" placeholder="Search By Date" value="<?php echo e(request('date')); ?>">
                            </div>
                            <div class="col">
                                <label for="">From</label>
                                <input type="date" name="from_date" class="form-control" placeholder="Search By Date" value="<?php echo e(request('from_date')); ?>">
                            </div>
                            <div class="col">
                                <label for="">To</label>
                                <input type="date" name="to_date" class="form-control" placeholder="Search By Date" value="<?php echo e(request('to_date')); ?>">
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-primary w-100">Search</button>
                            </div>
                            <div class="col">
                                <div>
                                    <a href="<?php echo e(route('personalis_bsm_2')); ?>" class="btn btn-primary  w-100">Back</a>
                                </div>
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
                                            <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" style="width: <?php echo e($shippedPercentage); ?>%;" aria-valuenow="250" aria-valuemin="200" aria-valuemax="100"><?php echo e(number_format($shippedPercentage,0)); ?>%</div>
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