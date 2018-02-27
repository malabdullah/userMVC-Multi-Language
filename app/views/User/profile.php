<?php require_once APPPATH . '/views/inc/header.php'; ?>
<div class="container-fluid bg-light">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-10">
				<div class="card border-0 my-4 p-4">
					<div class="card-header bg-transparent">
						<h2><?php echo $user->name; ?></h2>
					</div>
					<div class="card-body bg-transparent">
						<div class="row">
							<div class="col-4 text-right">
								<p><strong>Email</strong></p>
								<p><strong>Last Modified date</strong></p>
							</div>
							<div class="col-8">
							<?php

								echo '<p>' . $user->email . '</p>';
								echo '<p>' . $user->modified_at . '</p>';

							?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php require_once APPPATH . '/views/inc/footer.php'; ?>