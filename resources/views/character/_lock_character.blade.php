
    {!! Form::open(['url' => '/character/' . $character->slug . '/lock']) !!}
@if (!$character->is_locked)
    <p>Locking a character will extend its cooldown by <b> {{$lockcooldown}} </b> days, during which you will not be able to trade, gift, or sell the character. Your character will not appear in masterlist searches for trade/sellable characters. Your character's trade and sell status will remain preserved.</p>
	<p>Once locked, you may manually unlock it only <b>after its cooldown has passed</b>.</p>
	<p><b>Are you sure you'd like to lock this character for {{$lockcooldown}} days?</b></p>
	{{ Form::hidden('is_locked', '1') }}
    <div class="text-right">
        {!! Form::submit('Lock character', ['class' => 'btn btn-danger']) !!}
    </div>
@else
	<p><b>This character is currently locked.</b></p>
	<p>Are you sure you'd like to unlock this character?</p>
    <div class="text-right">
        {!! Form::submit('Unlock character', ['class' => 'btn btn-success']) !!}
    </div>
@endif	
    {!! Form::close() !!}

