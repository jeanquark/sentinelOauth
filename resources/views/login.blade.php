@extends('layoutFront')

@section('title', 'Login')

@section('content')
	<div class="col-md-4 col-md-offset-2">
	    {!! Form::open(array('route' => 'session.store', 'method' => 'POST', 'class' => 'form-horizontal' )) !!}
			<div class="panel panel-primary">
	            <div class="panel-heading">
	                <h2 class="panel-title">Sign In</h2>
	            </div>
				<div class="panel-body" style="padding-top: 30px">
	                <div class="input-group">
	                	<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>   
	                	{!! Form::text('email', Input::old('email'), array('class' => 'form-control', 'placeholder' => 'Email')) !!}
	                </div>
	                <br/>

	                <div class="input-group">
	               		<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
	               		{!! Form::password('password', array('class' => 'form-control', 'placeholder' => 'Password')) !!}
	                </div>
	                <br/>

					<div class="input-group">
						<div class="checkbox">
							<label>
								{!! Form::checkbox('remember', null, null, ['id' => 'remember']) !!} Remember Me
							</label>
						</div>
					</div>
					<br/>

	                {!! Form::submit('Sign In', array('class'=>'btn btn-success')) !!}
	                <a class="btn btn-link" href="{{ route('sentinel.forgot.form') }}">Forgot Password</a>
					<br/>

					<hr>
					<h5 style="text-align:center"> Or sign in via OAuth: </h5>    
                    <div class="row">
                    	<div class="col-sm-6 col-xs-12">
                            <a href="login/google"><img src="images/oauth/google.png" alt="" width="150"></a>
                        </div>
                        <div class="col-sm-6 col-xs-12">
                            <a href="login/facebook"><img src="images/oauth/facebook.png" alt="" width="150"></a>
                        </div>
                        <div class="col-sm-12 col-xs-12"><br/></div>
                        <!--<div class="col-sm-6 col-xs-12">
                        	<a href="login/twitter"><img src="images/oauth/twitter.png" alt="" width="150"></a>
                        </div>-->
                        <div class="col-sm-6 col-xs-12">
                            <a href="login/linkedin"><img src="images/oauth/linkedin.png" alt="" width="150"></a>
                        </div>
                        <div class="col-sm-6 col-xs-12">
                            <a href="login/github"><img src="images/oauth/github.png" alt="" width="150"></a>
                        </div>
                        <!--<div class="col-sm-6 col-xs-12">
                        	<a href="login/bitbucket"><img src="images/oauth/bitbucket.png" alt="" width="150"></a>
                        </div>-->
                    </div><!-- ./row -->
                    <br/>
					<p>To sign in as administrator, please enter :
						@if (!empty($user))
							<ul>
								<li>Email: <b><pre>{{ $user->email }}</pre></b></li>
								<li>Password: <b><pre>secret</pre></b></li>
							</ul>
						@else 
							<p class="alert alert-danger text-center">No registered administrator.</p>
						@endif	
					</p>
				</div><!-- /.panel-body -->
			</div><!-- /.panel panel-info -->
		<!--</form>-->
		{!! Form::close() !!}
	</div>
	<!-- ./col-md-8 -->
	<div class="col-md-2"></div>

@stop