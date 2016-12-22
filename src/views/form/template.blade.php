<div class="form-group" id="template">
    <div class="col-md-12 text-center" style="">
        <div class="row">
            @if (empty($options['categories']))
                <div class="col-md-12 col-sm-12 col-xs-12 sortable {{ (isset($noEdit) && $noEdit === true ? 'no-edit' : '') }}">
            @else
                <div class="col-md-3 col-sm-3 col-xs-3">
                    <ul class="nav nav-tabs tabs-left">
                        @foreach($options['categories'] as $key => $cat)
                            <li class="{{$cat == array_first($options['categories']) ? 'active' : ''}}">
                                <a href="#{{$key}}" data-toggle="tab">
                                    {{$cat}} </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-md-9 col-sm-9 col-xs-9 sortable {{ (isset($noEdit) && $noEdit === true ? 'no-edit' : '') }}">
            @endif
                <div class="tab-content">
                    @if (empty($options['categories']))
                        @include ('layout-manager::form.template_add', ['categories' => [], 'templates' => $options['templates']])
                    @else
                        @foreach($options['categories'] as $key => $cat)
                            @include ('layout-manager::form.template_add', ['categories' => $options['categories'], 'templates' => $options['templates'], 'key' => $key, 'category' => $cat])
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
    <input-modal v-if="panels" ></input-modal>
</div>


<div id="confirmationModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                Êtes-vous sur de vouloir faire cette action ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                <button type="button" id='confirmationButton' data-dismiss="modal" class="btn btn-primary">Oui</button>
            </div>
        </div>
    </div>
</div>
<script type="x/template" id='portlet-template'>
@include ('admin.form.template_portlet')
</script>
<script type="x/template" id='input-modal'>
@include ('admin.form.template_input_modal')
</script>

<script>
    // @TODO: Get these through an AJAX call instead
    window.templatables = {!! json_encode($options['templatable']->templates) !!};
    window.templatable_id = {!! json_encode($options['templatable']->id) !!};
    window.templatable_type = {!! json_encode(get_class($options['templatable'])) !!};
    window.templates = {!! json_encode($options['templates']) !!};
    <?php
            if (key_exists('custom-tags', $options)) {
                foreach ($options['custom-tags'] as $key => $tag) {
                    $translatedArguments = [];
                    foreach ($tag as $argument) {
                        $translatedArguments[$argument] = trans('forms.template.'. $argument);
                    }
                    $options['custom-tags'][$key] = $translatedArguments;
                }
            }
            ?>
    window.customTags = {!! json_encode($options['custom-tags']) !!};
    window.categories = {!! json_encode($options['categories']) !!};
</script>