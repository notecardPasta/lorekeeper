<div class="card">
    <div class="card-body">
        <h4>Default Prompt Rewards</h4>
        @if (isset($staffView) && $staffView)
            <p>For reference, these are the default rewards for this prompt. The editable section above is <u>inclusive</u> of these rewards.</p>
            @if ($count)
                <p>This user has completed this prompt <strong>{{ $count }}</strong> time{{ $count == 1 ? '' : 's' }}.</p>
            @endif
        @else
            <p>These are the default rewards for this prompt. The actual rewards you receive may be edited by a staff member during the approval process.</p>

            @if ($prompt->reward_description)
                {!! $prompt->reward_description !!}
            @endif

            @if ($count)
                <p>You have completed this prompt <strong>{{ $count }}</strong> time{{ $count == 1 ? '' : 's' }}.</p>
            @endif
        @endif
        <table class="table table-sm mb-0">
            <thead>
                <tr>
                    <th width="70%">Reward</th>
                    <th width="30%">Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($prompt->rewards as $reward)
                    <tr>
                        <td>{!! $reward->reward->displayName !!}</td>
                        <td>{{ $reward->quantity }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@if (count($prompt->reward_choices))
    <br>
    <div class="card">
        <div class="card-header h2">
            Reward Choice
        </div>
        <div class="card-body">
            <p>Choose from the following options, if applicable. Your chosen reward will be rolled on the first character
                you attach, so make sure it's one you own!</p>

            <div class="row">
                @foreach ($prompt->reward_choices as $choice)
                    <div class="col-sm">
                        <div class="choice-box card mb-3" data-choice="{!! $choice->group->id !!}">
                            <div class="card-body">
                                <h4 style="display: inline;">{!! $choice->group->name !!}</h4> <span class="selected-choice"></span>
                                {!! $choice->group->description !!}
                            </div>
                        </div>
                    </div>
                @endforeach

                {!! Form::hidden('reward_choice', null, ['id' => 'rewardChoice']) !!}
            </div>
            <div class="text-right">
                <a href="#" class="btn btn-danger mr-2" id="clearChoice">Clear Choice</a>
            </div>
        </div>
    </div>
@endif

<script>
    $(document).ready(function() {
        @if (!empty($submission->data['reward_choice']))
            $('[data-choice=' + {{ $submission->data['reward_choice'] }} + ']').toggleClass('alert-info');
            $('#rewardChoice').val({{ $submission->data['reward_choice'] }});
        @endif



        $('.choice-box').on('click', function(e) {
            console.log('haii');
            $('.selected-choice').text('');
             $(this).find('.selected-choice').text('( Chosen! )');            
            $('.choice-box').removeClass('alert-info');            
            if (!$(this).hasClass('alert-info')) {
                $(this).toggleClass('alert-info');                
            }
            var choice = $(this).data("choice");
            $('#rewardChoice').val(choice);
        });
        $('#clearChoice').on('click', function(e) {
            e.preventDefault();
            $('.choice-box').removeClass('alert-info');
            $('#rewardChoice').val('');
        });
    });
</script>
