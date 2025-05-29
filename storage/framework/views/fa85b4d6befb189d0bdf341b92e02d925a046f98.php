  
  <?php $__env->startSection('content'); ?>
      <div class="tab-content">

          <div class="tab-pane active" id="currentweek" role="tabpanel" aria-labelledby="currentweek-tab">
            <div class="container-fluid current-head">
                <div class="row">
                    <div class="col-lg-6">
                        <h2>Rack Ids</h2>
                    </div>
                    <div class="col-lg-6">
                        <a id="" class="btn green" href="<?php echo e(route('recompile.export')); ?>" role="button">Export
                        </a>
                    </div>
                </div>
            </div>
             
              <?php if(session()->has('success')): ?>
                  <div class="alert alert-success">
                      <?php echo e(session()->get('success')); ?>

                  </div>
              <?php endif; ?>
              
              
              <div class="mainTable mt-2">
                  <div class="container-fluid">
                      <div class="bottomTable">
                          <table class="table">
                              <thead class="">
                                  <tr>
                                      <th>Submitter Id</th>
                                      <th>Rack Id</th>
                                      <th>CaseFile Id</th>
                                  </tr>
                              </thead>
                              <tbody class="overflow-auto">
                                  <?php if(count($results) > 0): ?>
                                      <?php $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                          <tr>
                                              <td><?php echo e($result['submitter_id']); ?></td>
                                              <td><?php echo e($result['rack_id']); ?></td>
                                              <td><?php echo e($result['casefile_id']); ?></td>
                                          </tr>
                                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                  <?php else: ?>
                                      <tr>
                                        <td>
                                            No Mismatch Record
                                        </td>
                                      </tr>
                                  <?php endif; ?>
                              </tbody>
                          </table>
                      </div>
                  </div>
              </div>
          </div>

      </div>
  <?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Downloads\laragon\www\tissue-dashboard\resources\views/recompilation/index.blade.php ENDPATH**/ ?>