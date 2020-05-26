<div id="sidebar" class="sidebar"  style="position: fixed;left:auto; right: 0; top: 0;bottom: 0;" data-color="blue">
  <!--
    Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
-->
  <div class="logo">
{{--    <a href="http://www.creative-tim.com" class="simple-text logo-mini">--}}
{{--      {{ __('CT') }}--}}
{{--    </a>--}}
    <a href="{{ route('home') }}" class="simple-text text-capitalize logo-normal text-center mt-2" style="font-size: 16px;">
        <strong>{{ config('app.name') }}</strong>
    </a>
  </div>
  <div class="sidebar-wrapper mt-2" id="sidebar-wrapper">
    <ul class="nav">
      <li class="text-left @if ($activePage == 'home') active @endif">
        <a href="{{ route('home') }}">
          <i class="float-right now-ui-icons design_app"></i>
            <p class="ml-3" style="font-size: 12px;">@if ($activePage == 'home')<strong>@endif{{ __('Home') }}@if ($activePage == 'home')</strong>@endif</p>
        </a>
      </li>
      <li>
        <a data-toggle="collapse" href="#users">
          <p class="px-3 text-left" style="font-size: 12px;">
              {{ __("Users") }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse @if($namePage == 'All Users' || $namePage == 'Active Users' || $namePage == 'Inactive Users') show @endif" id="users">
          <ul class="nav">
            <li class="text-left @if ($namePage == 'All Users') active @endif">
              <a href="{{ route('user.index') }}">
                <i class="float-right now-ui-icons users_circle-08"></i>
                  <p class="ml-3" style="font-size: 11px;">@if ($namePage == 'All Users')<strong>@endif{{ __("All Users") }}@if ($namePage == 'All Users')</strong>@endif</p>
              </a>
            </li>
            <li class="text-left @if ($namePage == 'Active Users') active @endif">
              <a href="{{ route('user.active_users') }}">
                <i class="float-right now-ui-icons emoticons_satisfied"></i>
                  <p class="ml-3" style="font-size: 11px;">@if ($namePage == 'Active Users')<strong>@endif{{ __("Active Users") }}@if ($namePage == 'Active Users')</strong>@endif</p>
              </a>
            </li>
              <li class="text-left @if ($namePage == 'Inactive Users') active @endif">
                  <a href="{{ route('user.inactive_users') }}">
                      <i class="float-right now-ui-icons ui-1_simple-delete"></i>
                      <p class="ml-3" style="font-size: 11px;">@if ($namePage == 'Inactive Users')<strong>@endif{{ __("Inactive Users") }}@if ($namePage == 'Inactive Users')</strong>@endif</p>
                  </a>
              </li>
          </ul>
        </div>
      </li>
      <li>
        <li>
            <a data-toggle="collapse" href="#quotes">
                <p class="px-3 text-left" style="font-size: 12px;">
                    {{ __("Quotes") }}
                    <b class="caret"></b>
                </p>
            </a>
            <div class="collapse @if($namePage == 'All Quotes' || $namePage == 'Verified Quotes' || $namePage == 'Pending Quotes' || $namePage == 'Edit Quote' || $namePage == 'Create Quote') show @endif" id="quotes">
                <ul class="nav">
                    <li class="text-left @if ($namePage == 'All Quotes') active @endif">
                        <a href="{{ route('quote.quotes') }}">
                            <i class="float-right now-ui-icons ui-2_chat-round"></i>
                            <p class="ml-3" style="font-size: 11px;">@if ($namePage == 'All Quotes')<strong>@endif{{ __("All Quotes") }}@if ($namePage == 'All Quotes')</strong>@endif</p>
                        </a>
                    </li>
                    <li class="text-left @if ($namePage == 'Verified Quotes') active @endif">
                        <a href="{{ route('quote.verified_quotes') }}">
                            <i class="float-right now-ui-icons ui-2_like"></i>
                            <p class="ml-3" style="font-size: 11px;">@if ($namePage == 'Verified Quotes')<strong>@endif{{ __("Verified Quotes") }}@if ($namePage == 'Verified Quotes')</strong>@endif</p>
                        </a>
                    </li>
                    <li class="text-left @if ($namePage == 'Pending Quotes') active @endif">
                        <a href="{{ route('quote.pending_quotes') }}">
                            <i class="float-right now-ui-icons tech_watch-time"></i>
                            <p class="ml-3" style="font-size: 11px;">@if ($namePage == 'Pending Quotes')<strong>@endif{{ __("Pending Quotes") }}@if ($namePage == 'Pending Quotes')</strong>@endif</p>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
{{--        <li class="@if ($activePage == 'icons') active @endif">--}}
{{--        <a href="{{ route('page.index','icons') }}">--}}
{{--          <i class="now-ui-icons education_atom"></i>--}}
{{--          <p>{{ __('Icons') }}</p>--}}
{{--        </a>--}}
{{--      </li>--}}
{{--      <li class = "@if ($activePage == 'maps') active @endif">--}}
{{--        <a href="{{ route('page.index','maps') }}">--}}
{{--          <i class="now-ui-icons location_map-big"></i>--}}
{{--          <p>{{ __('Maps') }}</p>--}}
{{--        </a>--}}
{{--      </li>--}}
{{--      <li class = " @if ($activePage == 'notifications') active @endif">--}}
{{--        <a href="{{ route('page.index','notifications') }}">--}}
{{--          <i class="now-ui-icons ui-1_bell-53"></i>--}}
{{--          <p>{{ __('Notifications') }}</p>--}}
{{--        </a>--}}
{{--      </li>--}}
{{--      <li class = " @if ($activePage == 'table') active @endif">--}}
{{--        <a href="{{ route('page.index','table') }}">--}}
{{--          <i class="now-ui-icons design_bullet-list-67"></i>--}}
{{--          <p>{{ __('Table List') }}</p>--}}
{{--        </a>--}}
{{--      </li>--}}
{{--      <li class = "@if ($activePage == 'typography') active @endif">--}}
{{--        <a href="{{ route('page.index','typography') }}">--}}
{{--          <i class="now-ui-icons text_caps-small"></i>--}}
{{--          <p>{{ __('Typography') }}</p>--}}
{{--        </a>--}}
{{--      </li>--}}
    </ul>
  </div>
</div>
