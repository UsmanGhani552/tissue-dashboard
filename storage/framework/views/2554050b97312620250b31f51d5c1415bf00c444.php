  
  <?php $__env->startSection('content'); ?>
      <div class="tab-content">


          <div class="tab-pane active" id="currentweek" role="tabpanel" aria-labelledby="currentweek-tab">
              <div class="container-fluid current-head">
                  <div class="row">
                      <div class="col-lg-6">
                          <h2>Percentage of matched records</h2>
                      </div>

                      <div class="col-lg-6">
                          <?php echo e($matchedPercentage); ?>%
                      </div>
                  </div>
              </div>
              <?php if(session()->has('success')): ?>
                  <div class="alert alert-success">
                      <?php echo e(session()->get('success')); ?>

                  </div>
              <?php endif; ?>
              <h2>Manifest Table</h2>

              <div class="mainTable">
                  <div class="container-fluid">
                      <div class="bottomTable">
                          <table class="table">
                              <thead class="">
                                  <tr>
                                      
                                      <th>Submitter Id</th>
                                  </tr>
                              </thead>
                              <tbody class="overflow-auto">
                                  <?php if(count($extraRecordsA) > 0): ?>
                                      <?php $__currentLoopData = $extraRecordsA; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $recordsA): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                          <tr>
                                              
                                              <td><?php echo e($recordsA['submitter_id']); ?></td>
                                          </tr>
                                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                  <?php else: ?>
                                      <tr>
                                        <td>No Mismatch Record</td>

                                      </tr>
                                  <?php endif; ?>
                              </tbody>
                          </table>
                      </div>
                  </div>
              </div>
              <h2>Receiving Table</h2>
              <div class="mainTable mt-2">
                  <div class="container-fluid">
                      <div class="bottomTable">
                          <table class="table">
                              <thead class="">
                                  <tr>
                                      
                                      <th>Submitter Id</th>
                                  </tr>
                              </thead>
                              <tbody class="overflow-auto">
                                  <?php if(count($extraRecordsB) > 0): ?>
                                      <?php $__currentLoopData = $extraRecordsB; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $recordsB): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                          <tr>
                                              
                                              <td><?php echo e($recordsB['submitter_id']); ?></td>
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

<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Downloads\laragon\www\tissue-dashboard\resources\views/find-match/index.blade.php ENDPATH**/ ?>