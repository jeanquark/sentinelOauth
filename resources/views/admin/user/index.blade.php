@extends('layoutBack')

@section('content')
	<ol class="breadcrumb">
        <li class="active">
            <i class="fa fa-users"></i> Users
        </li>
    </ol>
	<ul class="nav navbar-nav">
        <li><a href="{{ route('admin.user.index') }}">View All Users</a></li>
        <li><a href="{{ route('admin.user.create') }}">Create a User</a>
    </ul>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    All the current Users
                </div><!-- /.panel-heading -->

                <div class="panel-body">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th valign="middle">ID</th>
                                <th>Email</th>
                                <th>First name</th>
                                <th>Last name</th>
                                <th>Role</th>
                                <th>Active</th>
                                <th>Created at</th>
                                <!--<th>Updated at</th>-->
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        	@foreach($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->first_name }}</td>
                                    <td>{{ $user->last_name }}</td>
                                    @if (!$user->roles()->get()->isEmpty())
                                        <td>{{ $user->roles()->first()->name }}</td>
                                    @else
                                        <td><i>- No status -</i></td>
                                    @endif

                                    @if (Activation::completed(Sentinel::findById($user->id)))
                                        <td>Yes</td>
                                    @else
                                        <td>No</td>
                                    @endif
                                    <td>{{ $user->created_at }}</td>
                                    <td>
                                        {!! Form::open(array('route' => array('admin.user.destroy', $user->id), 'method' => 'delete')) !!}
                                            <button class="btn btn-success" type="button" onClick="location.href='{{ route('admin.user.show', array($user->id)) }}'">Show</button>
                                            <button class="btn btn-info" type="button" onClick="location.href='{{ route('admin.user.edit', array($user->id)) }}'">Edit</button>
                                            <button type="submit" class="btn btn-warning" onClick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div><!-- /.panel-body -->
            </div><!-- /.panel -->
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
@stop