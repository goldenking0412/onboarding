<p class="mb-2 @if(is_null($answer) or !$answer->is_complete) text-black-25 @endif">
    <i class="pr-2 fa fa-check-circle
        @if(!is_null($answer) and $answer->is_complete)
            text-success
        @else
            text-black-25
        @endif
    "></i>
    {{$i}}. {{ucfirst($service['name'])}} Account Setup
</p>