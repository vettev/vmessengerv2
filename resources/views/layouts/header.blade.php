<header id="main-header">
	<nav class="navbar navbar-default" id="main-nav">
		<div class="container-fluid">
		    <div class="navbar-header">
			    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
			        <span class="sr-only">Toggle navigation</span>
			        <span class="icon-bar"></span>
			        <span class="icon-bar"></span>
			        <span class="icon-bar"></span>
		    	</button>
		    	<a class="navbar-brand" href="/home">
		        <h2 class="site-title">VMsg <span class="glyphicon glyphicon-envelope"></span></h2>
		        </a>
		    </div>
		    
		    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		    	<ul class="nav navbar-nav">
		        	<li><a href="{{ route('user.edit') }}" class="ajax-link user-edit" title="Edit your profile"><span class="glyphicon glyphicon-edit"></span> Edit profile</a></li>
		        	<li><a href="{{ route('logout') }}" title="Logout"><span class="glyphicon glyphicon-eject"></span> Logout</a></li>
		    	</ul>
				<form class="navbar-form navbar-right search-form ajax-form" action ="{{ route('search') }}">
			    	<div class="form-group">
			        	<input type="text" class="form-control" placeholder="Search" minlength="2" name="condition">
			        	<span class="glyphicon glyphicon-search"></span>
			    	</div>
			    	{{ csrf_field() }}
			    </form>
		    </div><!-- /.navbar-collapse -->
		</div><!-- /.container-fluid -->
	</nav>
</header>