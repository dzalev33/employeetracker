<?php require APPROOT . '/views/inc/header.php'; ?>
<a  href="<?php echo URLROOT; ?>/employees" class="btn btn-light"> <i class="fa fa-backward"> Back</i></a>
<br>
<h1><?php echo $data['employee']->name;  ?></h1>

<div class="bg-secondary text-white p-2 mb-3">
   Employee since: <?php echo $data['employee']->created_at;  ?>
</div>


<?php //if ($data['employee']->id == $_SESSION['user_id']) :?>
<?php //endif; ?>

<a class="btn btn-dark" href="<?php echo URLROOT;?>/employees/edit/<?php echo $data['employee']->id;?>">Edit</a>
<form class="pull-right" action="<?php echo URLROOT;?>/employees/delete/<?php echo $data['employee']->id; ?>" method="post">
    <input type="submit" value="Delete" class="btn btn-danger">
</form>
<?php require APPROOT . '/views/inc/footer.php'; ?>
