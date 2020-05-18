@if (isset($quotes))
    <div class="col py-md-5">
    <table class="table">
        <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Text</th>
            <th scope="col">Author</th>
            <th scope="col">Active</th>
        </tr>
        </thead>
        <tbody>
        @foreach($quotes as $quote)
            <tr>
                <th scope="row">{{ $quote->id }}</th>
                <td>{{ $quote->text }}</td>
                <td>{{ $quote->author }}</td>
                <td>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input position-static" id="is_active" @if ($quote->active == 1) checked @endif>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    </div>
@else
    <div class="col py-md-5">
        <h4>There is no Quote!!</h4>
    </div>
@endif
