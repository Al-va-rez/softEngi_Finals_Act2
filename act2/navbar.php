<div class="navbar">
	<h1>Welcome, <span style="color: blue;"><?= $_SESSION['username']; ?></span></h1>
</div>

<div class="navbar">
	<div>
		<h3>
			<a href="index.php">Home</a>
		</h3>
	</div>

	<div>
		<h3>
			<a href="create.php">Add New Applicant</a>
		</h3>
	</div>

	<div>
		<h3>
			<a href="all_Users.php">All Users</a>
		</h3>
	</div>

	<div>
		<h3>
			<a href="activity_Logs.php">Activity Logs</a>
		</h3>
	</div>

	<div>
		<h3>
			<a href="core/handleForms.php?btn_Logout=1">Logout</a>	
		</h3>
	</div>
</div>