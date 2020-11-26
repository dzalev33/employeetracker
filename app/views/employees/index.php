<?php require APPROOT . '/views/inc/header.php'; ?>
<?php flash('employee_message'); ?>
<div class="row mb-3">
    <div class="col-md-6">
        <h1>Employees</h1>
    </div>
    <div class="col-md-6">
        <a href="<?php echo URLROOT; ?>/employees/add" class="btn btn-primary pull-right">
            <i class="fa fa-pencil">Add Employee</i>
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
<?php require APPROOT . '/views/inc/footer.php'; ?>
