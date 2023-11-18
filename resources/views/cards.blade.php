{!! Form::open(array('route' => 'route.name', 'method' => 'POST')) !!}
	<ul>
		<li>
			{!! Form::label('userID', 'UserID:') !!}
			{!! Form::text('userID') !!}
		</li>
		<li>
			{!! Form::label('typeCard', 'TypeCard:') !!}
			{!! Form::text('typeCard') !!}
		</li>
		<li>
			{!! Form::label('name', 'Name:') !!}
			{!! Form::text('name') !!}
		</li>
		<li>
			{!! Form::label('birthDate', 'BirthDate:') !!}
			{!! Form::text('birthDate') !!}
		</li>
		<li>
			{!! Form::label('gender', 'Gender:') !!}
			{!! Form::text('gender') !!}
		</li>
		<li>
			{!! Form::label('location', 'Location:') !!}
			{!! Form::text('location') !!}
		</li>
		<li>
			{!! Form::label('phone', 'Phone:') !!}
			{!! Form::text('phone') !!}
		</li>
		<li>
			{!! Form::label('passcode', 'Passcode:') !!}
			{!! Form::text('passcode') !!}
		</li>
		<li>
			{!! Form::label('macAddress', 'MacAddress:') !!}
			{!! Form::text('macAddress') !!}
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