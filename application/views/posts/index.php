<div class="container-fluid p-2">
	<div class="col-md-12 d-flex justify-content-end align-items-center gap-4">
		<div>
			<h4 class="text-primary"><span class="text-muted ">Username</span> : <?= $username ?></h4>
		</div>
		<div>
			<a href="<?= base_url('user/logout') ?>" class="btn btn-outline-primary btn-sm">Logout</a>
		</div>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="col-md-12">
		<?php if ($this->session->flashdata('message')): ?>
            <div class="alert alert-warning text-center"><?= $this->session->flashdata('message') ?></div>
        <?php endif; ?>

		</div>
		<div class="col-md-12 my-2 d-flex justify-content-between align-items-center">
			<div class="">
				<h2>Posts</h2>
			</div>

			<div class=""><a href="<?= base_url('post/create') ?>" class="btn btn-primary">Create</a></div>
		</div>

		<?php foreach ($posts as $post): ?>
			<div class="col-md-8 mx-auto card mb-2">
				<div class="card-header">
					<h5><?= $post['title']; ?></h5>
				</div>
				<div class="card-body">
					<p class="text-muted"><?= $post['content']; ?></p>
				</div>
				<div class="card-footer d-flex justify-content-end gap-2">
					<a href="<?= base_url('post/edit') . "/" . $post['id'] ?>" class="btn btn-success btn-sm">Edit</a>
					<a href="<?= base_url('post/delete') . "/" . $post['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</div>
