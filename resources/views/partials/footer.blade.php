<footer class="page-footer font-small">
    <div class="footer-copyright text-center py-1">
        <small>
            Copyright &copy; 2021{{ now()->year === 2021 ? '' : '-' . now()->year }}
            <a href="{{ url('/') }}">
                @lang('messages.app_name')
            </a>
            | @lang('messages.footer_rights')
            | @lang('messages.created_by') <a id="created-by" href="" data-toggle="popover" title="Jiří Pešek"
                data-content='
                <div class="text-left">
                    <i class="fas fa-phone"></i>&nbsp;&nbsp;&nbsp;+420 721 455 588<br />
                    <i class="far fa-envelope"></i>&nbsp;&nbsp;&nbsp;pesek.jirka<i class="fas fa-at"></i>centrum.cz
                </div>
            '>Jiří Pešek</a>
        </small>
    </div>
</footer>