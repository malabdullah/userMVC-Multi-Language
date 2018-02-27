<?php require_once APPPATH . '/views/inc/header.php'; ?>
<div class="container-fluid">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-12 col-lg-10 col-xl-8">
				<?php if (!empty($error['db_error'])) : ?>
					<div class="card border-0 my-4 p-4">
						<div class="card-body">
							<ul>
								<?php
									echo '<div class="alert alert-danger">' . $error['db_error'] . '</div>';
								?>
							</ul>
						</div>
					</div>
				<?php endif; ?>
				<div class="card border-0 my-4 p-4">
					<div class="card-header bg-transparent text-center">
						<h3><?php echo $l['signup']; ?></h3>
					</div>
					<div class="card-body">
						<form action="<?php echo ROOTPATH; ?>/users/signup" method="post">
							<div class="form-group row">
								<label for="name" class="col-sm-4 col-md-3 col-lg-2 text-sm-right"><?php echo $l['name']; ?></label>
								<div class="col-sm-8 col-md-9 col-lg-10">
									<input type="text" id="name" class="form-control text-primary <?php echo (isset($error['name_error'])) ? 'is-invalid' : ''; ?>" name="name" placeholder="Enter Name" required autofocus="true" value="<?php echo $name; ?>">
									<div class="invalid-feedback">
										<?php echo (isset($error['name_error'])) ? $error['name_error'] : ''; ?>
									</div>
								</div>
							</div>
							<div class="form-group row">
								<label for="email" class="col-sm-4 col-md-3 col-lg-2 text-sm-right"><?php echo $l['email']; ?></label>
								<div class="col-sm-8 col-md-9 col-lg-10">
									<input type="email" id="email" class="form-control text-primary <?php echo (isset($error['email_error'])) ? 'is-invalid' : ''; ?>" name="email" placeholder="Enter Email" required value="<?php echo $email; ?>">
									<div class="invalid-feedback">
										<?php echo (isset($error['email_error'])) ? $error['email_error'] : ''; ?>
									</div>
								</div>
							</div>
							<div class="form-group row">
								<label for="password" class="col-sm-4 col-md-3 col-lg-2 text-sm-right"><?php echo $l['password']; ?></label>
								<div class="col-sm-8 col-md-9 col-lg-10">
									<input type="password" id="password" class="form-control text-primary <?php echo (isset($error['password_error'])) ? 'is-invalid' : ''; ?>" name="password" placeholder="Enter Password" required>
									<div class="invalid-feedback">
										<?php echo (isset($error['password_error'])) ? $error['password_error'] : ''; ?>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-12">
									<button type="submit" class="btn btn-primary btn-block" name="signup"><?php echo $l['signup']; ?></button>
								</div>
							</div>
						</form>
					</div>
					<div class="card-footer bg-transparent row">
						<div class="col-12 text-center text-lg-left">
							<a class="btn btn-link" href="<?php echo ROOTPATH . '/users/login'; ?>">Already have an account? Login here</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php require_once APPPATH . '/views/inc/footer.php'; ?>