<!-- Edite Menu dialog -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <?php
            echo $this->Form->create(null, [
                'url'   => ['controller' => 'Menus', 'action' => 'edit'],
                'class' => 'form-horizontal',
                'role'  => 'form',
            ]);
            ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">&times;
                </button>
                <h4 class="modal-title">Edit Menu</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="title"
                           class="col-lg-2 control-label">Name</label>
                    <div class="col-lg-10">
                        <input type="text" id="editInputName" name="name"
                               value=""
                               class="form-control"/>
                    </div>
                </div>
                <div class="form-group show_url">
                    <label for="url"
                           class="col-lg-2 control-label">URL</label>
                    <div class="col-lg-10">
                        <input type="text" id="url" name="url" value=""
                               class="form-control"/>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                    <span class="prompt-msg text-danger"
                          style="display:none;"></span>
                <input type="hidden" name="id" value=""/>
                <button type="button" class="btn btn-default"
                        data-dismiss="modal">Cancle
                </button>
                <button id="editButton" type="button" class="btn btn-primary">
                    Save
                </button>
            </div>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>
