@extends('admin.layout')

@section('admin-title')
    Reward Choices
@endsection

@section('admin-content')
    {!! breadcrumbs(['Admin Panel' => 'admin', 'Reward Choice Groups' => 'admin/data/reward-choices']) !!}

    <h1>Reward Choices</h1>

    <p>This is a list of groups of rewards that admin can attach to a prompt. A player can pick between each group added to a prompt, and <b>all</b> the loot within the selected group will be rolled for the character.</p>

    <div class="text-right mb-3"><a class="btn btn-primary" href="{{ url('admin/data/reward-choices/create') }}"><i class="fas fa-plus"></i> Create New Reward Choice Group</a></div>
    @if (!count($groups))
        <p>No reward groups found.</p>
    @else
        <table class="table table-sm category-table">
            <tbody>
                @foreach ($groups as $group)
                    <tr>
                        <td>
                            {!! $group->name !!}
                        </td>
                        <td class="text-right">
                            <a href="{{ url('admin/data/reward-choices/edit/' . $group->id) }}" class="btn btn-primary">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>
    @endif

@endsection
