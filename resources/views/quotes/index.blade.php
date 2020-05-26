@extends('layouts.app', [
    'namePage' => $listName,
    'class' => 'sidebar-mini',
    'activePage' => 'quotes',
  ])

@section('content')
  <div class="panel-header panel-header-sm">
  </div>
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">{{ __($listName) }}</h4>
              <div class="col-12 mt-2">
                  @include('alerts.success')
                  @include('alerts.errors')
              </div>
          </div>
          <div class="card-body">
            @if (isset($quotes) && !$quotes->isEmpty())
            <div class="toolbar">
                <form method="post" action="{{ route('quote.search') }}" enctype="multipart/form-data">
                          @csrf
                          <div class="input-group no-border">
                              <input type="text" name="phrase" value="{{ old('phrase') }}" class="mt-2 p-sm-3 pl-sm-4 form-control" placeholder="Search Quotes...">
                              <div class="input-group-append">
                                  <div class="input-group-text mt-2">
                                      <i class="now-ui-icons ui-1_zoom-bold"></i>
                                  </div>
                              </div>
                          </div>
                          <div class="form-check form-check-radio">
                              <label class="form-check-label">
                                  <input class="form-check-input" type="radio" name="search_by" id="radio_text" value="text" checked />
                                  <span class="form-check-sign"></span>
                                  Search By Text
                              </label>
                          </div>

                          <div class="form-check form-check-radio">
                              <label class="form-check-label">
                                  <input class="form-check-input" type="radio" name="search_by" id="radio_author" value="author">
                                  <span class="form-check-sign"></span>
                                  Search By Author
                              </label>
                          </div>
                          <input hidden name="is_active" @if ($listName == "Verified Quotes") value="1" @elseif ($listName == "Pending Quotes") value="-1" @endif>
                          <button type="submit" class="btn btn-primary btn-round">Search</button>
                      </form>
            </div>
            <div class="table-responsive">
              <table class="table">
                <thead class="text-primary">
                  <th>
                    ID
                  </th>
                  <th>
                    TEXT
                  </th>
                  <th>
                    AUTHOR
                  </th>
                  <th>
                      CREATION
                  </th>
                  <th class="disabled-sorting text-right">ACTIONS</th>
                </thead>
                <tbody>
                @foreach($quotes as $quote)
                    <tr>
                        <td>
                            {{$quote->id}}
                        </td>
                        <td>
                            {{$quote->text}}
                        </td>
                        <td>
                            {{$quote->author}}
                        </td>
                        <td>
                            {{ $quote->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td>
                            <a type="button" href="{{ route('quote.edit',$quote) }}" rel="tooltip" class="btn btn-success btn-icon btn-sm " data-original-title="" title="">
                                <i class="now-ui-icons ui-2_settings-90"></i>
                            </a>
                            <form action="{{ route('quote.destroy', $quote) }}" method="post" style="display:inline-block;" class ="delete-form">
                                @csrf
                                @method('delete')
                                <button type="button" rel="tooltip" class="btn btn-danger btn-icon btn-sm delete-button" data-original-title="" title="" onclick="confirm('{{ __('Are you sure you want to delete this quote?') }}') ? this.parentElement.submit() : ''">
                                    <i class="now-ui-icons ui-1_simple-remove"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
              </table>
                <div class="pagination justify-content-center py-3">
                    {{ $quotes->render() }}
                </div>
            </div>
            @else
                  <h4 class="py-sm-2 text-primary text-center">The requested list is empty!!</h4>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
