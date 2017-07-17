<div id="inputModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-group" v-for="tag in tags">
                    <label for="title" class="control-label col-md-3">@{{tag.trans}}</label>
                    <div class="col-md-9">
                        <input class="form-control  validate[required]" id="@{{tag.id}}" name="templatable[@{{tag.id}}]" type="text" v-model="tag.value">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                <button type="button" id='inputModalButton' v-on:click='save()' data-dismiss="modal" class="btn btn-primary">Sauvegarder</button>
            </div>
        </div>
    </div>
</div>
