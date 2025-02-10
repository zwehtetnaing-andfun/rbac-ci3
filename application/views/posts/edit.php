<div class="row">
	<div class="col-md-8 mx-auto mt-2">
		<?php if (validation_errors()): ?>
			<div class="alert alert-danger text-center">
				<?= validation_errors() ?>
			</div>
		<?php endif; ?>
	</div>
	<div class="col-md-8 card shadow mx-auto mt-2">
		<div class="card-header">
			<h5>Edit post</h5>
		</div>
		<div class="card-body">
			<?= form_open('post/update/'.$post['id']); ?>
			<div class="form-group mb-2">
				<label for="title">Title</label>
				<input type="input" name="title" class="form-control form-control-sm" value="<?= $post['title'] ?? '' ?>">
			</div>

			<div class="form-group mb-2">
				<label for="content">Content</label>
				<textarea name="content" class="form-control form-control-sm"><?= $post['content'] ?? '' ?></textarea>
			</div>

			<div class="float-end">
				<a href="<?= base_url('post') ?>" class="btn btn-secondary">cancel</a>
				<button type="submit" class="btn btn-primary">Submit</button>
			</div>
			</form>
		</div>
	</div>
</div>
