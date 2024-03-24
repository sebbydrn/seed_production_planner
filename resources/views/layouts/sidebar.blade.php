<aside id="sidebar-left" class="sidebar-left">		
	<div class="sidebar-header">
		<div class="sidebar-title" style="color: white;">
			Navigation
		</div>
		<div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
			<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
		</div>
	</div>

	<div class="nano">
		<div class="nano-content">
			<nav id="menu" class="nav-main" role="navigation">
				<ul class="nav nav-main">

					<hr class="separator">

					@if(Entrust::can('view_seed_production_plans'))
						<li class="{{(Request::segment(1) == 'production_plans') ? 'nav-active' : ''}}">
							<a href="{{route('production_plans.index')}}">
								<i class="fa fa-calendar" aria-hidden="true"></i>
								<span>Production Plans</span>
							</a>
						</li>
					@endif

					<li class="{{(Request::segment(1) == 'farmers') ? 'nav-active' : ''}}">
						<a href="{{route('farmers.index')}}">
							<i class="fa fa-user" aria-hidden="true"></i>
							<span>Farmers</span>
						</a>
					</li>
					
					@if(Entrust::can('view_plots'))
						<li class="{{(Request::segment(1) == 'plots') ? 'nav-active' : ''}}">
							<a href="{{route('plots.index')}}">
								<i class="fa fa-map-marker" aria-hidden="true"></i>
								<span>Plots</span>
							</a>
						</li>
					@endif

					{{-- @if(Entrust::can('view_seed_production_plans'))
						<li class="{{(Request::segment(2) == 'activities_viewer') ? 'nav-active' : ''}}">
							<a href="{{route('seed_production_activities.activities_viewer')}}">
								<i class="fa fa-calendar" aria-hidden="true"></i>
								<span>Activities Viewer</span>
							</a>
						</li>
					@endif --}}

					<li class="{{(Request::segment(1) == 'seed-inventory') ? 'nav-active' : ''}}">
						<a href="{{route('seed_inventory.index')}}">
							<i class="fa fa-shopping-cart" aria-hidden="true"></i>
							<span>Seed Inventory</span>
						</a>
					</li>


					<li class="{{(Request::segment(1) == 'seed-distribution') ? 'nav-active' : ''}}">
						<a href="{{route('seed_distribution.index')}}">
							<i class="fa fa-shopping-cart" aria-hidden="true"></i>
							<span>Seed Distribution</span>
						</a>
					</li>
					<li class="{{(Request::segment(1) == 'fertilizer-inventory') ? 'nav-active' : ''}}">
						<a href="{{route('fertilizer_inventory.index')}}">
							<i class="fa fa-shopping-cart" aria-hidden="true"></i>
							<span>Fertilizer Inventory</span>
						</a>
					</li>

					<li class="{{(Request::segment(1) == 'fertilizer-distribution') ? 'nav-active' : ''}}">
						<a href="{{route('fertilizer_distribution.index')}}">
							<i class="fa fa-shopping-cart" aria-hidden="true"></i>
							<span>Fertilizer Distribution</span>
						</a>
					</li>
				</ul>
			</nav>
		</div>
	</div>
</aside>