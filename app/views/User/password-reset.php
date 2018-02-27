<?php require_once APPPATH . '/views/inc/header.php'; ?>
<div class="container-fluid bg-light">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-10">
				<?php if (!empty($error)) : ?>
					<div class="card border-0 my-4 p-4">
						<div class="card-body">
							<div class="alert alert-danger">
								<ul>
									<?php
										foreach ($error as $key => $value) {
											echo '<li>' . $value . '</li>';
										}
									?>
								</ul>
							</div>
						</div>
					</div>
				<?php endif; ?>
				<div class="card border-0 my-4 p-4">
					<div class="card-header bg-transparent">
						<h3>Reset Password</h3>
					</div>
					<div class="card-body">
						<form action="<?php echo ROOTPATH; ?>/users/passwordreset" method="post">
							<div class="form-group row">
								<label for="new_password" class="col-sm-3 col-md-2 text-sm-right">New Password</label>
								<div class="col-sm-9 col-md-10">
									<input type="password" id="new_password" class="form-control text-primary <?php echo (isset($error['password_error'])) ? 'is-invalid' : ''; ?>" name="new_password" placeholder="Enter New Password" required>
									<div class="invalid-feedback">
										<?php echo (isset($error['password_error'])) ? $error['password_error'] : ''; ?>
									</div>
								</div>
							</div>
							<div class="form-group row">
								<label for="confirm_password" class="col-sm-3 col-md-2 text-sm-right">Re-type Password</label>
								<div class="col-sm-9 col-md-10">
									<input type="password" id="confirm_password" class="form-control text-primary <?php echo (isset($error['password_error'])) ? 'is-invalid' : ''; ?>" name="confirm_password" placeholder="Re-enter Password" required>
									<div class="invalid-feedback">
										<?php echo (isset($error['confirm_password_error'])) ? $error['confirm_password_error'] : ''; ?>
									</div>
								</div>
							</div>
							<input type="hidden" name="token" value="<?php echo (isset($token)) ? $token : 0; ?>">
							<div class="row">
								<div class="col-12">
									<button type="submit" class="btn btn-primary btn-block" name="reset">Submit</button>
								</div>
							</div>
						</form>
					</div>
					<div class="card-footer bg-transparent row">
						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php require_once APPPATH . '/views/inc/footer.php'; ?>