@extends('layoutFront')

@section('title', 'Register')

@section('content')
	<div class="col-md-4 col-md-offset-2">
	    {!! Form::open(array('route' => 'register.store', 'method' => 'POST', 'class' => 'form-horizontal' )) !!}
			<div class="panel panel-primary">
	            <div class="panel-heading">
	                <h2 class="panel-title">Register</h2>
	            </div>

				<div class="panel-body" style="padding-top: 30px">
	                <div class="input-group">
	                	<span class="input-group-addon"><i class="fa fa-at"></i></span>   
	                	{!! Form::text('email', Input::old('email'), array('class' => 'form-control', 'placeholder' => 'Email')) !!}
	                </div>
	                <br/>

	                <div class="input-group">
	               		<span class="input-group-addon"><i class="fa fa-lock fa-lg"></i></span>
	               		{!! Form::password('password', array('class' => 'form-control', 'placeholder' => 'Password')) !!}
	                </div>
	                <br/>

	                <div class="input-group">                          
	               		<span class="input-group-addon"><i class="fa fa-lock fa-lg"></i></span>
	               		{!! Form::password('password_confirmation', array('class' => 'form-control', 'placeholder' => 'Confirm Password')) !!}
	                </div>
	                <br/>

	                <div class="input-group">
	               		<span class="input-group-addon"><i class="fa fa-user"></i></span>
	               		{!! Form::text('first_name', Input::old('first_name'), array('class' => 'form-control', 'placeholder' => 'First name')) !!}
	                </div>
					<br/>

	                <div class="input-group">
	               		<span class="input-group-addon"><i class="fa fa-user"></i></span>
	               		{!! Form::text('last_name', Input::old('last_name'), array('class' => 'form-control', 'placeholder' => 'Last name')) !!}
	                </div>
	          		<br/>

	                {!! Form::submit('Register', array('class'=>'btn btn-success')) !!}
				</div><!-- /.panel-body -->
			</div><!-- /.panel panel-info -->
		<!--</form>-->
		{!! Form::close() !!}
	</div>
	<!-- /.col-md-8 -->
	<div class="col-md-2"></div>
@stop