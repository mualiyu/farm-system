<!-- Footer-->
<footer class="content-footer footer bg-footer-theme">
  <div class="{{ (!empty($containerNav) ? $containerNav : 'container-fluid') }} d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
    <div class="mb-2 mb-md-0">
      © <script>
        document.write(new Date().getFullYear())
      </script>
      , made by <a href="{{ (!empty(config('variables.creatorUrl')) ? config('variables.creatorUrl') : 'mukeey.online') }}" target="_blank" class="footer-link fw-bolder">{{ (!empty(config('variables.creatorName')) ? config('variables.creatorName') : 'Usman Muktar') }}</a>
    </div>
    <div>
      <a href="{{ config('variables.licenseUrl') ? config('variables.licenseUrl') : '#' }}" class="footer-link me-4" target="_blank">License</a>
    </div>
  </div>
</footer>
<!--/ Footer-->
