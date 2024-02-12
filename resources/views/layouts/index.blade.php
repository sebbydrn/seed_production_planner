<!DOCTYPE html>
<html lang="en" class="fixed">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Seed Production</title>

	<!-- Mobile Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

	@include('layouts.cssLinks')
	
	@stack('styles')
</head>
<body>
	<section class="body">
		
		<!-- start: header -->
		@include('layouts.header')
		<!-- end: header -->

		<div class="inner-wrapper">
			<!-- start: sidebar -->
			@include('layouts.sidebar')
			<!-- end: sidebar -->

			<section role="main" class="content-body">
				<header class="page-header">
					@yield('pageHeader')
				</header>

				<!-- start: page -->
				@yield('pageContent')
				<!-- end: page -->

				<div class="row" style="position: absolute; bottom: 0; width: 100%;">
					<div class="col-md-12">
						<footer class="mt-lg" style="padding: 15px; margin-right: 50px;">
							<strong>Copyright &copy; {{date('Y')}}.</strong> All rights reserved.
							<div style="float: right;">
								<strong>Version</strong> 2.0.0
							</div>
						</footer>
					</div>
				</div>
			</section>
		</div>

		<!-- start: sidebar-right -->
		@include('layouts.sidebarRight')
		<!-- end: sidebar-right -->
	</section>

	@include('layouts.jsLinks')

	@stack('scripts')
</body>
</html>