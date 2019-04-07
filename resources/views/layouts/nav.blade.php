<nav class="navbar" role="navigation" aria-label="main navigation">
  <div class="navbar-brand">
    <a class="navbar-item">
       Data Center Dashboard 
    {{-- <img src="{{ asset('img/logo.jpg') }}" alt="stanbic-app" width="112" height="28"> --}}
    </a>

    <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false">
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
    </a>
  </div>

  <div class="navbar-end">
    <span class="navbar-item">{{ today('D Y-m-d H:i') }}</span>
  </div>
</nav>