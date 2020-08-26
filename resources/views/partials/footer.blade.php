<footer class="page-footer font-small">
    <div class="footer-copyright text-center py-1">
        <small>
            &copy; {{ now()->year }}
            <a href="{{ url('/') }}">
                @lang('messages.app_name')
            </a>
            | @lang('messages.footer_rights')
            | @lang('messages.created_by') <a id="created-by" href="" data-toggle="tooltip" data-placement="top"
                title="pesek.jirka at centrum.cz" data-delay='{"show":"200", "hide":"100"}'>Jiří Pešek</a>
        </small>
    </div>
</footer>