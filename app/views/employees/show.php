<?php require APPROOT . '/views/inc/header.php'; ?>
<?php if ($_SESSION['user_type'] == 1) : ?>
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
            </div>
            <div class="col-md-6 p-2 mb-3">
                <div class="card pull-right" style="width: 20rem;">
                    <div class="card-header">
                        Licences
                    </div>
                    <form class="pull-right" action="<?php echo URLROOT; ?>/employees/licences " method="post">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><input type="checkbox" name="licences[]"
                                                               value="Microsoft Office License"> Microsoft Office
                                License
                            </li>
                            <li class="list-group-item"><input type="checkbox" name="licences[]"
                                                               value="Microsoft Office License"> Email Access Granted
                            </li>
                            <li class="list-group-item"><input type="checkbox" name="licences[]"
                                                               value="Microsoft Office License"> Git Repository Granted
                            </li>
                            <li class="list-group-item"><input type="checkbox" name="licences[]"
                                                               value="Microsoft Office License"> Jira Access Granted
                            </li>
                        </ul>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php flash('request_message'); ?>
    <div class="bg-secondary text-white p-2 mb-3 mt-3">
        Employee since: <?php echo $data['employee']->created_at; ?>
    </div>
<?php else: ?>
    <div class="card card-body mb-3">
        <h4 class="card-title"><?php echo $data['employee']->name; ?></h4>
        <div class="row mb-3 mt-3">
            <div class="col-md-6  p-2 mb-3">
                <?php flash('request_message'); ?>
                <?php flash('email_message'); ?>
                <div class="col-md-6 p-2 mb-3">
                    <div class="card " style="width: 35rem;">
                        <div class="card-header">
                            Work from home Requests
                            <a href="<?php echo URLROOT; ?>/employees/addRequest" class="btn btn-primary pull-right ">
                                <i class="fa fa-pencil"> Make a Request to Work From Home </i>
                            </a>
                        </div>
                        <table class="table">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">From</th>
                                <th scope="col">To</th>
                                <th scope="col">Status</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($data['requests'] as $key => $groups) : ?>
                                <?php if ($groups->user_id != $_SESSION['user_id']) : ?>
                                <?php else: ?>
                                    <tr>
                                        <th scope="row"></th>
                                        <td><?php echo $groups->request_from; ?></td>
                                        <td><?php echo $groups->request_to; ?></td>
                                        <td><?php echo $groups->status; ?></td>
                                        <td>
                                            <form class="pull-right ml-5 pt-3"
                                                  action="<?php echo URLROOT; ?>/employees/cancelRequest/<?php echo $groups->requestId; ?>"
                                                  method="post">
                                                <input type="submit" value="Cancel Request" class="btn btn-danger">
                                            </form>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6 p-2 mb-3">
                <div class="card pull-right" style="width: 20rem;">
                    <div class="card-header">
                        Licences
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
<?php endif; ?>
<?php require APPROOT . '/views/inc/footer.php'; ?>