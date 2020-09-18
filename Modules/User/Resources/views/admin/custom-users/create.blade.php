@extends('layouts.master')

@section('content-header')
<h1>
    Crear Usuario
</h1>
<ol class="breadcrumb">
    <li><a href="{{ URL::route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
    <li class=""><a href="{{ URL::route('admin.user.custom-user.index') }}">Usuarios</a></li>
    <li class="active">Crear Usuario</li>
</ol>
@stop

@section('content')

    {!! Form::open(['route' => 'admin.user.custom-user.store', 'method' => 'post']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                @include('partials.form-tab-headers')
                <div class="tab-content">
                    <?php $i = 0; ?>
                    @foreach (LaravelLocalization::getSupportedLocales() as $locale => $language)
                        <?php $i++; ?>
                        <div class="tab-pane {{ locale() == $locale ? 'active' : '' }}" id="tab_{{ $i }}">

                        	{!! Form::hidden('activated', true) !!}
							<div class="box-body">
							    <div class="row">
							        <div class="col-sm-4">
								        {!! Form::normalInput('first_name', 'Nombre', $errors) !!}
							        </div>
							        <div class="col-sm-4">
							        	{!! Form::normalInput('last_name', 'Apellido', $errors) !!}
							        </div>
							        <div class="col-sm-4">
							        	{!! Form::normalInput('email', 'Email', $errors) !!}
							        </div>
							    </div>
							    <div class="row">
							        <div class="col-sm-4">
							            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
							                {!! Form::label('password', trans('user::users.form.password')) !!}
							                {!! Form::password('password', ['class' => 'form-control']) !!}
							                {!! $errors->first('password', '<span class="help-block">:message</span>') !!}
							            </div>
							        </div>
							        <div class="col-sm-4">
							            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
							                {!! Form::label('password_confirmation', trans('user::users.form.password-confirmation')) !!}
							                {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
							                {!! $errors->first('password_confirmation', '<span class="help-block">:message</span>') !!}
							            </div>
							        </div>
							        <div class="col-sm-4">
							    		{!! Form::normalSelect('roles', 'Rol', $errors, \Helper::addDefaultOptionArray($roles)) !!}
							    	</div>
							    </div>
							</div>

                        </div>
                    @endforeach

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary btn-flat">{{ trans('core::core.button.create') }}</button>
                        <a class="btn btn-danger pull-right btn-flat" href="{{ route('admin.user.custom-user.index')}}"><i class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
                    </div>
                </div>
            </div> {{-- end nav-tabs-custom --}}
        </div>
    </div>
    {!! Form::close() !!}

@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>b</code></dt>
        <dd>{{ trans('user::users.navigation.back to index') }}</dd>
    </dl>
@stop
