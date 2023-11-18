{!! Form::open(array('route' => 'route.name', 'method' => 'POST')) !!}
	<ul>
		<li>
			{!! Form::label('cardId', 'CardId:') !!}
			{!! Form::text('cardId') !!}
		</li>
		<li>
			{!! Form::label('filePath', 'FilePath:') !!}
			{!! Form::text('filePath') !!}
		</li>
		<li>
			{!! Form::label('fileType', 'FileType:') !!}
			{!! Form::text('fileType') !!}
		</li>
		<li>
			{!! Form::label('detail', 'Detail:') !!}
			{!! Form::text('detail') !!}
		</li>
		<li>
			{!! Form::label('fileName', 'FileName:') !!}
			{!! Form::text('fileName') !!}
		</li>
		<li>
			{!! Form::label('drugSens', 'DrugSens:') !!}
			{!! Form::text('drugSens') !!}
		</li>
		<li>
			{!! Form::submit() !!}
		</li>
	</ul>
{!! Form::close() !!}