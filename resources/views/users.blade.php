{!! Form::open(array('route' => 'route.name', 'method' => 'POST')) !!}
	<ul>
		<li>
			{!! Form::label('userID', 'UserID:') !!}
			{!! Form::text('userID') !!}
		</li>
		<li>
			{!! Form::label('email', 'Email:') !!}
			{!! Form::text('email') !!}
		</li>
		<li>
			{!! Form::label('password', 'Password:') !!}
			{!! Form::text('password') !!}
		</li>
		<li>
			{!! Form::label('cardId', 'CardId:') !!}
			{!! Form::text('cardId') !!}
		</li>
		<li>
			{!! Form::label('picId', 'PicId:') !!}
			{!! Form::text('picId') !!}
		</li>
		<li>
			{!! Form::submit() !!}
		</li>
	</ul>
{!! Form::close() !!}