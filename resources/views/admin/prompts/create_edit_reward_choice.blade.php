@extends('admin.layout')

@section('admin-title')
    {{ $group->id ? 'Edit' : 'Create' }} Reward Choice Group
@endsection

@section('admin-content')
    {!! breadcrumbs([
        'Admin Panel' => 'admin',
        'Reward Choices' => 'admin/data/reward-choices',
        ($group->id ? 'Edit' : 'Create') . ' Group' => $group->id ? 'admin/data/reward-choices/edit/' . $group->id : 'admin/data/reward-choices/create',
    ]) !!}

    <h1>{{ $group->id ? 'Edit' : 'Create' }} Reward Choice Group
        @if ($group->id)
            <a href="#" class="btn btn-danger float-right delete-group-button">Delete Group</a>
        @endif
    </h1>

    {!! Form::open(['url' => $group->id ? 'admin/data/reward-choices/edit/' . $group->id : 'admin/data/reward-choices/create', 'files' => true]) !!}

    <h3>Basic Information</h3>
    <p>The name and description of this choice will appear in the prompt submission area. Keep short!</p>
    <div class="form-group">
        {!! Form::label('Name') !!}
        {!! Form::text('name', $group->name, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('Description (Keep short!)') !!}
        {!! Form::textarea('description', $group->description, ['class' => 'form-control wysiwyg']) !!}
    </div>



    @if ($group->id)
        <h3>Group Loots</h3>
        <p>Every row here will be rewarded to the character! Note that currently loot tables are rolled on the <b>first character</b> themself, though I will be adding more functionality later. Loot that cannot be held in a character's inventory goes to
            the <b>owner's</b> inventory, not the submitter's due to how LK's loot rewarding works atm.</b></p>

        @include('widgets._loot_select', ['loots' => $group->choices, 'showLootTables' => true, 'showRaffles' => true])

        <div class="text-right">
            {!! Form::submit($group->id ? 'Edit' : 'Create', ['class' => 'btn btn-primary']) !!}
        </div>

        {!! Form::close() !!}

        @include('widgets._loot_select_row', ['showLootTables' => true, 'showRaffles' => true])
    @endif



    {!! Form::close() !!}

    @if ($group->id)
        <h3>Preview</h3>
        <div class="card mb-3">
            <div class="card-body">
                Preview here, create widget later
            </div>
        </div>
    @endif
@endsection

@section('scripts')
    @parent
    @include('js._loot_js', ['showLootTables' => true, 'showRaffles' => true])
    <script>
        $(document).ready(function() {
            $('.delete-group-button').on('click', function(e) {
                e.preventDefault();
                loadModal("{{ url('admin/data/reward-choices/delete') }}/{{ $group->id }}", 'Delete Choice Group');
            });
        });
    </script>
@endsection
