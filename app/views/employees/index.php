
<?php if ($_SESSION['user_type'] == 1) : ?>
    <?php require APPROOT . '/views/inc/header.php'; ?>
    <?php flash('employee_message'); ?>
    <div class="row mb-3">
        <div class="col-md-6">

            <h5>You are Logged in as Administrator</h5>

            <h3>Employees</h3>
        </div>
        <div class="col-md-6">
            <a href="<?php echo URLROOT; ?>/employees/add" class="btn btn-primary pull-right ">
                <i class="fa fa-pencil"> Add Employee</i>
            </a>
            <a href="<?php echo URLROOT; ?>/employees/requests" class="btn btn-primary  ">
                <i class="fa fa-pencil"> Work From Home Requests</i>
            </a>
        </div>
    </div>
    <?php foreach ($data['employees'] as $employee) : ?>
        <div class="card card-body mb-3">
            <div>
                <h4 class="card-title"><?php echo $employee->name; ?></h4>
                <div class="bg-light p-2 mb-3">
                    Employee Email:  <?php echo $employee->email; ?>
                </div>
            </div>
            <a href="<?php echo URLROOT;?>/employees/show/<?php echo $employee->id?>" class="btn btn-dark">Show Employee Details</a>
        </div>
    <?php endforeach; ?>


<?php else: ?>
    <?php require APPROOT . '/views/inc/header.php'; ?>
    <h5>You are Logged in as Employee</h5>
    <?php require APPROOT . '/views/inc/footer.php'; ?>
<?php endif; ?>

