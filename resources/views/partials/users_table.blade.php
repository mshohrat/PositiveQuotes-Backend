@if (isset($users))
    <div class="col py-md-5">
    <table class="table">
        <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Guest</th>
            <th scope="col">Active</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr class="list-group-item-action" onclick="window.location='{{ url('/profile/'.$user->id) }}'">
                <th scope="row">{{ $user->id }}</th>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                @if ($user->is_guest == 1)
                    <td>true</td>
                @else
                    <td>false</td>
                @endif
                <td>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input position-static" id="is_active" @if ($user->is_active == 1) checked @endif>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    </div>
@else
    <div class="col py-md-5">
        <h4>There is no registered User!!</h4>
    </div>
@endif
