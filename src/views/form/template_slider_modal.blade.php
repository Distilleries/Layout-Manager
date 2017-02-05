<div id="sliderModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-group" v-for="tag in inputs">
                    <label for="title" class="control-label col-md-3">@{{tag.trans}}</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <input class="form-control" id="slide_tag_@{{tag.id}}" name="slide_tag_@{{tag.id}}" v-model="tag[value]" type="upload">
                            <span class="input-group-btn">
                                  <button type="button" class="btn blue" onclick="moxman.browse({extensions: 'png,jpg,jpeg ',fields: 'slide_tag_@{{tag.id}} ',no_host: true});">
                                      <i class="glyphicon glyphicon-upload"></i>
                                      <span>Choisir fichier</span>
                                  </button>
                            </span>
                        </div>
                        <span class="help-block">Uniquement des fichiers au format JPG, JPEG ou PNG </span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="title" class="control-label col-md-3"></label>
                    <div class="col-md-9">
                        <button type="button" class="btn blue" v-on:click.prevent="addSlide()">
                            Ajouter
                        </button>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <div class="sortable">
                            <div class="sortable-slide-container" v-if="slides" v-for="(key, slide) in slides">
                                <div class="sortable-slide" v-html="showSlideWithContainer(slide)">
                                </div>
                                <div class="remove-slide" v-on:click="remove(key)"><span class="fa fa-close"></span></div>
                            </div>
                        </div>
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

