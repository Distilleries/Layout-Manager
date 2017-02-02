@if (empty($categories))
    <div class="tab-pane active" >
@else
    <div class="tab-pane {{$category == array_first($categories) ? 'active' : ''}}" data-category="{{$key}}" id="{{$key}}">
@endif
    @if (!isset($disableAdd) || !$disableAdd)
        <div class="portlet light bordered add-template">
            <div class="portlet-title">
                <div class="caption font-green-sharp">
                    <i class="icon-speech font-green-sharp"></i>
                    <span class="caption-subject">Ajouter un template: </span>
                </div>
                <div class="actions">
                    <select class="template-select form-control" {{isset($key) ? 'data-category="'.$key.'"' : ''}}>
                        @foreach($templates as $template)
                            <option value="{{$template->id}}">{{$template->libelle}}</option>
                        @endforeach
                    </select>
                    <button type="button" class="btn btn-circle btn-icon-only btn-default btn-valid-add">
                        <i class="fa fa-check"></i>
                    </button>
                </div>
            </div>
        </div>
    @endif
    <portlet-panel :panel="panel" v-for="(index, panel) in panels"  {!! isset($key) ? 'v-if="panel.pivot.category == \'' . $key . '\'"' : 'v-if="true"' !!}></portlet-panel>
</div>