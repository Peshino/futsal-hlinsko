<button class="crud-button" type="button" data-toggle="modal" data-target="#modal-delete">
    <i class="far fa-trash-alt"></i>
</button>

<div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="modal-delete-title"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content app-bg">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-delete-title">
                    @lang('messages.really_delete')
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-app">
                    @lang('messages.delete')
                </button>
            </div>
        </div>
    </div>
</div>