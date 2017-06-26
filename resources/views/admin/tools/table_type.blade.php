<div class="btn-group" data-toggle="buttons">
    @foreach($options as $option => $label)
        <label class="btn btn-default btn-sm {{ request('type', 'all') == $option ? 'active' : '' }}">
            <input type="radio" class="table-type" value="{{ $option }}">{{$label}}
        </label>
    @endforeach
</div>