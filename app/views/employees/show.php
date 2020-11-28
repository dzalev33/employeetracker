<?php if ($_SESSION['user_type'] == 1) : ?>
    <?php require APPROOT . '/views/inc/header.php'; ?>
    <a href="<?php echo URLROOT; ?>/employees" class="btn btn-light"> <i class="fa fa-backward"> Back</i></a>
    <br>


    <div class="row mb-3 mt-3">

        <div class="col-md-6">
            <h1>Employee Board</h1>

        </div>
        <div class="col-md-6">
            <a class="btn btn-dark pull-right ml-3"
               href="<?php echo URLROOT; ?>/employees/edit/<?php echo $data['employee']->id; ?>"> Edit User </a>
            <form class="pull-right"
                  action="<?php echo URLROOT; ?>/employees/delete/<?php echo $data['employee']->id; ?>"
                  method="post">
                <input type="submit" value="Delete User" class="btn btn-danger">
            </form>
        </div>
    </div>
    <div class="card card-body mb-3">
        <h4 class="card-title"><?php echo $data['employee']->name; ?></h4>
        <div class="row mb-3 mt-3">
            <div class="col-md-6 bg-light p-2 mb-3">
                Email: <span><?php echo $data['employee']->email; ?></span>
                <?php foreach ($data['requests'] as $request) : ?>
                    <div class="bg-light p-2 mb-3">
                        Work from home Request status: <h5><?php echo $request->status; ?></h5>
                        From <span class="card-title"><?php echo $request->request_from; ?></span><br>
                        To: <span><h4 class="card-title"><?php echo $request->request_to; ?></h4></span>
                    </div>

                <?php endforeach; ?>
            </div>
            <div class="col-md-6 p-2 mb-3">
                <div class="card pull-right" style="width: 20rem;">
                    <div class="card-header">
                        Licence
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Microsoft Office License</li>
                        <li class="list-group-item">Email Access Granted</li>
                        <li class="list-group-item">Git Repository Granted</li>
                        <li class="list-group-item">Jira Access Granted</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <?php flash('request_message'); ?>

    <div class="bg-secondary text-white p-2 mb-3 mt-3">
        Employee since: <?php echo $data['employee']->created_at; ?>
    </div>
    <?php require APPROOT . '/views/inc/footer.php'; ?>
<?php else: ?>
    <?php redirect('employees'); ?>
<?php endif; ?>