<?= $this->extend('template') ?>
<?= $this->section('content') ?>
<div class="row match-height">
	<!-- Greetings Card starts -->
	<div class="col-lg-6 col-md-12 col-sm-12">
		<div class="card card-congratulations">
			<div class="card-body text-center">
				<img src="<?= base_url('app-assets/images/elements/decore-left.png') ?>" class="congratulations-img-left" alt="card-img-left" />
				<img src="<?= base_url('app-assets/images/elements/decore-right.png') ?>" class="congratulations-img-right" alt="card-img-right" />
				<div class="avatar avatar-xl bg-primary shadow">
					<div class="avatar-content">
						<i data-feather="award" class="font-large-1"></i>
					</div>
				</div>
				<div class="text-center">
					<h1 class="mb-1 text-white">Congratulations John,</h1>
					<p class="card-text m-auto w-75">
						You have done <strong>57.6%</strong> more sales today. Check your new badge in your profile.
					</p>
				</div>
			</div>
		</div>
	</div>
	<!-- Greetings Card ends -->

	<!-- Subscribers Chart Card starts -->
	<div class="col-lg-3 col-sm-6 col-12">
		<div class="card">
			<div class="card-header flex-column align-items-start pb-0">
				<div class="avatar bg-light-primary p-50 m-0">
					<div class="avatar-content">
						<i data-feather="users" class="font-medium-5"></i>
					</div>
				</div>
				<h2 class="font-weight-bolder mt-1">92.6k</h2>
				<p class="card-text">Subscribers Gained</p>
			</div>
			<div id="gained-chart"></div>
		</div>
	</div>
	<!-- Subscribers Chart Card ends -->

	<!-- Orders Chart Card starts -->
	<div class="col-lg-3 col-sm-6 col-12">
		<div class="card">
			<div class="card-header flex-column align-items-start pb-0">
				<div class="avatar bg-light-warning p-50 m-0">
					<div class="avatar-content">
						<i data-feather="package" class="font-medium-5"></i>
					</div>
				</div>
				<h2 class="font-weight-bolder mt-1">38.4K</h2>
				<p class="card-text">Orders Received</p>
			</div>
			<div id="order-chart"></div>
		</div>
	</div>
	<!-- Orders Chart Card ends -->
</div>

<div class="row match-height">
	<!-- Avg Sessions Chart Card starts -->
	<div class="col-lg-6 col-12">
		<div class="card">
			<div class="card-body">
				<div class="row pb-50">
					<div class="col-sm-6 col-12 d-flex justify-content-between flex-column order-sm-1 order-2 mt-1 mt-sm-0">
						<div class="mb-1 mb-sm-0">
							<h2 class="font-weight-bolder mb-25">2.7K</h2>
							<p class="card-text font-weight-bold mb-2">Avg Sessions</p>
							<div class="font-medium-2">
								<span class="text-success mr-25">+5.2%</span>
								<span>vs last 7 days</span>
							</div>
						</div>
						<button type="button" class="btn btn-primary">View Details</button>
					</div>
					<div class="col-sm-6 col-12 d-flex justify-content-between flex-column text-right order-sm-2 order-1">
						<div class="dropdown chart-dropdown">
							<button class="btn btn-sm border-0 dropdown-toggle p-50" type="button" id="dropdownItem5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Last 7 Days
							</button>
							<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownItem5">
								<a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>
								<a class="dropdown-item" href="javascript:void(0);">Last Month</a>
								<a class="dropdown-item" href="javascript:void(0);">Last Year</a>
							</div>
						</div>
						<div id="avg-sessions-chart"></div>
					</div>
				</div>
				<hr />
				<div class="row avg-sessions pt-50">
					<div class="col-6 mb-2">
						<p class="mb-50">Goal: $100000</p>
						<div class="progress progress-bar-primary" style="height: 6px">
							<div class="progress-bar" role="progressbar" aria-valuenow="50" aria-valuemin="50" aria-valuemax="100" style="width: 50%"></div>
						</div>
					</div>
					<div class="col-6 mb-2">
						<p class="mb-50">Users: 100K</p>
						<div class="progress progress-bar-warning" style="height: 6px">
							<div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="60" aria-valuemax="100" style="width: 60%"></div>
						</div>
					</div>
					<div class="col-6">
						<p class="mb-50">Retention: 90%</p>
						<div class="progress progress-bar-danger" style="height: 6px">
							<div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="70" aria-valuemax="100" style="width: 70%"></div>
						</div>
					</div>
					<div class="col-6">
						<p class="mb-50">Duration: 1yr</p>
						<div class="progress progress-bar-success" style="height: 6px">
							<div class="progress-bar" role="progressbar" aria-valuenow="90" aria-valuemin="90" aria-valuemax="100" style="width: 90%"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Avg Sessions Chart Card ends -->

	<!-- Support Tracker Chart Card starts -->
	<div class="col-lg-6 col-12">
		<div class="card">
			<div class="card-header d-flex justify-content-between pb-0">
				<h4 class="card-title">Support Tracker</h4>
				<div class="dropdown chart-dropdown">
					<button class="btn btn-sm border-0 dropdown-toggle p-50" type="button" id="dropdownItem4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Last 7 Days
					</button>
					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownItem4">
						<a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>
						<a class="dropdown-item" href="javascript:void(0);">Last Month</a>
						<a class="dropdown-item" href="javascript:void(0);">Last Year</a>
					</div>
				</div>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-sm-2 col-12 d-flex flex-column flex-wrap text-center">
						<h1 class="font-large-2 font-weight-bolder mt-2 mb-0">163</h1>
						<p class="card-text">Tickets</p>
					</div>
					<div class="col-sm-10 col-12 d-flex justify-content-center">
						<div id="support-trackers-chart"></div>
					</div>
				</div>
				<div class="d-flex justify-content-between mt-1">
					<div class="text-center">
						<p class="card-text mb-50">New Tickets</p>
						<span class="font-large-1 font-weight-bold">29</span>
					</div>
					<div class="text-center">
						<p class="card-text mb-50">Open Tickets</p>
						<span class="font-large-1 font-weight-bold">63</span>
					</div>
					<div class="text-center">
						<p class="card-text mb-50">Response Time</p>
						<span class="font-large-1 font-weight-bold">1d</span>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Support Tracker Chart Card ends -->
</div>

<div class="row match-height">
	<!-- Timeline Card -->
	<div class="col-lg-4 col-12">
		<div class="card card-user-timeline">
			<div class="card-header">
				<div class="d-flex align-items-center">
					<i data-feather="list" class="user-timeline-title-icon"></i>
					<h4 class="card-title">User Timeline</h4>
				</div>
			</div>
			<div class="card-body">
				<ul class="timeline ml-50">
					<li class="timeline-item">
						<span class="timeline-point timeline-point-indicator"></span>
						<div class="timeline-event">
							<h6>12 Invoices have been paid</h6>
							<p>Invoices are paid to the company</p>
							<div class="media align-items-center">
								<img class="mr-1" src="<?= base_url('app-assets/images/icons/json.png') ?>" alt="data.json" height="23" />
								<h6 class="media-body mb-0">data.json</h6>
							</div>
						</div>
					</li>
					<li class="timeline-item">
						<span class="timeline-point timeline-point-warning timeline-point-indicator"></span>
						<div class="timeline-event">
							<h6>Client Meeting</h6>
							<p>Project meeting with Carl</p>
							<div class="media align-items-center">
								<div class="avatar mr-50">
									<img src="<?= base_url('app-assets/images/portrait/small/avatar-s-9.jpg') ?>" alt="Avatar" width="38" height="38" />
								</div>
								<div class="media-body">
									<h6 class="mb-0">Carl Roy (Client)</h6>
									<p class="mb-0">CEO of Infibeam</p>
								</div>
							</div>
						</div>
					</li>
					<li class="timeline-item">
						<span class="timeline-point timeline-point-info timeline-point-indicator"></span>
						<div class="timeline-event">
							<h6>Create a new project</h6>
							<p>Add files to new design folder</p>
							<div class="avatar-group">
								<div data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" data-original-title="Billy Hopkins" class="avatar pull-up">
									<img src="<?= base_url('app-assets/images/portrait/small/avatar-s-9.jpg') ?>" alt="Avatar" width="33" height="33" />
								</div>
								<div data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" data-original-title="Amy Carson" class="avatar pull-up">
									<img src="<?= base_url('app-assets/images/portrait/small/avatar-s-6.jpg') ?>" alt="Avatar" width="33" height="33" />
								</div>
								<div data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" data-original-title="Brandon Miles" class="avatar pull-up">
									<img src="<?= base_url('app-assets/images/portrait/small/avatar-s-8.jpg') ?>" alt="Avatar" width="33" height="33" />
								</div>
								<div data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" data-original-title="Daisy Weber" class="avatar pull-up">
									<img src="<?= base_url('app-assets/images/portrait/small/avatar-s-7.jpg') ?>" alt="Avatar" width="33" height="33" />
								</div>
								<div data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" data-original-title="Jenny Looper" class="avatar pull-up">
									<img src="<?= base_url('app-assets/images/portrait/small/avatar-s-20.jpg') ?>" alt="Avatar" width="33" height="33" />
								</div>
							</div>
						</div>
					</li>
					<li class="timeline-item">
						<span class="timeline-point timeline-point-danger timeline-point-indicator"></span>
						<div class="timeline-event">
							<h6>Update project for client</h6>
							<p class="mb-0">Update files as per new design</p>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<!--/ Timeline Card -->

	<!-- Sales Stats Chart Card starts -->
	<div class="col-lg-4 col-md-6 col-12">
		<div class="card">
			<div class="card-header d-flex justify-content-between align-items-start pb-1">
				<div>
					<h4 class="card-title mb-25">Sales</h4>
					<p class="card-text">Last 6 months</p>
				</div>
				<div class="dropdown chart-dropdown">
					<i data-feather="more-vertical" class="font-medium-3 cursor-pointer" data-toggle="dropdown"></i>
					<div class="dropdown-menu dropdown-menu-right">
						<a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>
						<a class="dropdown-item" href="javascript:void(0);">Last Month</a>
						<a class="dropdown-item" href="javascript:void(0);">Last Year</a>
					</div>
				</div>
			</div>
			<div class="card-body">
				<div class="d-inline-block mr-1">
					<div class="d-flex align-items-center">
						<i data-feather="circle" class="font-small-3 text-primary mr-50"></i>
						<h6 class="mb-0">Sales</h6>
					</div>
				</div>
				<div class="d-inline-block">
					<div class="d-flex align-items-center">
						<i data-feather="circle" class="font-small-3 text-info mr-50"></i>
						<h6 class="mb-0">Visits</h6>
					</div>
				</div>
				<div id="sales-visit-chart" class="mt-50"></div>
			</div>
		</div>
	</div>
	<!-- Sales Stats Chart Card ends -->

	<!-- App Design Card -->
	<div class="col-lg-4 col-md-6 col-12">
		<div class="card card-app-design">
			<div class="card-body">
				<div class="badge badge-light-primary">03 Sep, 20</div>
				<h4 class="card-title mt-1 mb-75 pt-25">App design</h4>
				<p class="card-text font-small-2 mb-2">
					You can Find Only Post and Quotes Related to IOS like ipad app design, iphone app design
				</p>
				<div class="design-group mb-2 pt-50">
					<h6 class="section-label">Team</h6>
					<div class="badge badge-light-warning mr-1">Figma</div>
					<div class="badge badge-light-primary">Wireframe</div>
				</div>
				<div class="design-group pt-25">
					<h6 class="section-label">Members</h6>
					<div class="avatar">
						<img src="<?= base_url('app-assets/images/portrait/small/avatar-s-9.jpg') ?>" width="34" height="34" alt="Avatar" />
					</div>
					<div class="avatar bg-light-danger">
						<div class="avatar-content">PI</div>
					</div>
					<div class="avatar">
						<img src="<?= base_url('app-assets/images/portrait/small/avatar-s-14.jpg') ?>" width="34" height="34" alt="Avatar" />
					</div>
					<div class="avatar">
						<img src="<?= base_url('app-assets/images/portrait/small/avatar-s-7.jpg') ?>" width="34" height="34" alt="Avatar" />
					</div>
					<div class="avatar bg-light-secondary">
						<div class="avatar-content">AL</div>
					</div>
				</div>
				<div class="design-planning-wrapper mb-2 py-75">
					<div class="design-planning">
						<p class="card-text mb-25">Due Date</p>
						<h6 class="mb-0">12 Apr, 21</h6>
					</div>
					<div class="design-planning">
						<p class="card-text mb-25">Budget</p>
						<h6 class="mb-0">$49251.91</h6>
					</div>
					<div class="design-planning">
						<p class="card-text mb-25">Cost</p>
						<h6 class="mb-0">$840.99</h6>
					</div>
				</div>
				<button type="button" class="btn btn-primary btn-block">Join Team</button>
			</div>
		</div>
	</div>
	<!--/ App Design Card -->
</div>
<?= $this->endSection() ?>
<?= $this->section('vendorJS') ?>
<script src="<?= base_url('app-assets/js/scripts/pages/dashboard-analytics.js') ?>"></script>
<script src="<?= base_url('app-assets/js/scripts/pages/app-invoice-list.js') ?>"></script>
<?= $this->endSection() ?>