@extends('layouts.app', [
    'namePage' => $listName,
    'class' => 'sidebar-mini',
    'activePage' => 'users',
    'activeNav' => '',
])

@section('content')
  <div class="panel-header">
  </div>
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
              @if ($listName == "All Users")
                  <a class="btn btn-primary btn-round text-white pull-right" href="{{ route('user.create') }}">{{ __('Add user') }}</a>
              @endif
            <h4 class="card-title">{{ __($listName) }}</h4>
            <div class="col-12 mt-2">
              @include('alerts.success')
              @include('alerts.errors')
            </div>
          </div>
          <div class="card-body">
              @if (isset($users) && !$users->isEmpty())
            <div class="toolbar">
                <form method="post" action="{{ route('user.search') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="input-group no-border">
                        <input type="text" name="phrase" value="{{ old('phrase') }}" class="mt-2 p-sm-3 pl-sm-4 form-control" placeholder="Search Users...">
                        <div class="input-group-append">
                            <div class="input-group-text mt-2">
                                <i class="now-ui-icons ui-1_zoom-bold"></i>
                            </div>
                        </div>
                    </div>
                    <div class="form-check form-check-radio">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="search_by" id="radio_name" value="name" checked />
                            <span class="form-check-sign"></span>
                            Search By Name
                        </label>
                    </div>

                    <div class="form-check form-check-radio">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="search_by" id="radio_email" value="email">
                            <span class="form-check-sign"></span>
                            Search By Email
                        </label>
                    </div>
                    <input hidden name="is_active" @if ($listName == "Active Users") value="1" @elseif ($listName == "Inactive Users") value="-1" @endif>
                    <button type="submit" class="btn btn-primary btn-round">Search</button>
                </form>
            </div>
            <table id="datatable" class="table table-striped table-bordered my-3" cellspacing="0" width="100%">
              <thead>
                <tr class="text-center">
                  <th>{{ __('Avatar') }}</th>
                  <th>{{ __('Name') }}</th>
                  <th>{{ __('Email') }}</th>
                  <th>{{ __('Creation date') }}</th>
                  <th>{{ __('Is Guest') }}</th>
                  <th class="disabled-sorting text-right">{{ __('Actions') }}</th>
                </tr>
              </thead>
              <tfoot>
                <tr class="text-center">
                  <th>{{ __('Avatar') }}</th>
                  <th>{{ __('Name') }}</th>
                  <th>{{ __('Email') }}</th>
                  <th>{{ __('Creation date') }}</th>
                  <th>{{ __('Is Guest') }}</th>
                  <th class="disabled-sorting text-right">{{ __('Actions') }}</th>
                </tr>
              </tfoot>
              <tbody>
                @foreach($users as $user)
                  <tr class="text-center">
                    <td>
                      <span class="avatar avatar-sm rounded-circle">
                        <img src="{{asset('assets')}}/img/default-avatar.png" alt="" style="max-width: 80px; border-radiu: 100px">
                      </span>
                    </td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                      <td>@if ($user->is_guest == 1) true @else false @endif</td>
                      <td class="text-center">
                      @if($user->id!=auth()->user()->id)
                        <a type="button" href="{{route("user.edit",$user)}}" rel="tooltip" class="btn btn-success btn-icon btn-sm " data-original-title="" title="">
                          <i class="now-ui-icons ui-2_settings-90"></i>
                        </a>
                      <form action="{{ route('user.destroy', $user) }}" method="post" style="display:inline-block;" class ="delete-form">
                        @csrf
                        @method('delete')
                        <button type="button" rel="tooltip" class="btn btn-danger btn-icon btn-sm delete-button" data-original-title="" title="" onclick="confirm('{{ __('Are you sure you want to delete this user?') }}') ? this.parentElement.submit() : ''">
                          <i class="now-ui-icons ui-1_simple-remove"></i>
                        </button>
                      </form>
                    @else
                      <a type="button" href="{{ route('profile.edit') }}" rel="tooltip" class="btn btn-success btn-icon btn-sm " data-original-title="" title="">
                        <i class="now-ui-icons ui-2_settings-90"></i>
                      </a>
                    @endif
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
              <div class="pagination justify-content-center py-3">
                  {{ $users->render() }}
              </div>
              @else
                  <h4 class="py-sm-2 text-primary text-center">The requested list is empty!!</h4>
              @endif
          </div>
          <!-- end content-->
        </div>
        <!--  end card  -->
      </div>
      <!-- end col-md-12 -->
    </div>
    <!-- end row -->
  </div>
@endsection

@push('js')
  <script>
    $(document).ready(function() {
      $(".delete-button").click(function(){
        var clickedButton = $( this );
        Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        confirmButtonText: 'Yes, delete it!',
        buttonsStyling: false
      }).then((result) => {
        if (result.value) {
          clickedButton.parents(".delete-form").submit();
        }
      })

      })
      $('#datatable').DataTable({
        "pagingType": "full_numbers",
        "lengthMenu": [
          [10, 25, 50, -1],
          [10, 25, 50, "All"]
        ],
        responsive: true,
        language: {
          search: "_INPUT_",
          searchPlaceholder: "Search records",
        }

      });

      var table = $('#datatable').DataTable();

      // Edit record
      table.on('click', '.edit', function() {
        $tr = $(this).closest('tr');
        if ($($tr).hasClass('child')) {
          $tr = $tr.prev('.parent');
        }

        var data = table.row($tr).data();
        alert('You press on Row: ' + data[0] + ' ' + data[1] + ' ' + data[2] + '\'s row.');
      });

      // Delete a record
      table.on('click', '.remove', function(e) {
        $tr = $(this).closest('tr');
        if ($($tr).hasClass('child')) {
          $tr = $tr.prev('.parent');
        }
        table.row($tr).remove().draw();
        e.preventDefault();
      });

      //Like record
      table.on('click', '.like', function() {
        alert('You clicked on Like button');
      });
    });
  </script>
@endpush
