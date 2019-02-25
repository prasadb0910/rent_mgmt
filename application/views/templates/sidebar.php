<nav class="page-sidebar" data-pages="sidebar">
	
	<div class="sidebar-header">
		<img src="<?php echo base_url(); ?>assets/img/logo_white.png" alt="logo" class="brand" data-src="<?php echo base_url(); ?>assets/img/logo_white.png" data-src-retina="<?php echo base_url(); ?>assets/img/logo_white.png" style="min-height: 25px;height: 100%;padding:5px 0px">

		<div class="sidebar-header-controls">
			<button type="button" class="btn btn-xs sidebar-slide-toggle btn-link hidden-md-down" data-pages-toggle="#appMenu"><i class="fa fa-angle-down fs-16"></i>
			</button>
			<button type="button" class="btn btn-link hidden-md-down" id="sidebar_cntrl" data-toggle-pin="sidebar"><i class="fa fs-12" style="color:#000;"></i>
			</button>
		</div>
	</div>
	<div class="sidebar-menu">
		<ul class="menu-items">
			<li class="" style="background:#0d3553!important;color:#fff;">
				<a class="detailed">
					<span class="title">REAMS</span>
					<span class=" open  arrow"></span>
				</a>
				<span class="bg-success icon-thumbnail"><i class="fa fa-dashboard "></i></span>
				</li>
		
			<li style="<?php if ($userdata['groupid']=='0') echo 'display: none;';?>">
				<a href="<?php echo base_url().'index.php/dashboard/'; ?>" class="detailed">
					<span class="title">Dashboard</span>
				</a>
				<span class="bg-success icon-thumbnail"><i class="fa fa-dashboard"></i></span>
			</li>
		
			<li <?php if ($Association==0) echo 'style="display: none;"'; ?>>
				<a href="<?php echo base_url().'index.php/contacts'; ?>">
				<span class="title">Contacts</span>
				</a>
				<span class="icon-thumbnail"><i class="fa fa-group"></i></span>
				
			</li>
			
			<li <?php if ($Properties==0 && $Sale==0)  echo 'style="display: none;"'; ?>>
				<a href="<?php echo base_url().'index.php/purchase'; ?>" class="detailed">
					<span class="title">Properties</span>
				</a>
				<span class="bg-success icon-thumbnail"><i class="fa fa-home "></i></span>
			</li>
			
			<li <?php if ($Rent==0) echo 'style="display: none;"'; ?>>
				<a href="<?php echo base_url().'index.php/rent'; ?>" class="detailed">
					<span class="title">Leases</span>
				</a>
				<span class="bg-success icon-thumbnail"><i class="fa fa-file-text-o "></i></span>
			</li>
			<li <?php if ($Loan==0) echo 'style="display: none;"'; ?>>
				<a href="<?php echo base_url().'index.php/loan'; ?>" class="detailed">
					<span class="title">Loan</span>
				</a>
				<span class="bg-success icon-thumbnail"><i class="fa fa-money "></i></span>
			</li>
	
			
				
			
				<li <?php if ($BankEntry==0) echo 'style="display: none;"'; ?>>
				<a href="<?php echo base_url().'index.php/accounting'; ?>" class="detailed">
					<span class="title">Accounting</span>
				</a>
					<span class="icon-thumbnail"><i class="fa fa-rupee  "></i></span>
			</li>
			
			<li <?php if ($Task==0) echo 'style="display: none;"'; ?>>
				<a href="<?php echo base_url().'index.php/task'; ?>" class="detailed">
					<span class="title">Maintenance</span>
				</a>
				<span class="bg-success icon-thumbnail"><i class="fa fa-edit "></i></span>
			</li>
			<li <?php if ($Reports==0) echo 'style="display: none;"'; ?>>
				<a href="<?php if ($userdata['groupid']=='0') echo  base_url().'index.php/reports'; else echo  base_url().'index.php/reports/view_reports'; ?>" class="detailed">
					<span class="title">Reports</span>
				</a>
				<span class="bg-success icon-thumbnail"><i class="fa fa-bar-chart-o "></i></span>
			</li>
			<li class="#" style="display: none;">
				<a href="reports.php" class="detailed">
					<span class="title">My Website</span>
				</a>
				<span class="bg-success icon-thumbnail"><i class="fa fa-globe "></i></span>
			</li>
			
				<li class="#" style="background:#0d3553!important;border-bottom:1px solid#245478!important">
				<a href="<?php echo base_url().'index.php/login/idata'; ?>" class="detailed">
					<span class="title">iDATA</span>
				</a>
				<span class="bg-success icon-thumbnail"><i class="fa fa-dashboard "></i></span>
				</li>
			
				<li class="#" style="background:#0d3553!important;">
				<a href="<?php echo base_url().'index.php/login/assure'; ?>" class="detailed">
					<span class="title">Assure</span>
				</a>
				<span class="bg-success icon-thumbnail"><i class="fa fa-dashboard "></i></span>
			</li>
			
		</ul>
		<div class="clearfix"></div>
	</div>
</nav>