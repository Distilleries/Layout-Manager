<div class="portlet portlet-sortable light bordered" :id="guid">
    <div class="portlet-title">
        <div class="caption font-green-sharp">
            <i class="icon-speech font-green-sharp"></i>
            <span class="caption-subject">  @{{panel.libelle}}</span>
        </div>
        <div class="actions">
            <button type="button" class="btn btn-circle red-sunglo " v-on:click='remove()'>
                <i class="fa fa-close"></i> Supprimer </button>
            <button type="button" class="btn btn-circle btn-default" v-on:click='duplicate()'>
                <i class="fa fa-clone"></i> Dupliquer
            </button>
            <button type="button" class="btn btn-circle btn-default" v-on:click='reset()' >
                <i class="fa fa-eraser"></i> Reset
            </button>
            <button type="button" class="btn btn-circle btn-icon-only btn-default btn-draggable ">
                <i class="fa fa-arrows"></i>
            </button>
            <button type="button" class="btn btn-circle btn-icon-only btn-default fullscreen">
            </button>
        </div>
    </div>
    <div class="portlet-body">
        <div class="templatable" v-html="panel.pivot.html" :class="panel.css_class">

        </div>
    </div>
</div>