<?php require APPROOT . '/views/inc/header.php'; ?>
<a href="<?php echo URLROOT; ?>/employees" class="btn btn-light"> <i class="fa fa-backward"> Back</i></a>
<div class="row mb-3">
    <div class="col-md-6">
        <h5>You are Logged in as Administrator</h5>
        <h3>Employees Work From Home Requests</h3>
        <?php flash('request_message'); ?>
    </div>
</div>
<?php foreach ($data['requests'] as $request) : ?>
    <div class="card card-body mb-3">
        <div class="bg-light p-2 mb-3">
            <span><b><?php echo $request->name; ?></b> Has request to work from home</span>
        </div>
        <div class="bg-light p-2 mb-3">
            Request status: <span class="badge badge-warning"><?php echo $request->status; ?></span>
        </div>
        <div class="bg-light p-2 mb-3">
            Requested from: <b><?php echo $request->request_from; ?></b> To: <b><?php echo $request->request_to; ?></b>
        </div>
        <div class="bg-light p-2 mb-3">
            <?php echo $request->name; ?> Email: <b> <?php echo $request->email; ?></b>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <form class=" ml-5"
                      action="<?php echo URLROOT; ?>/employees/approveRequest/<?php echo $request->requestId; ?>"
                      method="post">
                    <input type="submit" value="Approve Request" class="btn btn-success">
                </form>
            </div>
            <div class="col-md-4">
                <form class="    ml-5"
                      action="<?php echo URLROOT; ?>/employees/rejectRequest/<?php echo $request->requestId; ?> ?>"
                      method="post">
                    <input type="submit" value="Reject Request" class="btn btn-danger">
                </form>
            </div>
            <div class="col-md-4">
                <form class=" ml-5"
                      action="<?php echo URLROOT; ?>/employees/removeRequest/<?php echo $request->requestId; ?>"
                      method="post">
                    <input type="submit" value="Remove Request" class="btn btn-danger">
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>
<?php require APPROOT . '/views/inc/footer.php'; ?>