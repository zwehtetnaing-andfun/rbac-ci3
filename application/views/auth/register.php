<div class="container">
	<div class="row">
		<div class="col-md-8 mx-auto mt-2">
			<?php if (validation_errors()): ?>
				<div class="alert alert-danger text-center">
					<?= validation_errors() ?>
				</div>
			<?php endif; ?>
		</div>
		<div class="col-md-6 mx-auto my-5">
			<div class="d-flex justify-content-center align-items-center my-3">
				<h1>Register</h1>
			</div>
			<div class="bg-white card shadow px-3 pt-2">
				<div class="card-body">
					<?= form_open('user/store'); ?> <!-- Form to store article -->

					<div class="form-group mb-4">
						<label for="username" class="mb-2">Username</label>
						<input type="text" name="username" id="username" class="form-control rounded-0 ">
					</div>
					<div class="form-group mb-4">
						<label for="email" class="mb-2">Email</label>
						<input type="text" name="email" id="email" class="form-control rounded-0 ">
					</div>
					<div class="form-group mb-4">
						<label for="password" class="mb-2">Password</label>
						<input type="password" name="password" id="password" class="form-control rounded-0 ">
					</div>
					<div class="float-end">
						<button type="reset" class="btn btn-secondary btn-sm me-2">Cancel</button>
						<button type="submit" class="btn btn-primary btn-sm">Register</button>
					</div>
					</form>
				</div>
				<div class="card-footer text-center">
					<p class="text-muted">Already have an account? <a href="<?= base_url('user/login') ?>">Login</a></p>
				</div>
			</div>

		</div>
	</div>
</div>
