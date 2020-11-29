<?php require APPROOT . '/views/inc/header.php'; ?>
<a href="<?php echo URLROOT;?>/employees" class="btn btn-light"> <i class="fa fa-backward"> Back</i></a>
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card card-body bg-light mt-5">
            <h5>Please enter the dates that you want to work from home</h5>
            <p> Please note that a request must be made at least 4 hours before the end of the previous day</p>
            <form action="<?php echo URLROOT; ?>/employees/addRequest" method="post" class="employeeRequest">
<!--                <input type="text" name="status" value="pending" style="visibility: hidden">-->
                <div class="form-group">
                    <label for="request_from">From: <sup>*</sup></label>
                    <input type="date" name="request_from" class="form-control form-control-lg <?php echo (!empty($data['request_from_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['request_from']; ?>">
                    <span class="invalid-feedback"><?php echo $data['request_from_err']; ?></span>
                </div>
                <div class="form-group">
                    <label for="request_to">To: <sup>*</sup></label>
                    <input type="date" name="request_to" class="form-control form-control-lg <?php echo (!empty($data['request_to_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['request_to']; ?>">
                    <span class="invalid-feedback"><?php echo $data['request_to_err']; ?></span>
                </div>
                <input type="submit" value="Request Work From Home" class="btn btn-dark">
            </form>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>