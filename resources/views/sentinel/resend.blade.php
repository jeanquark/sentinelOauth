@extends('layoutFront')

{{-- Web site Title --}}
@section('title')
@parent
Resend Activation
@stop

{{-- Content --}}
@section('content')
    <?php //dd($hash); ?>
    <div class="col-md-4 col-md-offset-2">
        
        <h4>Where do you want us to send you the activation message?</h4>
    
        {!! Form::open(array('route' => array('sentinel.reactivate.send', $hash), 'method' => 'POST', 'class' => 'form-horizontal')) !!}
        
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-at"></i></span>   
                {!! Form::text('email', $email, array('class' => 'form-control', 'placeholder' => 'Email')) !!}
            </div>
            <br/>

            {!! Form::submit('Send', array('class'=>'btn btn-primary')) !!}

        {!! Form::close() !!}
    </div><!-- /. col-md-4 -->
    <div class="col-md-2"></div>
@stop
