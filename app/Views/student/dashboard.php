<?= $this->extend('student/template') ?>
<?= $this->section('content') ?>
<div class="row match-height">
	<!-- Greetings Card starts -->
	<div class="col-12">
		<div class="card card-congratulations">
			<div class="card-body text-center">
				<img src="<?= base_url('app-assets/images/elements/decore-left.png') ?>" class="congratulations-img-left d-none d-md-block" alt="card-img-left" />
				<img src="<?= base_url('app-assets/images/elements/decore-right.png') ?>" class="congratulations-img-right d-none d-md-block" alt="card-img-right" />
				<div class="text-center">
					<h1 class="mb-1 text-white">Selamat Datang <?= session()->fullname ?>,</h1>
					<p class="card-text m-auto w-75">
						<strong>SEKOLAHKU</strong> - Aplikasi Sekolah eLearning.
					</p>
				</div>
			</div>
		</div>
	</div>
	<!-- Greetings Card ends -->

	<div class="col-12"></div>

	<div class="col-xl-2 col-6">
		<div class="card text-center">
			<div class="card-body">
				<div class="avatar bg-light-success p-50 mb-1">
					<div class="avatar-content">
						<i data-feather="file-text" class="font-medium-5"></i>
					</div>
				</div>
				<h2 class="font-weight-bolder"><?= $statistic->total_assignment_completed ?></h2>
				<p class="card-text">Tugas Selesai</p>
			</div>
		</div>
	</div>
	<div class="col-xl-2 col-6">
		<div class="card text-center">
			<div class="card-body">
				<div class="avatar bg-light-warning p-50 mb-1">
					<div class="avatar-content">
						<i data-feather="message-circle" class="font-medium-5"></i>
					</div>
				</div>
				<h2 class="font-weight-bolder"><?= $statistic->total_quiz_completed ?></h2>
				<p class="card-text">Quiz Selesai</p>
			</div>
		</div>
	</div>
	
	<div class="col-xl-8 col-12">
		<div class="card card-statistics">
			<div class="card-header">
				<h4 class="card-title">Statistik</h4>
			</div>
			<div class="card-body statistics-body">
				<div class="row">
					<div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-0">
						<div class="media">
							<div class="avatar bg-light-primary mr-2">
								<div class="avatar-content">
									<i class="avatar-icon" data-feather="file-text"></i>
								</div>
							</div>
							<div class="media-body my-auto">
								<h4 class="font-weight-bolder mb-0"><?= $statistic->total_assignment ?></h4>
								<p class="card-text font-small-3 mb-0">Tugas</p>
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-0">
						<div class="media">
							<div class="avatar bg-light-info mr-2">
								<div class="avatar-content">
									<i class="avatar-icon" data-feather="message-circle"></i>
								</div>
							</div>
							<div class="media-body my-auto">
								<h4 class="font-weight-bolder mb-0"><?= $statistic->total_quiz ?></h4>
								<p class="card-text font-small-3 mb-0">Quiz</p>
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-sm-6 col-12 mb-2 mb-sm-0">
						<div class="media">
							<div class="avatar bg-light-danger mr-2">
								<div class="avatar-content">
									<i class="avatar-icon" data-feather="book"></i>
								</div>
							</div>
							<div class="media-body my-auto">
								<h4 class="font-weight-bolder mb-0"><?= $statistic->total_material ?></h4>
								<p class="card-text font-small-3 mb-0">Materi</p>
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-sm-6 col-12">
						<div class="media">
							<div class="avatar bg-light-success mr-2">
								<div class="avatar-content">
									<i class="avatar-icon" data-feather="info"></i>
								</div>
							</div>
							<div class="media-body my-auto">
								<h4 class="font-weight-bolder mb-0"><?= $statistic->total_announcement ?></h4>
								<p class="card-text font-small-3 mb-0">Pengumuman</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?= $this->endSection() ?>