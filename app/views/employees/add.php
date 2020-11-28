<?php if ($_SESSION['user_type'] == 1) : ?>
    <?php require APPROOT . '/views/inc/header.php'; ?>
    <a  href="<?php echo URLROOT; ?>/employees" class="btn btn-light"> <i class="fa fa-backward"> Back</i></a>
    <div class="card card-body bg-light mt-5">

        <h2>Add new Employee</h2>
        <p>Create a new Employee account in our system</p>
        <form action="<?php echo URLROOT; ?>/employees/add" method="post">

            <div class="form-group">
                <label for="name">Name: <sup>*</sup></label>
                <input type="text" name="name" class="form-control form-control-lg <?php echo (!empty($data['name_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['name']; ?>">
                <span class="invalid-feedback"><?php echo $data['name_err']; ?></span>
            </div>
            <div class="form-group">
                <label for="email">Email: <sup>*</sup></label>
                <input type="email" name="email" class="form-control form-control-lg <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['email']; ?>">
                <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
            </div>
            <div class="form-group">
                <label for="password">Password: <sup>*</sup></label>
                <input type="password" name="password" class="form-control form-control-lg <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['password']; ?>">
                <span class="invalid-feedback"><?php echo $data['password_err']; ?></span>
            </div>
            <input type="submit" value="Add new Employee" class="btn btn-success">
        </form>
    </div>
    <?php require APPROOT . '/views/inc/footer.php'; ?>
<?php else: ?>
    <?php redirect('employees'); ?>
<?php endif; ?>
