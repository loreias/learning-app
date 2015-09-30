{{-- <p class="bg-info"></p>		 --}}
<div class="form-group">
	{{-- create lebel for element --}}
	{{-- title-> name attr = title  --}}
	{{-- second param value = Title	 --}}
	{!! Form::label('title', 'Title:') !!}

	{{-- creates text input element --}}
	{{-- title-> name attr = title --}}
	{{-- null-> value --}}
	{{-- [] -> pass any other attr to  element --}}
	{!! Form::text('title', null, ['class'=>'form-control']) !!}
</div>


<div class="form-group">
	{!! Form::label('description', 'Description:') !!}	
	{!! Form::text('description', null, ['class'=>'form-control']) !!}	
</div>
	
<h3>Assign Tutors to Level:</h3>
<p>Tutores Registrados ( validacion si no existe tutores mostrar forma pra agregar Tutores o alternativa dejar campo em blanco </p>	
<div class="checkbox">
	<label>
		{!! Form::checkbox('tutor-1', 'tutor-1', true) !!}
		tutor name 1	
	</label>

	<label>
		{!! Form::checkbox('tutor-2', 'tutor-2') !!}
		tutor name 2	
	</label>			


	<label>
		{!! Form::checkbox('tutor-2', 'tutor-2') !!}
		tutor name 2	
	</label>			
</div>				
<br>
<hr>

<h3>Add Lessons:</h3>
<p>Si existen lecciones no asignadas a un Nivel mostrar esta seccion.</p>
{!! Form::select('size', 
	array('lesson1' => 'lesson 1', 'lesson2' => 'lesson 2', 'lesson3' => 'lesson 3', 'lesson4' => 'lesson 4' ), // options
	'lesson1', // default value
	array('class'=>'form-control', 'multiple' => 'multiple')) // extra attr
!!}
<br>
<hr>


<div class="form-group">
	{!! Form::label('published_at', 'Publish On:') !!}	
	{!! Form::input('date', 'published_at', date('Y-m-d'), ['class'=>'form-control']) !!}	
</div>
<br>
<hr>


<div class="form-group">
	{!! Form::label('level_index', 'Level Index:') !!}
	{!! Form::text('level_index', $currentLevelIndex, ['class'=>'form-control']) !!}	
</div>


{!! Form::submit($submitBtnText, ['class' => 'btn btn-primary form-control']) !!}	

