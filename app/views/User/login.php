<?php require_once APPPATH . '/views/inc/header.php'; ?>
<div class="container-fluid">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-12 col-lg-10 col-xl-8">
				<?php if ( !empty($reset) || !empty($error) || !empty($active) || !empty($active_success) ) : ?>
					<div class="card border-0 my-4 p-4">
						<div class="card-body">
							<?php
								if (!empty($reset)){
									echo '<div class="alert alert-success">' . $reset . '</div>';
								}

								if (!empty($active_success)){
									echo '<div class="alert alert-success">' . $active_success . '</div>';
								}

								if (!empty($active)){
									echo '<div class="alert alert-warning">' . $active . '</div>';
								}

								if (!empty($error)){
									echo '<div class="alert alert-danger">';
									
									foreach ($error as $key => $value) {
										echo $value;	
									}
									
									echo '</div>';
								}
							?>
						</div>
					</div>
				<?php endif; ?>
				<div class="card border-0 my-4 p-4">
					<div class="card-header bg-transparent text-center">
						<h3><?php echo $l['login']; ?></h3>
					</div>
					<div class="card-body">
						<form action="<?php echo ROOTPATH; ?>/users/login" method="post">
							<div class="form-group row">
								<label for="email" class="col-sm-4 col-md-3 col-lg-2 text-sm-right"><?php echo $l['email']; ?></label>
								<div class="col-sm-8 col-md-9 col-lg-10">
									<input type="email" id="email" class="form-control text-primary <?php echo (isset($error['email_error'])) ? 'is-invalid' : ''; ?>" name="email" placeholder="Enter Email" autofocus required value="<?php echo $email; ?>">
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
							<div class="form-group row">
								<label class="col-12">
									<input type="checkbox" name="remember" <?php echo ($remember) ? 'checked="checked"' : ''; ?>>
									<?php echo $l['remember_me']; ?>
								</label>
							</div>
							<div class="row">
								<div class="col-12">
									<button type="submit" class="btn btn-primary btn-block" name="login"><?php echo $l['login']; ?></button>
								</div>
							</div>
						</form>
					</div>
					<div class="card-footer bg-transparent row">
						<div class="col-12">
							<a class="btn btn-link" href="<?php echo ROOTPATH; ?>/users/signup">Not yet a uesr? Register here</a>
						</div>
						<div class="col-12">
							<a class="btn btn-link" href="<?php echo ROOTPATH; ?>/users/passwordforget">Forget password?</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php require_once APPPATH . '/views/inc/footer.php'; ?>